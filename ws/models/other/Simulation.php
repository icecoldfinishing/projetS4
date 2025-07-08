<?php
require_once __DIR__ . '/../../../ws/db.php';

class Simulation {

    public static function save($data) {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO simulation (id_user, montant, taux, duree, mensualite, total, credit)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data->id_user,
            $data->montant,
            $data->taux,
            $data->duree,
            $data->mensualite,
            $data->total,
            $data->credit
        ]);
        return $db->lastInsertId();
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM simulation ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
