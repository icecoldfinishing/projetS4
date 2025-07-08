<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/investisseur/CompteEntreprise.php';
require_once __DIR__ . '/../../models/pret/Remboursement.php';
require_once __DIR__ . '/../../models/etablissement/StatInteret.php';

class EtablissementController {
    public static function afficher() {
        include __DIR__ . '/../../views/etablissement/home.php';
    }

    public static function view() {
        include __DIR__ . '/../../views/etablissement/statInteret.php';
    }

    public static function demandePret()
    {
        session_start();
        $prets = Pret::getPretsNonStatut();
        $errorMessage = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']); 
        $successMessage = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']); 
        include __DIR__ . '/../../views/etablissement/demande.php';
    }

    public static function statInteret()
    {
        $data = Flight::request()->data;
        session_start();
        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }
        $statInteret = StatInteret::getByMonth($data);
        Flight::json($statInteret);
    }
    
    public static function interetsParPeriode()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            Flight::halt(401, 'Non authentifié');
            return;
        }

        $d = Flight::request()->data;   

        $data = StatInteret::getInteretParPeriode(
            (int)$d->moisDebut,
            (int)$d->anneeDebut,
            (int)$d->moisFin,
            (int)$d->anneeFin
        );

        Flight::json($data);   
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
                $_SESSION['error_message'] = 'Solde insuffisant pour valider ce prêt.';
                Flight::redirect('/demandePret');
                return;
            } else {
                $compteEntreprise->updateSolde($pret['valeur']);
                Pret::updateStatut($id, 2);  
                $montant=Remboursement::generateRemboursements($id);
                $compteEntreprise->ajouterFonds($montant, date('Y-m-d'));
                $_SESSION['success_message'] = 'Prêt validé avec succès.';
            }
        } elseif ($action === 'refuser') {
            Pret::updateStatut($id, 3);  
        }

        Flight::redirect('/demandePret');
    }

}
