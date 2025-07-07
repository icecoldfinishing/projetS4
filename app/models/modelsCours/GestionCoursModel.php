<?php
namespace app\models\modelsCours;
use PDO;
use Exception;

class GestionCoursModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getElevesAyantPaye($mois, $annee) {
        $sql = "SELECT id_eleve
                FROM ecolage
                WHERE mois = :mois AND annee = :annee
                ORDER BY date_paiement ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':mois' => $mois,
            ':annee' => $annee
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function assignerGroupesEleves($mois, $annee) {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->query("SELECT nombre_eleve_cours FROM maximum LIMIT 1");
            $maxParGroupe = $stmt->fetchColumn();
            if (!$maxParGroupe) $maxParGroupe = 20;

            // Récupérer les groupes existants pour ce mois/année
            $stmt = $this->pdo->prepare("SELECT groupe, COUNT(*) as total FROM gestion_groupe 
                                        WHERE mois = :mois AND annee = :annee
                                        GROUP BY groupe ORDER BY groupe ASC");
            $stmt->execute([':mois' => $mois, ':annee' => $annee]);
            $groupesExistants = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // [groupe => total]

            // Initialiser le groupe de départ
            $groupe = 1;
            $count = 0;
            if (!empty($groupesExistants)) {
                $groupe = max(array_keys($groupesExistants));
                $count = $groupesExistants[$groupe];
                if ($count >= $maxParGroupe) {
                    $groupe++;
                    $count = 0;
                }
            }

            // Récupérer les élèves ayant payé via la fonction
            $eleves = $this->getElevesAyantPaye($mois, $annee);

            foreach ($eleves as $eleve) {
                $id_eleve = $eleve['id_eleve'];

                // Vérifier si déjà assigné
                $check = $this->pdo->prepare("SELECT 1 FROM gestion_groupe WHERE id_eleve = :id AND mois = :mois AND annee = :annee");
                $check->execute([':id' => $id_eleve, ':mois' => $mois, ':annee' => $annee]);
                if ($check->fetch()) continue;

                // Assigner dans le groupe courant
                $insert = $this->pdo->prepare("INSERT INTO gestion_groupe (id_eleve, mois, annee, groupe)
                                            VALUES (:id_eleve, :mois, :annee, :groupe)");
                $insert->execute([
                    ':id_eleve' => $id_eleve,
                    ':mois' => $mois,
                    ':annee' => $annee,
                    ':groupe' => $groupe
                ]);

                $count++;
                if ($count >= $maxParGroupe) {
                    $groupe++;
                    $count = 0;
                }
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur assignation groupes : " . $e->getMessage());
            return false;
        }
    }

    public function planifierCoursDuJour($date) {
        try {
            $this->pdo->beginTransaction();

            // Supprimer les planifications existantes de ce jour
            $delete = $this->pdo->prepare("
                DELETE FROM planification_cours
                WHERE id_seance IN (
                    SELECT id_seances FROM seances_cours WHERE date = :date
                )
            ");
            $delete->execute([':date' => $date]);

            // Récupérer les groupes existants pour le mois/année de la date
            $mois = date('n', strtotime($date));
            $annee = date('Y', strtotime($date));

            $stmt = $this->pdo->prepare("
                SELECT DISTINCT groupe FROM gestion_groupe
                WHERE mois = :mois AND annee = :annee
                ORDER BY groupe ASC
            ");
            $stmt->execute([':mois' => $mois, ':annee' => $annee]);
            $groupes = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $nbGroupes = count($groupes);

            if ($nbGroupes === 0) throw new Exception("Aucun groupe trouvé pour la date.");

            // Récupérer les séances du jour
            $stmt = $this->pdo->prepare("
                SELECT id_seances FROM seances_cours
                WHERE date = :date
                ORDER BY id_plage ASC
            ");
            $stmt->execute([':date' => $date]);
            $seances = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $nbSeances = count($seances);

            if ($nbSeances < 2) throw new Exception("Pas assez de séances pour planifier.");

            // Affectation manuelle inchangée
            if ($nbGroupes === 1) {
                for($i=0; $i<4; $i=$i+3) {
                    if (isset($seances[$i])) {
                        $this->insererPlanification($seances[$i], 1);
                    }
                }
            } elseif ($nbGroupes === 2 && $nbSeances >= 4) {
                $this->insererPlanification($seances[0], 1);
                $this->insererPlanification($seances[1], 2);
                $this->insererPlanification($seances[2], 2);
                $this->insererPlanification($seances[3], 1);
            } elseif ($nbGroupes === 3 && $nbSeances >= 6) {
                $this->insererPlanification($seances[0], 1);
                $this->insererPlanification($seances[1], 2);
                $this->insererPlanification($seances[2], 2);
                $this->insererPlanification($seances[3], 1);
                $this->insererPlanification($seances[4], 3);
                $this->insererPlanification($seances[7], 3);
            } elseif ($nbGroupes === 4 && $nbSeances >= 8) {
                $this->insererPlanification($seances[0], 1);
                $this->insererPlanification($seances[1], 2);
                $this->insererPlanification($seances[2], 2);
                $this->insererPlanification($seances[3], 1);
                $this->insererPlanification($seances[4], 3);
                $this->insererPlanification($seances[5], 4);
                $this->insererPlanification($seances[6], 4);
                $this->insererPlanification($seances[7], 3);
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur planification jour : " . $e->getMessage());
            return false;
        }
    }

    private function insererPlanification($id_seance, $groupe) {
        $stmt = $this->pdo->prepare("
            INSERT INTO planification_cours (id_seance, groupe)
            VALUES (:id_seance, :groupe)
            ON CONFLICT DO NOTHING
        ");
        $stmt->execute([
            ':id_seance' => $id_seance,
            ':groupe' => $groupe
        ]);
    }

    public function getCalendrierMensuel($mois, $annee) {
        $calendrier = [];

        for ($jour = 1; $jour <= 31; $jour++) {
            if (!checkdate($mois, $jour, $annee)) continue;
            $date = sprintf('%04d-%02d-%02d', $annee, $mois, $jour);

            // Groupes du jour
            $stmtG = $this->pdo->prepare("
                SELECT DISTINCT g.groupe
                FROM planification_cours pc
                JOIN seances_cours sc ON pc.id_seance = sc.id_seances
                JOIN gestion_groupe g ON pc.groupe = g.groupe
                WHERE sc.date = :date
            ");
            $stmtG->execute([':date' => $date]);
            $groupes = $stmtG->fetchAll(PDO::FETCH_COLUMN);

            // Séances du jour
            $stmtS = $this->pdo->prepare("
                SELECT sc.id_seances, c.label AS cours, ph.heure_debut, ph.heure_fin, p.nom, p.prenom
                FROM seances_cours sc
                JOIN cours c ON sc.id_cours = c.id_cours
                JOIN prof p ON sc.id_prof = p.id_prof
                JOIN plage_horaire ph ON sc.id_plage = ph.id
                WHERE sc.date = :date
                ORDER BY ph.heure_debut
            ");
            $stmtS->execute([':date' => $date]);
            $seances = $stmtS->fetchAll(PDO::FETCH_ASSOC);

            if ($groupes || $seances) {
                $calendrier[$jour] = [
                    'groupes' => $groupes,
                    'seances' => $seances
                ];
            }
        }

        return $calendrier;
    }

    public function getGroupesParJourDuMois($mois, $annee) {
    $calendrier = [];

    for ($jour = 1; $jour <= 31; $jour++) {
        if (!checkdate($mois, $jour, $annee)) continue;

        $date = sprintf('%04d-%02d-%02d', $annee, $mois, $jour);

        $this->planifierCoursDuJour($date);

        $stmt = $this->pdo->prepare("
            SELECT g.groupe
            FROM planification_cours pc
            JOIN seances_cours sc ON pc.id_seance = sc.id_seances
            JOIN gestion_groupe g ON g.groupe = pc.groupe
            WHERE sc.date = :date
            GROUP BY g.groupe
        ");
        $stmt->execute([':date' => $date]);
        $groupes = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($groupes) {
            $calendrier[$jour] = $groupes;
        }
    }

    return $calendrier;
}

    public function getElevesDuGroupeParDate($groupe, $date) {
        $mois = date('n', strtotime($date));
        $annee = date('Y', strtotime($date));

        $stmt = $this->pdo->prepare("
            SELECT e.nom, e.prenom
            FROM gestion_groupe g
            JOIN eleve e ON g.id_eleve = e.id_eleve
            WHERE g.groupe = :groupe
            AND g.mois = :mois AND g.annee = :annee
        ");
        $stmt->execute([
            ':groupe' => $groupe,
            ':mois' => $mois,
            ':annee' => $annee
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSeancesParJour($date) {
        $sql = "
            SELECT 
                pc.groupe,
                ph.heure_debut,
                ph.heure_fin,
                c.label AS cours,
                p.nom AS prof_nom,
                p.prenom AS prof_prenom
            FROM planification_cours pc
            JOIN seances_cours sc ON pc.id_seance = sc.id_seances
            JOIN plage_horaire ph ON sc.id_plage = ph.id
            JOIN cours c ON sc.id_cours = c.id_cours
            JOIN prof p ON sc.id_prof = p.id_prof
            WHERE sc.date = :date
            ORDER BY ph.heure_debut
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':date' => $date]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
