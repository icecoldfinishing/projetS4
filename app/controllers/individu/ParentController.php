<?php

namespace app\controllers\individu;

use app\models\individu\ParentModel;
use Flight;

class ParentController {

    public function getAll() {
        $parentModel = new ParentModel();
        $parents = $parentModel->getAll();
        Flight::json($parents);
    }

    public function getById($id) {
        $parentModel = new ParentModel();
        $parent = $parentModel->getById($id);

        if ($parent) {
            Flight::json($parent);
        } else {
            Flight::json(['error' => 'Parent non trouvé'], 404);
        }
    }

    public function insert() {
        $data = Flight::request()->data;

        if (!isset($data->nom) || !isset($data->prenom)) {
            Flight::json(['error' => 'Nom et prénom requis'], 400);
            return;
        }

        $parentModel = new ParentModel();
        $result = $parentModel->insert(
            $data->nom,
            $data->prenom,
            $data->contact ?? null,
            $data->adresse ?? null
        );

        if ($result) {
            Flight::json(['success' => 'Parent créé', 'id' => $result], 201);
        } else {
            Flight::json(['error' => 'Erreur lors de la création'], 500);
        }
    }

    public function update($id) {
        $data = Flight::request()->data;

        $parentModel = new ParentModel();
        $result = $parentModel->update(
            $id,
            $data->nom ?? null,
            $data->prenom ?? null,
            $data->contact ?? null,
            $data->adresse ?? null
        );

        if ($result) {
            Flight::json(['success' => 'Parent mis à jour']);
        } else {
            Flight::json(['error' => 'Erreur lors de la mise à jour'], 500);
        }
    }

    public function delete($id) {
        $parentModel = new ParentModel();
        $result = $parentModel->delete($id);

        if ($result) {
            Flight::json(['success' => 'Parent supprimé']);
        } else {
            Flight::json(['error' => 'Erreur lors de la suppression'], 500);
        }
    }
}