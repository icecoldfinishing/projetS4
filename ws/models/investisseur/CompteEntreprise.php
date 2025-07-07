<?php
class CompteEntreprise {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function ajouterFonds($montant) {
        // Try to update an existing record
        $stmt = $this->db->prepare("UPDATE compteentreprise SET valeur = valeur + ?");
        $stmt->execute([$montant]);

        // If no row was updated (meaning no record existed), insert a new one
        if ($stmt->rowCount() === 0) {
            $stmt = $this->db->prepare("INSERT INTO compteentreprise (valeur) VALUES (?)");
            return $stmt->execute([$montant]);
        }
        return true; // Return true if update was successful
    }

    public function updateSolde($montant) {
        $stmt = $this->db->prepare("UPDATE compteEntreprise SET valeur = valeur - ?");
        return $stmt->execute([$montant]);
    }
}