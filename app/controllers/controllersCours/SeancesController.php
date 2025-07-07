<?php

namespace app\controllers\controllersCours;

use Flight;
use Exception;
use app\models\modelsCours\SeancesModel;
use app\models\modelsCours\CoursModel;
use app\models\modelsCours\PlageHoraireModel;
use app\models\modelsCours\ProfModel;
use app\models\modelsCours\HistoriqueSeancesModel;

class SeancesController {
    public function getFormSeance() {
        $model = new SeancesModel(Flight::db());
        $coursModel = new CoursModel(Flight::db());
        $profModel = new ProfModel(Flight::db());

        $seance = null;
        $plages = [];

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $seance = $model->getById($id);
        } else {
            // Charger les plages uniquement en mode insertion
            $plageModel = new PlageHoraireModel(Flight::db());
            $plages = $plageModel->getAll();
        }

        $data = [
            'seance' => $seance,
            'cours' => $coursModel->getAll(),
            'plages' => $plages,
            'profs' => $profModel->getAll()
        ];
        Flight::render("gestion/edt/seances/insertion", $data);
    }

    public function insertSeance() {
        $model = new SeancesModel(Flight::db());

        try {
            $id_cours = $_POST['id_cours'];
            $date = $_POST['date'];
            $id_plage = $_POST['id_plage'];
            $id_prof = $_POST['id_prof'];

            $success = $model->create($id_cours, $date, $id_plage, $id_prof);

            if (!$success) throw new Exception("Création refusée ou erreur");
            $seances = $model->getAll();

            $data = ['message' => 'Séance ajoutée avec succès', 'seances' => $seances];
            Flight::render("gestion/edt/seances/liste", $data);
        } catch (Exception $e) {
            $seances = $model->getAll();
            $data = ['message' => $e->getMessage(),'seances' => $seances];
            Flight::render("gestion/edt/seances/liste", $data);
        }
    }

    public function updateSeance() {
        $model = new SeancesModel(Flight::db());

        try {
            $id = $_POST['id'];
            $id_cours = $_POST['id_cours'];
            $date = $_POST['date'];
            $id_prof = $_POST['id_prof'];

            $model->update($id, $id_cours, $date, $id_prof);
            $seances = $model->getAll();
            $data = ['message' => 'Séance modifiée avec succès', 'seances' => $seances];
            Flight::render("gestion/edt/seances/liste", $data);
        } catch (Exception $e) {
            $seances = $model->getAll();
            $data = ['message' => $e->getMessage(), 'seances' => $seances];
            Flight::render("gestion/edt/seances/liste", $data);
        }
    }

    public function deleteSeance() {
        $model = new SeancesModel(Flight::db());

        try {
            $id = $_GET['id'];
            $model->delete($id);
            $seances = $model->getAll();
            $data = ['message' => 'Séance supprimée avec succès', 'seances' => $seances];
            Flight::render("gestion/edt/seances/liste", $data);
        } catch (Exception $e) {
            $data = ['message' => $e->getMessage()];
            Flight::render("gestion/edt/seances/liste", $data);
        }
    }

    public function getAllSeances() {
        $model = new SeancesModel(Flight::db());
        $seances = $model->getAll();
        $data = ['seances' => $seances];
        Flight::render("gestion/edt/seances/liste", $data);
    }

    public function historiqueSeances() {
        $histModel = new HistoriqueSeancesModel(Flight::db());
        $historiques = $histModel->getAll();

        $data = ['historiques' => $historiques];
        Flight::render("gestion/edt/seances/historique", $data);
    }

}