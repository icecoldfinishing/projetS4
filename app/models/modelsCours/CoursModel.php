<?php

namespace app\models\modelsCours;
use PDO;
use Exception;

class CoursModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM cours")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM cours WHERE id_cours = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($label) {
        $stmt = $this->db->prepare("INSERT INTO cours(label) VALUES (?)");
        return $stmt->execute([$label]);
    }

    public function update($id, $label) {
        $stmt = $this->db->prepare("UPDATE cours SET label = ? WHERE id_cours = ?");
        return $stmt->execute([$label, $id]);
    }

    public function delete($id) {
        try {
            $this->db->beginTransaction();

            // 1. Supprimer les planifications liées aux séances du cours
            $stmt1 = $this->db->prepare("
                DELETE FROM planification_cours 
                WHERE id_seance IN (
                    SELECT id_seances FROM seances_cours WHERE id_cours = ?
                )
            ");
            $stmt1->execute([$id]);

            // 2. Supprimer les historiques des séances liées
            $stmt2 = $this->db->prepare("
                DELETE FROM historique_seances 
                WHERE id_seances IN (
                    SELECT id_seances FROM seances_cours WHERE id_cours = ?
                )
            ");
            $stmt2->execute([$id]);

            // 3. Supprimer les séances liées à ce cours
            $stmt3 = $this->db->prepare("
                DELETE FROM seances_cours WHERE id_cours = ?
            ");
            $stmt3->execute([$id]);

            // 4. Supprimer le cours lui-même
            $stmt4 = $this->db->prepare("
                DELETE FROM cours WHERE id_cours = ?
            ");
            $stmt4->execute([$id]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Erreur suppression cours : " . $e->getMessage());
            return false;
        }
    }
}