<?php

namespace app\controllers\controllersCours;

use Flight;
use Exception;
use app\models\modelsCours\CoursModel;
use app\models\modelsCours\HistoriqueSeancesModel;
use app\models\modelsCours\GestionCoursModel;

class CoursController {
    public function getFormCours() {
        $model = new CoursModel(Flight::db());
        $cours = null;

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $cours = $model->getById($id);
        }

        Flight::render("gestion/edt/cours/insertion", ['cours' => $cours]);
    }


    public function insertCours() {
        $model = new CoursModel(Flight::db());
        try {
            $label = $_POST['label'];
            $model->create($label);
            $cours = $model->getAll();
            $data = ['message' => 'Cours ajouté avec succès', 'cours' => $cours];
            Flight::render("cours/liste", $data);
        } catch(Exception $e) {
            $data = ['message' => $e->getMessage()];
            Flight::render("gestion/edt/cours/liste", $data);
        }
    }

    public function updateCours() {
        $model = new CoursModel(Flight::db());
        try {
            $id = $_POST['id'];
            $label = $_POST['label'];
            $model->update($id, $label);
            $cours = $model->getAll();
            $data = ['message' => 'Cours mis à jour avec succès', 'cours' => $cours];
            Flight::render("gestion/edt/cours/liste", $data);
        } catch(Exception $e) {
            $data = ['message' => $e->getMessage()];
            Flight::render("gestion/edt/cours/liste", $data);
        }
    }

    public function deleteCours() {
        $model = new CoursModel(Flight::db());
        try {
            $id = $_GET['id'];
            $model->delete($id);
            $cours = $model->getAll();
            $data = ['message' => 'Cours supprimé avec succès', 'cours' => $cours];
            Flight::render("gestion/edt/cours/liste", $data);
        } catch(Exception $e) {
            $data = ['message' => $e->getMessage()];
            Flight::render("gestion/edt/cours/liste", $data);
        }
    }

    public function getCoursById() {
        $model = new CoursModel(Flight::db());
        $id = $_GET['id'];
        $cours = $model->getById($id);
        $data = ['page' => 'Detail_Cours', 'cours' => $cours];
        Flight::render("Templates", $data);
    }

    public function getAllCours() {
        $model = new CoursModel(Flight::db());
        $cours = $model->getAll();
        $data = ['cours' => $cours];
        Flight::render("gestion/edt/cours/liste", $data);
    }
}
