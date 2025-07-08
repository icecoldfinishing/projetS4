<?php
require_once __DIR__ . '/../models/Simulation.php';

class SimulationController {
    public static function getSimulationsForUser() {
        session_start();
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        $userId = $_SESSION['user']['id'];
        $simulations = Simulation::getAllByUserId($userId);
        echo json_encode($simulations);
    }

    public static function createSimulation() {
        session_start();
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }
        $userId = $_SESSION['user']['id'];
        $data = json_decode(file_get_contents('php://input'));
        $data->id_user = $userId;

        if (!isset($data->montant) || !isset($data->taux) || !isset($data->taux_assurance) || !isset($data->duree)) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing required fields']);
            return;
        }

        // Basic calculation for demonstration. This should ideally be more robust.
        $montant = $data->montant;
        $taux = $data->taux;
        $taux_assurance = $data->taux_assurance;
        $duree = $data->duree;

        $r = ($taux / 100) / 12;
        $mensualite_base = ($montant * $r) / (1 - pow(1 + $r, -$duree));
        $cout_assurance_mensuelle = ($montant * $taux_assurance / 100) / $duree;
        $mensualite = $mensualite_base + $cout_assurance_mensuelle;
        $cout_total = $mensualite * $duree;
        $cout_interet = ($mensualite_base * $duree) - $montant;
        $cout_assurance_total = $cout_assurance_mensuelle * $duree;
        $cout_credit = $cout_total - $montant;

        $data->mensualite_base = round($mensualite_base, 2);
        $data->cout_assurance_mensuelle = round($cout_assurance_mensuelle, 2);
        $data->mensualite = round($mensualite, 2);
        $data->cout_total = round($cout_total, 2);
        $data->cout_interet = round($cout_interet, 2);
        $data->cout_assurance_total = round($cout_assurance_total, 2);
        $data->cout_credit = round($cout_credit, 2);

        $simulationId = Simulation::create($data);
        echo json_encode(['message' => 'Simulation created', 'id' => $simulationId]);
    }
}
