<?php
require_once __DIR__ . '/../models/typePret.php';

class TypePretController {

    public static function getAll() {
        Flight::json(TypePret::getAll());
    }

    public static function getOne($id) {
        Flight::json(TypePret::getById($id));
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = TypePret::create($data);
        Flight::json(['message' => 'Pret ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        if ((empty($data->nom) || empty($data->taux)) && Flight::request()->getBody() !== '') {
            parse_str(Flight::request()->getBody(), $tmp);
            $data = (object) $tmp;
        }

        TypePret::update($id, $data);
        Flight::json(['message' => 'Étudiant modifié']);
    }

    public static function delete($id) {
        TypePret::delete($id);
        Flight::json(['message' => 'Étudiant supprimé']);
    }
}
