<?php
namespace app\models\salle;
use PDO;

class SuperviseurModel {
    private $db;
    private $table = 'superviseur';

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
