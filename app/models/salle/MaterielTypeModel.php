<?php
namespace app\models\salle;
use PDO;

class MaterielTypeModel {
    public $db;
    private $table = 'materiel_type';

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY reference");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_type = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (reference, label, description, prix)
         VALUES (:reference, :label, :description, :prix)"
        );
        return $stmt->execute([
            ':reference'   => $data['reference'],
            ':label'       => $data['label'],
            ':description' => $data['description'] ?? null,
            ':prix'        => $data['prix'] ?? 0
        ]);
    }


    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
         SET label = :label, description = :description, prix = :prix
         WHERE id_type = :id"
        );
        return $stmt->execute([
            ':label'       => $data['label'],
            ':description' => $data['description'] ?? null,
            ':prix'        => $data['prix'] ?? 0,
            ':id'          => $id
        ]);
    }


    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_type = :id");
        return $stmt->execute([':id' => $id]);
    }



}