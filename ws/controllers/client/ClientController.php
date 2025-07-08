<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/other/Role.php';
require_once __DIR__ . '/../../models/etablissement/typePret.php';

class ClientController
{
    // Affiche la page d'accueil client
    public static function afficher()
    {
        include __DIR__ . '/../../views/client/home.php';
    }

    // Affiche le formulaire de création
    public static function create()
    {
        $roles = Role::getAll(); // Récupère tous les rôles pour le formulaire
        include __DIR__ . '/../../views/other/signin.php';
    }
    public static function simulation()
    {
        $typesPret = TypePret::getAll();
        include __DIR__ . '/../../views/client/simulation.php';
    }
    public static function simuler()
    {
        $typesPret = TypePret::getAll();
        include __DIR__ . '/../../views/client/simulation.php';
    }
    public static function demande()
    {
        $roles = Role::getAll();
        $typesPret = TypePret::getAll();
        include __DIR__ . '/../../views/client/demande.php';
    }

    public static function mesPret()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }

        $id_user = $_SESSION['user']['id'];
        $prets = Pret::getPretsAccepte($id_user);

        include __DIR__ . '/../../views/client/mesPret.php';
    }



    // Traite la soumission du formulaire (POST)
    public static function store()
    {
        $data = (object)[
            'id_role' => Flight::request()->data->id_role,
            'nom'     => Flight::request()->data->nom,
            'prenom'  => Flight::request()->data->prenom,
            'pwd'     => Flight::request()->data->pwd
        ];

        User::create($data);

        // Redirection avec un indicateur dans l'URL
        Flight::redirect('/client/create?success=1');
    }

    
    public static function storePret()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            Flight::redirect('/login');
            return;
        }

        $data = (object)[
            'id_user'     => $_SESSION['user']['id'],
            'id_statut'   => 1, // Statut initial "en attente"
            'valeur'      => Flight::request()->data->valeur,
            'dateDebut'   => Flight::request()->data->dateDebut,
            'duree'       => Flight::request()->data->duree,
            'delai'       => Flight::request()->data->delai,
            'id_typePret' => Flight::request()->data->id_typePret,
            'commentaire' => Flight::request()->data->commentaire ?? null,
            'assurance' => (isset($_POST['assurance']) && $_POST['assurance'] !== '') ? $_POST['assurance'] : null,
            'valeurAssurance' => (isset($_POST['valeurAssurance']) && $_POST['valeurAssurance'] !== '') ? $_POST['valeurAssurance'] : null
        ];

        Pret::create($data);

        // 🔔 Message flash de succès
        $_SESSION['success'] = "Votre demande de prêt a bien été enregistrée.";

        Flight::redirect('/demande');
    }





}
