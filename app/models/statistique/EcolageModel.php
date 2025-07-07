<?php
namespace app\models\statistique;

use PDO;

class EcolageModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTestData() {
        $query = "SELECT * FROM ecolage LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getInscriptionsByMonth($year, $month) {
        $query = "SELECT COUNT(*) as total FROM ecolage WHERE annee = :year AND mois = :month";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':year' => $year, ':month' => $month]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRevenueByMonth($year, $month) {
        $query = "SELECT SUM(montant) as total FROM ecolage WHERE annee = :year AND mois = :month AND statut = 'paye'";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':year' => $year, ':month' => $month]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ['total' => $result['total'] ?? 0];
    }
}
?>