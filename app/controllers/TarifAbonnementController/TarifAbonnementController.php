<?php
namespace app\controllers\TarifAbonnementController;

use app\models\TarifAbonnementModel\TarifAbonnementModel;
use Flight;

class TarifAbonnementController {
    public function updateTarifAbonnement() {
        try {
            $montant = floatval($_POST['montant'] ?? 0);
            $m = new TarifAbonnementModel();
            $result = $m->insert($montant);

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => $result]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
?>