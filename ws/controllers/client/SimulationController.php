<?php
require_once __DIR__ . '/../../models/other/Simulation.php';

class SimulationController
{
    public static function save()
    {
        session_start();
        if (!isset($_SESSION['user']['id'])) {
            Flight::json(['success' => false, 'message' => 'Utilisateur non connecté']);
            return;
        }

        $data = Flight::request()->data->getData();
        $data = (object)$data;
        $data->id_user = $_SESSION['user']['id'];

        \Simulation::save($data);

        Flight::json(['success' => true, 'message' => 'Simulation enregistrée']);
    }
}
