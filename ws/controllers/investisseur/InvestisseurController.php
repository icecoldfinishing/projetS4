<?php
require_once __DIR__ . '/CompteEntrepriseController.php';

class InvestisseurController {
    public static function afficher() {
        include __DIR__ . '/../../views/investisseur/home.php';
    }

    public static function showAjoutFondsPage() {
        $success = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $montant = intval($_POST['valeur']);
            $success = CompteEntrepriseController::ajouter($montant);
        }
        include __DIR__ . '/../../views/investisseur/AjoutFonds.php';
    }
}
