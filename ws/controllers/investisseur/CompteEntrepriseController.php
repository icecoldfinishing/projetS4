<?php
require_once __DIR__ . '/../../models/investisseur/CompteEntreprise.php';
require_once __DIR__ . '/../../db.php'; 

class CompteEntrepriseController {
    public static function ajouter($montant) {
        $db = getDB(); // Utilisation de la connexion partagée
        $compte = new CompteEntreprise($db);
        return $compte->ajouterFonds($montant);
    }
}