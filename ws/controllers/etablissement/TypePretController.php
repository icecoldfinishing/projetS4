<?php
require_once __DIR__ . '/../../models/etablissement/typePret.php';
require_once __DIR__ . '/../../helpers/Utils.php';


class TypePretController {
    public static function getAll() {
        $typePrets = TypePret::getAll();
        Flight::json($typePrets);
    }

    public static function getById($id) {
        $typePret = TypePret::getById($id);
        Flight::json($typePret);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = TypePret::create($data);
        $dateFormatted = Utils::formatDate('2025-01-01');
        Flight::json(['message' => 'Type Pret ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        TypePret::update($id, $data);
        Flight::json(['message' => 'Type Pret modifié']);
    }

    public static function delete($id) {
        TypePret::delete($id);
        Flight::json(['message' => 'Type Pret supprimé']);
    }
}
