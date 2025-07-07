<?php
require_once __DIR__ . '/../../../ws/db.php';

class TypePret {

    // Récupère tous les types de prêts
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM typePret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un type de prêt par son ID
    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM typePret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crée un nouveau type de prêt
    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO typePret (nom, taux, duree) VALUES (?, ?, ?)");
        $stmt->execute([$data->nom, $data->taux, $data->duree]);
        return $db->lastInsertId();
    }

    // Met à jour un type de prêt
    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE typePret SET nom = ?, taux = ?, duree = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->taux, $data->duree, $id]);
    }

    // Supprime un type de prêt
    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM typePret WHERE id = ?");
        $stmt->execute([$id]);
    }
}