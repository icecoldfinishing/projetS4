<?php
namespace app\controllers\salle;

use app\models\salle\MaterielItemModel;
use app\models\salle\StockMaterielModel;
use app\models\salle\MaterielTypeModel;
use Flight;
use PDO;
class StockMaterielController {
    private $db;
    private $model;
    private $typeModel;
    private $itemModel;

    public function __construct() {
        $this->db = Flight::db();
        $this->model = new StockMaterielModel($this->db);
        $this->typeModel = new MaterielTypeModel($this->db);
        $this->itemModel = new MaterielItemModel($this->db);
    }

    public function index() {
        $stock = $this->model->all();
        $types = $this->typeModel->all();
        $stock_disponible = $this->model->getStockDisponible(); // <-- Ajout

        Flight::render('gestion/salle/stock_materiel/index', [
            'stock' => $stock,
            'types' => $types,
            'stock_disponible' => $stock_disponible // <-- Ajout
        ]);
    }


    public function store() {
        $data = [
            'id_type' => $_POST['id_type'],
            'type_mouvement' => $_POST['type_mouvement'],
            'quantite' => $_POST['quantite']
        ];
        $this->model->create($data);
        Flight::redirect("/stock/confirmation/{$data['type_mouvement']}/{$data['id_type']}/{$data['quantite']}");
    }


    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/stock');
    }

    public function confirm($mouvement, $id_type, $quantite) {
        $materiels = [];
        $typeLabel = '';

        $stmt = $this->typeModel->db->prepare("SELECT label FROM materiel_type WHERE id_type = :id");
        $stmt->execute([':id' => $id_type]);
        $typeLabel = $stmt->fetchColumn();

        if ($mouvement === 'O') {
            $materiels = $this->itemModel->getAvailableItemsByType($id_type);
        }

        Flight::render('gestion/salle/stock_materiel/confirmation', [
            'mouvement' => $mouvement,
            'id_type' => $id_type,
            'quantite' => $quantite,
            'materiels' => $materiels,
            'label_type' => $typeLabel // <--- Ajout
        ]);
    }


    public function insertSeries() {
        $type = $_POST['id_type'];
        $series = $_POST['series'] ?? [];

        $stmt = $this->itemModel->db->prepare("
        INSERT INTO materiel_item (id_type, num_serie, etat)
        VALUES (:id_type, :num_serie, 'neuve')
    ");

        foreach ($series as $s) {
            if (!empty($s)) {
                $stmt->execute([
                    ':id_type' => $type,
                    ':num_serie' => $s
                ]);
            }
        }

        Flight::redirect('/stock');
    }

    public function removeItems() {
        $ids = $_POST['selected'] ?? [];

        if (!empty($ids)) {
            $in = str_repeat('?,', count($ids) - 1) . '?';
            $sql = "UPDATE materiel_item SET etat = 'abimee' WHERE id_item IN ($in)";
            $stmt = $this->itemModel->db->prepare($sql);
            $stmt->execute($ids);
        }

        Flight::redirect('/stock');
    }

}
