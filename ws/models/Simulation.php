<?php
require_once __DIR__ . '/../db.php';

class Simulation {
    public static function getAllByUserId($userId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM simulation WHERE id_user = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM simulation WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO simulation (
                id_user, montant, taux, taux_assurance, duree,
                mensualite_base, cout_assurance_mensuelle, mensualite,
                cout_total, cout_interet, cout_assurance_total, cout_credit
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data->id_user,
            $data->montant,
            $data->taux,
            $data->taux_assurance,
            $data->duree,
            $data->mensualite_base,
            $data->cout_assurance_mensuelle,
            $data->mensualite,
            $data->cout_total,
            $data->cout_interet,
            $data->cout_assurance_total,
            $data->cout_credit
        ]);
        return $db->lastInsertId();
    }
}
