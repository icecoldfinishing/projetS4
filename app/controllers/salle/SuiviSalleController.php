<?php
namespace app\controllers\salle;

use app\models\salle\ClubModel;
use app\models\salle\MaterielTypeModel;
use app\models\salle\SuiviSalleModel;
use app\models\salle\MaterielItemModel;
use app\models\salle\SuperviseurModel;
use Flight;
use PDO;

class SuiviSalleController {
    private $db;
    private $model;
    private $materielModel;
    private $superviseurModel;
    private $clubModel;
    private $materielTypeModel;

    public function __construct() {
        $this->db = Flight::db();
        $this->model = new SuiviSalleModel($this->db);
        $this->materielModel = new MaterielItemModel($this->db);
        $this->superviseurModel = new SuperviseurModel($this->db);
        $this->clubModel = new ClubModel($this->db);
        $this->materielTypeModel = new MaterielTypeModel($this->db);
    }

    public function index() {
        $suivis = $this->model->all();
        $materiels = $this->materielModel->all();
        $superviseurs = $this->superviseurModel->all();
        $clubs = $this->clubModel->all();
        $types = $this->materielTypeModel->all();
        Flight::render('gestion/salle/suivi_salle/index', [
            'suivis' => $suivis,
            'materiels' => $materiels,
            'superviseurs' => $superviseurs,
            'clubs' => $clubs,
            'types' => $types
        ]);
    }

    public function store() {
        $this->model->create([
            'id_superviseur' => $_POST['id_superviseur'],
            'id_item' => $_POST['id_item'],
            'id_club' => empty($_POST['id_club']) ? null : $_POST['id_club'],
            'description' => $_POST['description'],
            'etat' => $_POST['etat']
        ]);


        Flight::redirect('/suivi-salle');
    }

    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/suivi-salle');
    }
}
