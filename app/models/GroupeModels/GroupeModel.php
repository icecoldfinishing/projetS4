<?php

        namespace app\models\GroupeModels;

        use PDO;
        use Flight;

        class GroupeModel {

            public function insert($nom_responsable, $contact, $nombre, $discipline) {
                try {
                    $db = Flight::db();
                    $stmt = $db->prepare("INSERT INTO club_groupe (nom_responsable, contact, nombre, discipline) VALUES (:nom_responsable, :contact, :nombre, :discipline)");
                    $stmt->execute([
                        ':nom_responsable' => $nom_responsable,
                        ':contact' => $contact,
                        ':nombre' => $nombre,
                        ':discipline' => $discipline
                    ]);
                    return "Insertion réussie !";
                } catch (\PDOException $e) {
                    return "Erreur : " . $e->getMessage();
                }
            }

            public function getAll() {
                try {
                    $db = Flight::db();
                    $stmt = $db->query("SELECT * FROM club_groupe");
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (\PDOException $e) {
                    return [];
                }
            }

            public function getById($id) {
                try {
                    $db = Flight::db();
                    $stmt = $db->prepare("SELECT * FROM club_groupe WHERE id = :id");
                    $stmt->execute([':id' => $id]);
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (\PDOException $e) {
                    return null;
                }
            }

            public function delete($id) {
                try {
                    $db = Flight::db();
                    $stmt = $db->prepare("DELETE FROM club_groupe WHERE id = :id");
                    $stmt->execute([':id' => $id]);
                    return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun groupe trouvé.";
                } catch (\PDOException $e) {
                    return "Erreur de suppression : " . $e->getMessage();
                }
            }

            public function update($id, $nom_responsable, $contact, $nombre, $discipline) {
                try {
                    $db = Flight::db();
                    $stmt = $db->prepare("UPDATE club_groupe SET nom_responsable = :nom_responsable, contact = :contact, nombre = :nombre, discipline = :discipline WHERE id = :id");
                    $stmt->execute([
                        ':nom_responsable' => $nom_responsable,
                        ':contact' => $contact,
                        ':nombre' => $nombre,
                        ':discipline' => $discipline,
                        ':id' => $id
                    ]);
                    return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
                } catch (\PDOException $e) {
                    return "Erreur de mise à jour : " . $e->getMessage();
                }
            }

            public function getScheduleData($year, $month) {
                try {
                    $db = Flight::db();

                    $firstDay = date('Y-m-01', mktime(0, 0, 0, $month, 1, $year));
                    $lastDay = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));

                    $stmt = $db->prepare("
                        SELECT 
                            r.date_reserve,
                            r.heure_debut,
                            r.heure_fin,
                            g.nom_responsable as group_name,
                            g.discipline,
                            g.nombre as participants
                        FROM reservation r
                        JOIN club_groupe g ON r.id_club = g.id
                        WHERE r.date_reserve BETWEEN :first_day AND :last_day
                        AND r.valeur = 'payee'
                        ORDER BY r.date_reserve, r.heure_debut
                    ");

                    $stmt->execute([
                        ':first_day' => $firstDay,
                        ':last_day' => $lastDay
                    ]);

                    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                } catch (\Exception $e) {
                    error_log("Error in getScheduleData: " . $e->getMessage());
                    return [];
                }
            }

// Dans GroupeModel.php, ajoutez cette méthode
public function getDayAvailability($date) {
    try {
        // Vérifier le jour de la semaine
        $dayOfWeek = strtolower(date('l', strtotime($date)));
        $dayOfWeekFr = $this->jourDeSemaine($date);

        // Exclure mercredi et samedi
        if (in_array($dayOfWeekFr, ['mercredi', 'samedi'])) {
            return ['available' => [], 'closed' => true];
        }

        // Horaires d'ouverture par défaut : 8h-18h
        $openingTime = '08:00:00';
        $closingTime = '18:00:00';

        // Récupérer les réservations confirmées pour cette date
        $db = Flight::db();
        $stmt = $db->prepare("
            SELECT heure_debut, heure_fin 
            FROM reservation 
            WHERE date_reserve = :date 
            AND valeur = 'payee'
            ORDER BY heure_debut
        ");
        $stmt->execute([':date' => $date]);
        $reservations = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Calculer les créneaux disponibles
        $availableSlots = $this->calculateAvailableSlots($openingTime, $closingTime, $reservations);

        return [
            'available' => $availableSlots,
            'closed' => false,
            'opening_hours' => ['start' => $openingTime, 'end' => $closingTime]
        ];

    } catch (\Exception $e) {
        return ['available' => [], 'closed' => false];
    }
}

private function calculateAvailableSlots($openingTime, $closingTime, $reservations) {
    $slots = [];
    $currentTime = $openingTime;

    foreach ($reservations as $reservation) {
        // Si il y a un gap avant la réservation
        if ($currentTime < $reservation['heure_debut']) {
            $slots[] = [
                'start' => $currentTime,
                'end' => $reservation['heure_debut']
            ];
        }
        // Avancer le curseur après la réservation
        $currentTime = max($currentTime, $reservation['heure_fin']);
    }

    // Vérifier s'il reste du temps après la dernière réservation
    if ($currentTime < $closingTime) {
        $slots[] = [
            'start' => $currentTime,
            'end' => $closingTime
        ];
    }

    return $slots;
}

private function jourDeSemaine($date) {
    $dayOfWeek = strtolower(date('l', strtotime($date)));

    $mapping = [
        'monday' => 'lundi',
        'tuesday' => 'mardi',
        'wednesday' => 'mercredi',
        'thursday' => 'jeudi',
        'friday' => 'vendredi',
        'saturday' => 'samedi',
        'sunday' => 'dimanche'
    ];

    return $mapping[$dayOfWeek] ?? $dayOfWeek;
}
public function getMonthlyStats($year, $month) {
    try {
        $db = Flight::db();

        $firstDay = date('Y-m-01', mktime(0, 0, 0, $month, 1, $year));
        $lastDay = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));

        // Statistiques du mois
        $stmt = $db->prepare("
            SELECT 
                COUNT(*) as total_reservations,
                COUNT(DISTINCT r.id_club) as groupes_actifs,
                SUM(g.nombre) as total_participants
            FROM reservation r
            JOIN club_groupe g ON r.id_club = g.id
            WHERE r.date_reserve BETWEEN :first_day AND :last_day
            AND r.valeur = 'payee'
        ");

        $stmt->execute([
            ':first_day' => $firstDay,
            ':last_day' => $lastDay
        ]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [
            'total_reservations' => 0,
            'groupes_actifs' => 0,
            'total_participants' => 0
        ];
    } catch (\Exception $e) {
        error_log("Error in getMonthlyStats: " . $e->getMessage());
        return [
            'total_reservations' => 0,
            'groupes_actifs' => 0,
            'total_participants' => 0
        ];
    }
}


        }