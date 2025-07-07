<?php
namespace app\models\statistique;

use PDO;

class SeancesCoursModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTestData() {
        $query = "SELECT * FROM seances_cours LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAttendanceByWeek($year, $week) {
        $query = "
            SELECT c.label, COUNT(DISTINCT g.id_eleve) as participants
            FROM seances_cours s
            JOIN cours c ON s.id_cours = c.id_cours
            JOIN planification_cours p ON s.id_seances = p.id_seance
            JOIN gestion_groupe g ON p.groupe = g.groupe
            JOIN historique_seances h ON s.id_seances = h.id_seances
            WHERE EXTRACT(WEEK FROM s.date) = :week AND EXTRACT(YEAR FROM s.date) = :year
            AND g.annee = :year AND g.mois = EXTRACT(MONTH FROM s.date)
            GROUP BY c.label";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':week' => $week, ':year' => $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOccupancyRate($year, $week) {
        $query = "
            SELECT COUNT(DISTINCT g.id_eleve) as participants, COUNT(DISTINCT s.id_seances) * 20 as max_participants
            FROM seances_cours s
            LEFT JOIN planification_cours p ON s.id_seances = p.id_seance
            LEFT JOIN gestion_groupe g ON p.groupe = g.groupe
            LEFT JOIN historique_seances h ON s.id_seances = h.id_seances
            WHERE EXTRACT(WEEK FROM s.date) = :week AND EXTRACT(YEAR FROM s.date) = :year
            AND (g.annee = :year AND g.mois = EXTRACT(MONTH FROM s.date) OR g.annee IS NULL)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':week' => $week, ':year' => $year]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['max_participants'] > 0 ? ($result['participants'] / $result['max_participants']) * 100 : 0;
    }
}
?>