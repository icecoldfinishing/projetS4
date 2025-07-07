<?php
namespace app\controllers\salle;
use app\models\salle\MaterielTypeModel;
use Flight;
use PDO;

class MaterielTypeController {
    private $db;
    private $model;

    public function __construct() {
        $this->db = Flight::db();
        $this->model = new MaterielTypeModel($this->db);
    }

    // Liste tous les types de matériel
    public function index() {
        $types = $this->model->all();
        Flight::render('gestion/salle/materiel/list', ['types' => $types]);
    }

    // Affiche le formulaire de création
    public function create() {
        Flight::render('gestion/salle/materiel/create');
    }

    // Enregistre un nouveau type
    public function store() {
        $data = Flight::request()->data->getData();

        // Validation du prix
        if (!isset($data['prix']) || !is_numeric($data['prix']) || $data['prix'] < 0) {
            Flight::halt(400, 'Prix invalide. Il doit être un nombre positif.');
        }

        $this->model->create($data);
        Flight::redirect('/materiel');
    }


    // Affiche un type spécifique
    public function show($id) {
        $type = $this->model->find($id);
        Flight::render('gestion/salle/materiel/view', ['type' => $type]);
    }

    // Formulaire d'édition
    public function edit($id) {
        $type = $this->model->find($id);
        Flight::render('gestion/salle/materiel/edit', ['type' => $type]);
    }

    // Met à jour un type
    public function update($id) {
        $data = Flight::request()->data->getData();

        if (!isset($data['prix']) || !is_numeric($data['prix']) || $data['prix'] < 0) {
            Flight::halt(400, 'Prix invalide. Il doit être un nombre positif.');
        }

        $this->model->update($id, $data);
        Flight::redirect('/materiel');
    }


    // Supprime un type
    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/materiel');
    }
}
