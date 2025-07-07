<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/investisseur/CompteEntreprise.php';

class EtablissementController {
    public static function afficher() {
        include __DIR__ . '/../../views/etablissement/home.php';
    }

    public static function demandePret()
    {
        $prets = Pret::getPretsNonStatut();
        include __DIR__ . '/../../views/etablissement/demande.php';
    }

    public static function decision() {
        session_start();

        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }

        $id = Flight::request()->data->id;
        $action = Flight::request()->data->action;

        if ($action === 'valider') {
            $pret = Pret::getById($id);
            $compteEntreprise = new CompteEntreprise(getDB());
            $compteEntreprise->updateSolde($pret['valeur']);
            Pret::updateStatut($id, 2);  // statut 2 = accepté
        } elseif ($action === 'refuser') {
            Pret::updateStatut($id, 3);  // statut 3 = refusé
        }

        Flight::redirect('/demandePret');
    }

}
