<?php

namespace app\controllers;

use app\models\paiement\SalaireModel;
use Exception;
use Flight;

class SalaireController {
    private $salaireModel;

    public function __construct() {
        $this->salaireModel = new SalaireModel();
    }

    public function getAllEmployes() {
        try {
            $employes = $this->salaireModel->getAllEmployes();
            Flight::json($employes);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public function getEmployeById($id) {
        try {
            $employe = $this->salaireModel->getEmployeById($id);
            $historique = $this->salaireModel->getHistoriquePaiements($id);

            Flight::json([
                'employe' => $employe,
                'historique' => $historique
            ]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSalairesConfig() {
        try {
            $config = $this->salaireModel->getAllSalairesConfig();
            Flight::json($config);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public function modifierSalaireType() {
        try {
            $data = Flight::request()->data;

            if (empty($data->type_employe) || empty($data->nouveau_montant)) {
                Flight::json(['error' => 'Type d\'employé et montant requis'], 400);
                return;
            }

            $success = $this->salaireModel->modifierSalaireParType(
                $data->type_employe,
                $data->nouveau_montant
            );

            if ($success) {
                Flight::json(['success' => true, 'message' => 'Salaire modifié avec succès']);
            } else {
                Flight::json(['error' => 'Échec de la modification'], 500);
            }
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public function payerSalaire() {
        try {
            $data = Flight::request()->data;

            if (empty($data->id_employe) || empty($data->mois) || empty($data->annee)) {
                Flight::json(['error' => 'Données incomplètes'], 400);
                return;
            }

            $success = $this->salaireModel->payerSalaire(
                $data->id_employe,
                $data->mois,
                $data->annee,
                $data->mode_paiement ?? 'espece',
                $data->remarques ?? null
            );

            if ($success) {
                Flight::json(['success' => true, 'message' => 'Salaire payé avec succès']);
            } else {
                Flight::json(['error' => 'Échec du paiement'], 500);
            }
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}