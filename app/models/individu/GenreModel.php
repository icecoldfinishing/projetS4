<?php

namespace app\models\individu;

use PDO;
use Flight;

class GenreModel {
    public function insert($libelle) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO genre (libelle) VALUES (:libelle)");
            $stmt->execute([':libelle' => $libelle]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM genre");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id_genre) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM genre WHERE id_genre = :id_genre");
            $stmt->execute([':id_genre' => $id_genre]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function update($id_genre, $libelle) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE genre SET libelle = :libelle WHERE id_genre = :id_genre");
            $stmt->execute([':libelle' => $libelle, ':id_genre' => $id_genre]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }

    public function delete($id_genre) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM genre WHERE id_genre = :id_genre");
            $stmt->execute([':id_genre' => $id_genre]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun genre trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }
}

