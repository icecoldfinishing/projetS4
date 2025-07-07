<?php
namespace app\models\salle;

use PDO;

class HistoriqueGardeModel {
    private $db;
    private $table = 'historique_garde';

    public function __construct($db) {
        $this->db = $db;
    }

    public function all() {
        $stmt = $this->db->query("SELECT hg.*, s.nom, s.prenom FROM {$this->table} hg JOIN superviseur s ON hg.id_superviseur = s.id_superviseur ORDER BY hg.date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_historique = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (id_superviseur, date, heure) VALUES (:id_superviseur, :date, :heure)");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET id_superviseur = :id_superviseur, date = :date, heure = :heure WHERE id_historique = :id");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_historique = :id");
        return $stmt->execute([':id' => $id]);
    }
}