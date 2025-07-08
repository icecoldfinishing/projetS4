<?php
require_once __DIR__ . '/../../db.php';

require_once __DIR__ . '/../../db.php';

class CompteEntreprise
{
    // Récupère la dernière valeur du compte (le solde actuel)
    public static function getLastValeur()
    {
        $db = getDB();
        $stmt = $db->query("SELECT SUM(valeur)as valeur FROM compteentreprise ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['valeur'] : 0;
    }

    public function ajouterFonds($montant, $date) {
        $lastValeur = $this->getLastValeur();
        $newValeur = $lastValeur + $montant;
        $stmt = $this->db->prepare("INSERT INTO compteentreprise (valeur, date) VALUES (?, ?)");
        return $stmt->execute([$newValeur, $date]);
    }

    public function updateSolde($montant) {
        $lastValeur = $this->getLastValeur();
        $newValeur = $lastValeur - $montant;
        $stmt = $this->db->prepare("INSERT INTO compteentreprise (valeur,date) VALUES (?,NOW())");
        return $stmt->execute([$newValeur]);
    }
}
