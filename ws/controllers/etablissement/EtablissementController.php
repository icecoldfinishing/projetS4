<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/investisseur/CompteEntreprise.php';

class EtablissementController {
    public static function afficher() {
        include __DIR__ . '/../../views/etablissement/home.php';
    }

    public static function demandePret()
    {
        session_start();
        $prets = Pret::getPretsNonStatut();
        $errorMessage = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']); // Clear the message after displaying
        $successMessage = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); // Clear the message after displaying
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
            $soldeActuel = $compteEntreprise->getLastValeur();

            if ($soldeActuel < $pret['valeur']) {
                // Solde insuffisant, refuser le prêt
                Pret::updateStatut($id, 3);  // statut 3 = refusé
                $_SESSION['error_message'] = 'Solde insuffisant pour valider ce prêt.';
                Flight::redirect('/demandePret');
                return;
            } else {
                // Solde suffisant, valider le prêt
                $compteEntreprise->updateSolde($pret['valeur']);
                Pret::updateStatut($id, 2);  // statut 2 = accepté
                $_SESSION['success_message'] = 'Prêt validé avec succès.';
            }
        } elseif ($action === 'refuser') {
            Pret::updateStatut($id, 3);  // statut 3 = refusé
        }

        Flight::redirect('/demandePret');
    }

}
