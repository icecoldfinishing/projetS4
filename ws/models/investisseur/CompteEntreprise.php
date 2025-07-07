<?php
class CompteEntreprise {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getLastValeur() {
        $stmt = $this->db->query("SELECT valeur FROM compteentreprise ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['valeur'] : 0;
    }

    public function ajouterFonds($montant) {
        $lastValeur = $this->getLastValeur();
        $newValeur = $lastValeur + $montant;
        $stmt = $this->db->prepare("INSERT INTO compteentreprise (valeur) VALUES (?)");
        return $stmt->execute([$newValeur]);
    }

    public function updateSolde($montant) {
        $lastValeur = $this->getLastValeur();
        $newValeur = $lastValeur - $montant;
        $stmt = $this->db->prepare("INSERT INTO compteentreprise (valeur) VALUES (?)");
        return $stmt->execute([$newValeur]);
    }
}