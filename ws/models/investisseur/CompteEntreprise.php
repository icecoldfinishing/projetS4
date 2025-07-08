<?php
require_once __DIR__ . '/../../db.php';

class CompteEntreprise
{
    // Récupère la dernière valeur du compte (le solde actuel)
    public static function getLastValeur()
    {
        $db = getDB();
        $stmt = $db->query("SELECT valeur FROM compteentreprise ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['valeur'] : 0;
    }

    // Ajoute un montant au compte (fonds entrants)
    public static function ajouterFonds($montant, $date = null)
    {
        $db = getDB();
        $lastValeur = self::getLastValeur();
        $newValeur = $lastValeur + $montant;

        $stmt = $db->prepare("INSERT INTO compteentreprise (valeur, date) VALUES (?, ?)");
        return $stmt->execute([$newValeur, $date ?? date('Y-m-d')]);
    }

    // Déduit un montant du compte (dépense ou sortie)
    public static function updateSolde($montant)
    {
        $db = getDB();
        $lastValeur = self::getLastValeur();
        $newValeur = $lastValeur - $montant;

        $stmt = $db->prepare("INSERT INTO compteentreprise (valeur, date) VALUES (?, NOW())");
        return $stmt->execute([$newValeur]);
    }
}
