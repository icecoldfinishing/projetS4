<?php
namespace app\controllers\individu;

use app\models\individu\SuperviseurModel;
use Flight;

class SuperviseurController {
    private $model;

    public function __construct() {
        $this->model = new SuperviseurModel();
    }

    public function getAll() {
        $superviseurs = $this->model->getAll();
        Flight::json($superviseurs);
    }

    public function getById($id) {
        $superviseur = $this->model->getById($id);
        Flight::json($superviseur);
    }

    public function insert() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = Flight::request()->data->getData();
        }

        $dateNaissance = isset($input['date_naissance']) ? $input['date_naissance'] : null;

        $result = $this->model->insert(
            $input['nom'],
            $input['prenom'],
            $dateNaissance,
            $input['adresse'],
            $input['contact'],
            $input['id_genre']
        );
        Flight::json(['success' => true, 'message' => $result]);
    }

    public function update($id) {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                $input = Flight::request()->data->getData();
            }

            // Validate required fields
            if (!isset($input['nom']) || !isset($input['prenom'])) {
                Flight::json(['success' => false, 'message' => 'Nom et prénom sont requis'], 400);
                return;
            }

            $dateNaissance = isset($input['date_naissance']) ? $input['date_naissance'] : null;
            $actif = isset($input['actif']) ? $input['actif'] : null;

            // Additional validation for actif if provided
            if ($actif !== null && $actif !== '' && !in_array($actif, ['0', '1', 'true', 'false', true, false, 0, 1])) {
                Flight::json(['success' => false, 'message' => 'Valeur actif invalide'], 400);
                return;
            }

            $result = $this->model->update(
                $id,
                $input['nom'],
                $input['prenom'],
                $dateNaissance,
                $input['adresse'] ?? '',
                $input['contact'] ?? '',
                $input['id_genre'] ?? null,
                $actif
            );

            Flight::json(['success' => true, 'message' => $result]);
        } catch (Exception $e) {
            error_log("Error updating superviseur: " . $e->getMessage());
            Flight::json(['success' => false, 'message' => 'Erreur lors de la mise à jour'], 500);
        }
    }

    public function delete($id) {
        $result = $this->model->delete($id);
        Flight::json(['message' => $result]);
    }
}