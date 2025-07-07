<?php
require_once __DIR__ . '/../../models/other/User.php';
require_once __DIR__ . '/../../models/other/Role.php';

class ClientController
{
    public static function afficher()
    {
        include __DIR__ . '/../../views/client/home.php';
    }
    public static function create()
    {
        $roles = Role::getAll(); // Appel du modèle pour récupérer les rôles
        include __DIR__ . '/../../views/client/create.php'; // La vue recevra $roles
    }
}
