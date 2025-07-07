<?php

namespace app\models\GroupeModels;

use PDO;
use Flight;

class ReservationModel {

    public function insert(
        int $id_club,
        string $date_reservation,
        string $date_reserve,
        string $heure_debut,
        string $heure_fin
    ): int {
        $db = Flight::db();

        $sql = "
        INSERT INTO reservation
            (id_club, date_reservation, date_reserve, heure_debut, heure_fin)
        VALUES
            (:id_club, :date_reservation, :date_reserve, :heure_debut, :heure_fin)
        RETURNING id_reservation
    ";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_club'          => $id_club,
            ':date_reservation' => $date_reservation,
            ':date_reserve'     => $date_reserve,
            ':heure_debut'      => $heure_debut,
            ':heure_fin'        => $heure_fin
        ]);

        return (int) $stmt->fetchColumn();
    }


    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM reservation");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM reservation WHERE id_reservation = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function update($id, $id_club, $date_reservation, $date_reserve, $heure_debut, $heure_fin) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                UPDATE reservation SET 
                    id_club = :id_club, 
                    date_reservation = :date_reservation, 
                    date_reserve = :date_reserve, 
                    heure_debut = :heure_debut, 
                    heure_fin = :heure_fin 
                WHERE id_reservation = :id
            ");
            $stmt->execute([
                ':id' => $id,
                ':id_club' => $id_club,
                ':date_reservation' => $date_reservation,
                ':date_reserve' => $date_reserve,
                ':heure_debut' => $heure_debut,
                ':heure_fin' => $heure_fin,
            ]);
            return "Mise à jour réussie.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM reservation WHERE id_reservation = :id");
            $stmt->execute([':id' => $id]);
            return "Suppression réussie.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

    public function getGlobalFreeSlotsForDay(string $date, string $locale = 'fr_FR'): array
    {
        $db   = Flight::db();
        $jour = strtolower($this->jourDeSemaine($date, $locale));

        // Fetch horaires for the day
        $stmt = $db->prepare('SELECT debut, fin FROM horaire WHERE LOWER(jour) = :jour ORDER BY debut LIMIT 1');
        $stmt->execute([':jour' => $jour]);
        $horaire = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$horaire) {
            return []; // closed that day
        }

        // Fetch all reservations that day
        $stmt = $db->prepare('SELECT heure_debut AS start, heure_fin AS end FROM reservation WHERE date_reserve = :date ORDER BY heure_debut');
        $stmt->execute([':date' => $date]);
        $reserved = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$reserved) {
            return [['start' => $horaire['debut'], 'end' => $horaire['fin']]];
        }

        $reserved = $this->mergeIntervals($reserved);

        $free = [];
        $cursor = $horaire['debut'];

        foreach ($reserved as $slot) {
            if ($slot['start'] > $cursor) {
                $free[] = ['start' => $cursor, 'end' => $slot['start']];
            }
            $cursor = max($cursor, $slot['end']);
        }

        if ($cursor < $horaire['fin']) {
            $free[] = ['start' => $cursor, 'end' => $horaire['fin']];
        }

        return $free;
    }

    private function jourDeSemaine($date): string
    {
        $dayOfWeek = strtolower(date('l', strtotime($date)));

        $mapping = [
            'monday'    => 'lundi',
            'tuesday'   => 'mardi',
            'wednesday' => 'mercredi',
            'thursday'  => 'jeudi',
            'friday'    => 'vendredi',
            'saturday'  => 'samedi',
            'sunday'    => 'dimanche'
        ];

        return $mapping[$dayOfWeek] ?? $dayOfWeek;
    }

    private function mergeIntervals(array $intervals): array
    {
        usort($intervals, fn($a, $b) => $a['start'] <=> $b['start']);
        $merged = [];

        foreach ($intervals as $interval) {
            if (empty($merged) || $interval['start'] > $merged[array_key_last($merged)]['end']) {
                $merged[] = $interval;
            } else {
                $merged[array_key_last($merged)]['end'] = max($merged[array_key_last($merged)]['end'], $interval['end']);
            }
        }

        return $merged;
    }
    public function getByDate($date) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                SELECT r.*, cg.nom_responsable, cg.discipline, cg.nombre 
                FROM reservation r 
                JOIN club_groupe cg ON r.id_club = cg.id 
                WHERE r.date_reserve = ? 
                ORDER BY r.heure_debut
            ");
            $stmt->execute([$date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting reservations by date: " . $e->getMessage());
            return [];
        }
    }


}
