<?php

namespace app\models\individu;

use PDO;
use Flight;

class ParentModel {
    public function insert($nom, $prenom, $contact, $adresse) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO parent (nom, prenom, contact, adresse) VALUES (:nom, :prenom, :contact, :adresse)");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':contact' => $contact,
                ':adresse' => $adresse
            ]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM parent");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id_parent) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM parent WHERE id_parent = :id_parent");
            $stmt->execute([':id_parent' => $id_parent]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function update($id_parent, $nom, $prenom, $contact, $adresse) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE parent SET nom = :nom, prenom = :prenom, contact = :contact, adresse = :adresse WHERE id_parent = :id_parent");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':contact' => $contact,
                ':adresse' => $adresse,
                ':id_parent' => $id_parent
            ]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }

    public function delete($id_parent) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM parent WHERE id_parent = :id_parent");
            $stmt->execute([':id_parent' => $id_parent]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun parent trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }
}

