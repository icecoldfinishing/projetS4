<?php
class CompteEntreprise {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function ajouterFonds($montant) {
        $sql = "INSERT INTO compteEntreprise (valeur) VALUES (:valeur)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':valeur', $montant, PDO::PARAM_INT);
        return $stmt->execute();
    }
}