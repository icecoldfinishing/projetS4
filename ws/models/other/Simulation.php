<?php
require_once __DIR__ . '/../../../ws/db.php';

class Simulation {

    public static function save($data) {
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


    // Récupère toutes les simulations
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM simulation ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
