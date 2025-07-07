<?php

namespace app\models\GroupeModels;

use PDO;
use Flight;

class HoraireModel {

   public function insert($jour, $debut, $fin) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO horaire (jour, debut, fin) VALUES (:jour, :debut, :fin)");
            $stmt->execute([
                ':jour' => $jour,
                ':debut' => $debut,
                ':fin' => $fin  // Fixed: was missing the colon
            ]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM horaire");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM horaire WHERE id_horaire = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getByjour($jour) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM horaire WHERE jour = :jour");
            $stmt->execute([':jour' => $jour]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM horaire WHERE id_horaire = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun groupe trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

    public function update($id, $nom_responsable, $contact, $nombre, $discipline) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE club_groupe SET nom_responsable = :nom_responsable, contact = :contact, nombre = :nombre, discipline = :discipline WHERE id = :id");
            $stmt->execute([
                ':nom_responsable' => $nom_responsable,
                ':contact' => $contact,
                ':nombre' => $nombre,
                ':id' => $id,
                ':discipline' => $discipline
            ]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }
}
