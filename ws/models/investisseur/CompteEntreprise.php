<?php
require_once __DIR__ . '/../../db.php';

class CompteEntreprise {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getLastValeur() {
        $stmt = $this->db->query("SELECT SUM(valeur)as valeur FROM compteentreprise ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['valeur'] : 0;
    }

    public function ajouterFonds($montant, $date) {
        $stmt = $this->db->prepare("INSERT INTO compteentreprise (valeur, date) VALUES (?, ?)");
        return $stmt->execute([$montant, $date]);
    }

    public function updateSolde($montant, $date) {
        $newValeur = 0 - $montant;
        $stmt = $this->db->prepare("INSERT INTO compteentreprise (valeur,date) VALUES (?,?)");
        return $stmt->execute([$newValeur, $date]);
    }
}