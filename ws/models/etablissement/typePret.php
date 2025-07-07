<?php
require_once __DIR__ . '/../../db.php';

class typePret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM typePret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM typePret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO typePret (nom, taux, duree) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->nom, $data->taux, $data->duree]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE typePret SET nom = ?, taux = ?, duree = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->taux, $data->duree, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM typePret WHERE id = ?");
        $stmt->execute([$id]);
    }
}
