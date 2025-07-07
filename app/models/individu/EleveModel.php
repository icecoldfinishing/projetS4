<?php

namespace app\models\individu;

use PDO;
use Flight;

class EleveModel {
    public function insert($nom, $prenom, $date_naissance, $adresse, $contact, $date_inscription, $id_genre) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO eleve (nom, prenom, date_naissance, adresse, contact, date_inscription, id_genre) VALUES (:nom, :prenom, :date_naissance, :adresse, :contact, :date_inscription, :id_genre)");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':date_naissance' => $date_naissance,
                ':adresse' => $adresse,
                ':contact' => $contact,
                ':date_inscription' => $date_inscription,
                ':id_genre' => $id_genre
            ]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM eleve");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id_eleve) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM eleve WHERE id_eleve = :id_eleve");
            $stmt->execute([':id_eleve' => $id_eleve]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function update($id_eleve, $nom, $prenom, $date_naissance, $adresse, $contact, $date_inscription, $id_genre) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE eleve SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, adresse = :adresse, contact = :contact, date_inscription = :date_inscription, id_genre = :id_genre WHERE id_eleve = :id_eleve");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':date_naissance' => $date_naissance,
                ':adresse' => $adresse,
                ':contact' => $contact,
                ':date_inscription' => $date_inscription,
                ':id_genre' => $id_genre,
                ':id_eleve' => $id_eleve
            ]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }

    public function delete($id_eleve) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM eleve WHERE id_eleve = :id_eleve");
            $stmt->execute([':id_eleve' => $id_eleve]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun élève trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }
    public function getWithParents() {
        try {
            $db = Flight::db();
            $stmt = $db->query("
                SELECT e.*, g.label as genre_label 
                FROM eleve e 
                LEFT JOIN genre g ON e.id_genre = g.id_genre 
                ORDER BY e.nom, e.prenom
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getByIdWithParents($id_eleve) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                SELECT e.*, g.label as genre_label 
                FROM eleve e 
                LEFT JOIN genre g ON e.id_genre = g.id_genre 
                WHERE e.id_eleve = :id_eleve
            ");
            $stmt->execute([':id_eleve' => $id_eleve]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getParentsByEleveId($id_eleve) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                SELECT p.* 
                FROM parent p 
                JOIN parent_eleve pe ON p.id_parent = pe.id_parent 
                WHERE pe.id_eleve = :id_eleve
            ");
            $stmt->execute([':id_eleve' => $id_eleve]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function associateParent($id_eleve, $id_parent) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO parent_eleve (id_eleve, id_parent) VALUES (:id_eleve, :id_parent)");
            $stmt->execute([':id_eleve' => $id_eleve, ':id_parent' => $id_parent]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}

