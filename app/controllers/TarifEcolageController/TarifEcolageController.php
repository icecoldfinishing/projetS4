<?php
        namespace app\controllers\TarifEcolageController;

        use app\models\TarifEcolageModel\TarifEcolageModel;
        use Flight;

        class TarifEcolageController {
            public function updateTarifEnfant() {
                try {
                    $montant = floatval($_POST['montant'] ?? 0);
                    $m = new TarifEcolageModel();
                    $result = $m->insert($montant, 0);

                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => $result]);
                } catch (Exception $e) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            }

            public function updateTarifAdulte() {
                try {
                    $montant = floatval($_POST['montant'] ?? 0);
                    $m = new TarifEcolageModel();
                    $result = $m->insert($montant, 1);

                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => $result]);
                } catch (Exception $e) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            }
        }
        ?>