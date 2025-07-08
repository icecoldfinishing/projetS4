<?php
require_once __DIR__ . '/../../models/other/Simulation.php';

class SimulationController
{
    // Enregistre une simulation
    public static function save()
    {
        session_start();
        
        if (!isset($_SESSION['user']['id'])) {
            Flight::json([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ]);
            return;
        }

        $data = Flight::request()->data->getData();
        $data = (object) $data;
        $data->id_user = $_SESSION['user']['id'];

        try {
            Simulation::save($data);
            Flight::json([
                'success' => true,
                'message' => 'Simulation enregistrée avec succès'
            ]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()
            ]);
        }
    }
}
