<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/other/Role.php';

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
        // Récupère les données envoyées en POST
        $data = (object)[
            'id_role' => Flight::request()->data->id_role,
            'nom'     => Flight::request()->data->nom,
            'prenom'  => Flight::request()->data->prenom,
            'pwd'     => Flight::request()->data->pwd
        ];

        User::create($data);

        Flight::redirect('/login');
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
            'id_typePret' => Flight::request()->data->id_typePret,
            'commentaire' => Flight::request()->data->commentaire ?? null
        ];

        Pret::create($data);

        Flight::redirect('/demande');
    }




}
