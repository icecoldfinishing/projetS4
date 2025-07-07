<?php

namespace app\models\presence;

use PDO;

class PresenceModel
{
    private $db;
    private $table = 'presence';
    private $primaryKey = 'id_presence';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert(array $data) {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);
        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, array $data) {
        $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $setPart WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getBySeance($id_seances) {
        $sql = "SELECT * FROM {$this->table} WHERE id_seances = :id_seances";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_seances' => $id_seances]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
//maka eleves absents entre deux dates
    public function getAbsentByDate($date_debut, $date_fin) {
        $sql = "SELECT DISTINCT id_eleve 
                FROM {$this->table} 
                WHERE present = FALSE 
                AND id_seances IN (
                    SELECT id_seances FROM seances_cours WHERE date BETWEEN :date_debut AND :date_fin
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'date_debut' => $date_debut,
            'date_fin' => $date_fin
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //maka ireo presents entre deux dates
    public function getPresentByDate($date_debut, $date_fin) {
        $sql = "SELECT DISTINCT id_eleve 
                FROM {$this->table} 
                WHERE present = TRUE 
                AND id_seances IN (
                    SELECT id_seances FROM seances_cours WHERE date BETWEEN :date_debut AND :date_fin
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'date_debut' => $date_debut,
            'date_fin' => $date_fin
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getAbsencesByEleve($id_eleve) {
        $sql = "SELECT * FROM {$this->table} WHERE id_eleve = :id_eleve AND present = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_eleve' => $id_eleve]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function annulationPossible($id_seances) {
        $sql = "SELECT date, heure_debut FROM seances_cours WHERE id_seances = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id_seances]);
        $seance = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$seance) return false;
        $now = new \DateTime();
        $seanceDateTime = new \DateTime($seance['date'] . ' ' . $seance['heure_debut']);
        return $now < $seanceDateTime;
    }
}