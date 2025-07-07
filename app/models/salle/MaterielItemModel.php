<?php
namespace app\models\salle;
use PDO;

class MaterielItemModel {
    public $db;
    private $table = 'materiel_item';

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByType($id_type) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_type = :id_type");
        $stmt->execute([':id_type' => $id_type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableItemsByType($id_type) {
        $sql = "
        SELECT * FROM materiel_item
        WHERE id_type = :id_type
        AND etat = 'neuve'
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_type' => $id_type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id_item)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_item = :id_item");
        $stmt->execute([':id_item' => $id_item]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
