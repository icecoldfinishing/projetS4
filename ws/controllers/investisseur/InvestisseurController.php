<?php
require_once __DIR__ . '/../../models/investisseur/CompteEntreprise.php';

class InvestisseurController {
    public static function afficher() {
        include __DIR__ . '/../../views/investisseur/home.php';
    }

    public static function showAjoutFondsPage() {
        $success = Flight::request()->query->success ?? null;
        include __DIR__ . '/../../views/investisseur/AjoutFonds.php';
    }

    public static function processAjoutFonds() {
        $montant = intval($_POST['valeur']);
        $compte = new CompteEntreprise(getDB());
        $success = $compte->ajouterFonds($montant);
        Flight::redirect('/investisseur/AjoutFonds?success=' . ($success ? 'true' : 'false'));
    }
}
