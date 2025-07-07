<?php
namespace app\models\statistique;
use PDO;

class AbonnementModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTestData() {
        $query = "SELECT * FROM abonnement LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRenewalRate($year, $month) {
        $query = "SELECT COUNT(*) as total, COUNT(CASE WHEN actif = TRUE THEN 1 END) as active 
                  FROM abonnement WHERE annee = :year AND mois = :month";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':year' => $year, ':month' => $month]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0 ? ($result['active'] / $result['total']) * 100 : 0;
    }

    public function getUnsubscribeRate($year, $month) {
        $query = "SELECT COUNT(*) as total, COUNT(CASE WHEN actif = FALSE THEN 1 END) as inactive 
                  FROM abonnement WHERE annee = :year AND mois = :month";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':year' => $year, ':month' => $month]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0 ? ($result['inactive'] / $result['total']) * 100 : 0;
    }
}
?>