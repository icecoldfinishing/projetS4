<?php

namespace app\models\modelsCours;
use PDO;
use Exception;

class SeancesModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($id_cours, $date, $id_plage, $id_prof) {
        try {
            $this->pdo->beginTransaction();

            // Récupérer l'heure de début de la plage
            $stmt = $this->pdo->prepare("SELECT heure_debut FROM plage_horaire WHERE id = :id");
            $stmt->execute([':id' => $id_plage]);
            $heure_debut = $stmt->fetchColumn();

            $correspondances = [
                '08:00:00' => '10:00:00',
                '10:00:00' => '08:00:00',
                '13:00:00' => '15:00:00',
                '15:00:00' => '13:00:00'
            ];
            if (!isset($correspondances[$heure_debut])) {
                throw new Exception("Aucune plage parallèle définie pour $heure_debut.");
            }

            // Trouver l'ID de la plage parallèle
            $stmt2 = $this->pdo->prepare("SELECT id FROM plage_horaire WHERE heure_debut = :heure");
            $stmt2->execute([':heure' => $correspondances[$heure_debut]]);
            $id_plage_parallele = $stmt2->fetchColumn();
            if (!$id_plage_parallele) {
                throw new Exception("Impossible de trouver la plage parallèle.");
            }

            // Vérification : aucune des deux plages ne doit avoir plus de 2 séances non annulées
            foreach ([$id_plage, $id_plage_parallele] as $plage) {
                $check = $this->pdo->prepare("
                    SELECT COUNT(*) FROM seances_cours sc
                    WHERE sc.date = :date
                    AND sc.id_plage = :id_plage
                    AND NOT EXISTS (
                        SELECT 1 FROM historique_seances hs
                        WHERE hs.id_seances = sc.id_seances
                        AND hs.statut = 'annule'
                    )
                ");
                $check->execute([
                    ':date' => $date,
                    ':id_plage' => $plage
                ]);
                if ($check->fetchColumn() >= 2) {
                    $this->pdo->rollBack();
                    error_log("Création refusée : plage $plage saturée.");
                    return false;
                }
            }

            // Vérification : le prof ne doit pas enseigner dans une des deux plages à la même date
            foreach ([$id_plage, $id_plage_parallele] as $plage) {
                $verifProf = $this->pdo->prepare("
                    SELECT 1 FROM seances_cours sc
                    WHERE sc.date = :date
                    AND sc.id_plage = :id_plage
                    AND sc.id_prof = :id_prof
                    AND NOT EXISTS (
                        SELECT 1 FROM historique_seances hs
                        WHERE hs.id_seances = sc.id_seances
                        AND hs.statut = 'annule'
                    )
                    LIMIT 1
                ");
                $verifProf->execute([
                    ':date' => $date,
                    ':id_plage' => $plage,
                    ':id_prof' => $id_prof
                ]);
                if ($verifProf->fetch()) {
                    $this->pdo->rollBack();
                    error_log("Création refusée : le professeur enseigne déjà dans la plage $plage à cette date.");
                    return false;
                }
            }

            // Insertion première séance
            $stmtInsert1 = $this->pdo->prepare("
                INSERT INTO seances_cours (id_cours, date, id_plage, id_prof)
                VALUES (:id_cours, :date, :id_plage, :id_prof)
                RETURNING id_seances
            ");
            $stmtInsert1->execute([
                ':id_cours' => $id_cours,
                ':date' => $date,
                ':id_plage' => $id_plage,
                ':id_prof' => $id_prof
            ]);
            $id1 = $stmtInsert1->fetchColumn();

            // Insertion deuxième séance parallèle
            $stmtInsert2 = $this->pdo->prepare("
                INSERT INTO seances_cours (id_cours, date, id_plage, id_prof)
                VALUES (:id_cours, :date, :id_plage, :id_prof)
                RETURNING id_seances
            ");
            $stmtInsert2->execute([
                ':id_cours' => $id_cours,
                ':date' => $date,
                ':id_plage' => $id_plage_parallele,
                ':id_prof' => $id_prof
            ]);
            $id2 = $stmtInsert2->fetchColumn();

            // Historique des deux
            $hist = $this->pdo->prepare("
                INSERT INTO historique_seances (id_seances, date, statut)
                VALUES (:id_seances, CURRENT_DATE, 'cree')
            ");
            $hist->execute([':id_seances' => $id1]);
            $hist->execute([':id_seances' => $id2]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur création séance : " . $e->getMessage());
            return false;
        }
    }

    public function getAll() {
        $sql = "
            SELECT 
                sc.id_seances,
                sc.date,
                ph.heure_debut,
                ph.heure_fin,
                c.label AS nom_cours,
                p.nom AS nom_prof,
                p.prenom AS prenom_prof
            FROM seances_cours sc
            JOIN plage_horaire ph ON sc.id_plage = ph.id
            JOIN cours c ON sc.id_cours = c.id_cours
            JOIN prof p ON sc.id_prof = p.id_prof
            WHERE sc.id_seances NOT IN (
                SELECT id_seances
                FROM historique_seances
                WHERE statut = 'annule'
            )
            ORDER BY sc.date DESC, ph.heure_debut
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT sc.*, ph.heure_debut, ph.heure_fin
                FROM seances_cours sc
                JOIN plage_horaire ph ON sc.id_plage = ph.id
                WHERE sc.id_seances = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $id_cours, $date, $id_prof) {
        try {
            $this->pdo->beginTransaction();

            // Récupérer les infos actuelles de la séance principale
            $stmtCurrent = $this->pdo->prepare("SELECT id_plage, date, id_cours FROM seances_cours WHERE id_seances = :id");
            $stmtCurrent->execute([':id' => $id]);
            $current = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

            if (!$current) throw new Exception("Séance principale introuvable.");

            $id_plage = $current['id_plage'];
            $ancienne_date = $current['date'];
            $ancien_cours = $current['id_cours'];

            // Vérifier saturation de la plage principale
            $stmtCheck = $this->pdo->prepare("
                SELECT COUNT(*) FROM seances_cours sc
                WHERE sc.date = :date AND sc.id_plage = :id_plage AND sc.id_seances != :id
                AND NOT EXISTS (
                    SELECT 1 FROM historique_seances hs
                    WHERE hs.id_seances = sc.id_seances AND hs.statut = 'annule'
                )
            ");
            $stmtCheck->execute([':date' => $date, ':id_plage' => $id_plage, ':id' => $id]);
            if ($stmtCheck->fetchColumn() >= 2) {
                $this->pdo->rollBack();
                throw new Exception("Plage principale saturée.");
            }

            // Mise à jour de la séance principale
            $this->pdo->prepare("
                UPDATE seances_cours
                SET id_cours = :id_cours, date = :date, id_prof = :id_prof
                WHERE id_seances = :id
            ")->execute([
                ':id' => $id,
                ':id_cours' => $id_cours,
                ':date' => $date,
                ':id_prof' => $id_prof
            ]);

            $this->pdo->prepare("
                INSERT INTO historique_seances (id_seances, date, statut)
                VALUES (:id, CURRENT_DATE, 'modifie')
            ")->execute([':id' => $id]);

            // Identifier la plage parallèle
            $stmtHd = $this->pdo->prepare("SELECT heure_debut FROM plage_horaire WHERE id = :id");
            $stmtHd->execute([':id' => $id_plage]);
            $heure_debut = $stmtHd->fetchColumn();

            $map = [
                '08:00:00' => '10:00:00',
                '10:00:00' => '08:00:00',
                '13:00:00' => '15:00:00',
                '15:00:00' => '13:00:00'
            ];
            $heure_p = $map[$heure_debut] ?? null;

            if ($heure_p) {
                $stmtP = $this->pdo->prepare("SELECT id FROM plage_horaire WHERE heure_debut = :hd");
                $stmtP->execute([':hd' => $heure_p]);
                $id_plage_p = $stmtP->fetchColumn();

                if ($id_plage_p) {
                    // Rechercher la séance parallèle avec l'ancienne date et ancien cours
                    $stmtFind = $this->pdo->prepare("
                        SELECT sc2.id_seances FROM seances_cours sc2
                        WHERE sc2.date = :old_date
                        AND sc2.id_plage = :id_plage_p
                        AND sc2.id_cours = :old_cours
                        AND NOT EXISTS (
                            SELECT 1 FROM historique_seances hs
                            WHERE hs.id_seances = sc2.id_seances AND hs.statut = 'annule'
                        )
                        LIMIT 1
                    ");
                    $stmtFind->execute([
                        ':old_date' => $ancienne_date,
                        ':id_plage_p' => $id_plage_p,
                        ':old_cours' => $ancien_cours
                    ]);
                    $id_parallele = $stmtFind->fetchColumn();

                    if ($id_parallele) {
                        // Vérifier saturation de la plage parallèle
                        $stmtCheck2 = $this->pdo->prepare("
                            SELECT COUNT(*) FROM seances_cours sc
                            WHERE sc.date = :new_date AND sc.id_plage = :id_plage
                            AND sc.id_seances != :id
                            AND NOT EXISTS (
                                SELECT 1 FROM historique_seances hs
                                WHERE hs.id_seances = sc.id_seances AND hs.statut = 'annule'
                            )
                        ");
                        $stmtCheck2->execute([
                            ':new_date' => $date,
                            ':id_plage' => $id_plage_p,
                            ':id' => $id_parallele
                        ]);
                        if ($stmtCheck2->fetchColumn() >= 2) {
                            $this->pdo->rollBack();
                            throw new Exception("Plage parallèle saturée.");
                        }

                        // Vérifier si le prof a déjà une séance dans la plage parallèle ce jour-là
                        $stmtVerifProf = $this->pdo->prepare("
                            SELECT 1 FROM seances_cours sc
                            WHERE sc.date = :date
                            AND sc.id_plage = :id_plage
                            AND sc.id_prof = :id_prof
                            AND sc.id_seances != :id
                            AND NOT EXISTS (
                                SELECT 1 FROM historique_seances hs
                                WHERE hs.id_seances = sc.id_seances AND hs.statut = 'annule'
                            )
                            LIMIT 1
                        ");
                        $stmtVerifProf->execute([
                            ':date' => $date,
                            ':id_plage' => $id_plage_p,
                            ':id_prof' => $id_prof,
                            ':id' => $id_parallele
                        ]);
                        if ($stmtVerifProf->fetch()) {
                            $this->pdo->rollBack();
                            throw new Exception("Le professeur enseigne déjà dans la plage parallèle.");
                        }

                        // Mise à jour séance parallèle
                        $this->pdo->prepare("
                            UPDATE seances_cours
                            SET id_cours = :id_cours, date = :date, id_prof = :id_prof
                            WHERE id_seances = :id
                        ")->execute([
                            ':id' => $id_parallele,
                            ':id_cours' => $id_cours,
                            ':date' => $date,
                            ':id_prof' => $id_prof
                        ]);

                        $this->pdo->prepare("
                            INSERT INTO historique_seances (id_seances, date, statut)
                            VALUES (:id, CURRENT_DATE, 'modifie')
                        ")->execute([':id' => $id_parallele]);
                    }
                }
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur update séance : " . $e->getMessage());
            throw $e;
        }
    }

    public function delete($id) {
        try {
            $this->pdo->beginTransaction();

            // Récupérer les infos de la séance
            $check = $this->pdo->prepare("SELECT * FROM seances_cours WHERE id_seances = :id");
            $check->execute([':id' => $id]);
            $seance = $check->fetch(PDO::FETCH_ASSOC);

            if (!$seance) {
                $this->pdo->rollBack();
                return false;
            }

            $id_cours = $seance['id_cours'];
            $date = $seance['date'];
            $id_plage = $seance['id_plage'];

            // Insérer dans l'historique pour la séance principale
            $sql = "INSERT INTO historique_seances (id_seances, date, statut)
                    VALUES (:id_seances, CURRENT_DATE, 'annule')";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_seances' => $id]);

            // Trouver la plage parallèle (ex : 08:00-10:00 -> 10:00-12:00)
            $getPlage = $this->pdo->prepare("SELECT heure_debut FROM plage_horaire WHERE id = :id_plage");
            $getPlage->execute([':id_plage' => $id_plage]);
            $heure_debut = $getPlage->fetchColumn();

            $plagesParalleles = [
                '08:00:00' => '10:00:00',
                '10:00:00' => '08:00:00',
                '13:00:00' => '15:00:00',
                '15:00:00' => '13:00:00'
            ];

            $heure_p2 = $plagesParalleles[$heure_debut] ?? null;

            if ($heure_p2) {
                // Trouver l’ID de la plage parallèle
                $getIdPlage2 = $this->pdo->prepare("SELECT id FROM plage_horaire WHERE heure_debut = :hd");
                $getIdPlage2->execute([':hd' => $heure_p2]);
                $id_plage_2 = $getIdPlage2->fetchColumn();

                if ($id_plage_2) {
                    // Récupérer la séance parallèle
                    $getSeance2 = $this->pdo->prepare("
                        SELECT id_seances FROM seances_cours
                        WHERE id_cours = :id_cours AND date = :date AND id_plage = :id_plage_2
                    ");
                    $getSeance2->execute([
                        ':id_cours' => $id_cours,
                        ':date' => $date,
                        ':id_plage_2' => $id_plage_2
                    ]);
                    $seance2 = $getSeance2->fetchColumn();

                    if ($seance2) {
                        // Insérer dans l’historique pour la séance parallèle
                        $stmt2 = $this->pdo->prepare("
                            INSERT INTO historique_seances (id_seances, date, statut)
                            VALUES (:id_seances, CURRENT_DATE, 'annule')
                        ");
                        $stmt2->execute([':id_seances' => $seance2]);
                    }
                }
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur annulation séance : " . $e->getMessage());
            return false;
        }
    }
}
