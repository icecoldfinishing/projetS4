<?php
namespace app\controllers\TarifClubController;

use app\models\TarifClubModel\TarifClubModel;
use Flight;

class TarifClubController {
    public function updateTarifClub() {
        try {
            $montant = floatval($_POST['montant'] ?? 0);
            $m = new TarifClubModel();
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