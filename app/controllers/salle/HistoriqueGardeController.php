<?php
namespace app\controllers\salle;

use app\models\salle\HistoriqueGardeModel;
use Flight;
use PDO;

class HistoriqueGardeController {

    private $db;
    private $model;
    
    public function __construct() {
        if (!Flight::has('db')) {
            die("⚠️ La DB n'est pas encore mappée !");
        }
        $this->db = Flight::db();
        $this->model = new HistoriqueGardeModel($this->db);
    }

    public function index() {
        $data = $this->model->all();
        Flight::render('gestion/salle/historique/index', ['historiques' => $data]);
    }

    public function createForm() {
        Flight::render('gestion/salle/historique/create');
    }

    public function create() {
        $data = Flight::request()->data->getData();
        $this->model->create($data);
        Flight::redirect('/historique-garde');
    }

    public function editForm($id) {
        $record = $this->model->find($id);
        Flight::render('gestion/salle/historique/edit', ['historique' => $record]);
    }

    public function update($id) {
        $data = Flight::request()->data->getData();
        $this->model->update($id, $data);
        Flight::redirect('/historique-garde');
    }

    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/historique-garde');
    }
}