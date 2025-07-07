<?php
require_once __DIR__ . '/../models/Etudiant.php';

class EtudiantController {

    public static function getAll() {
        Flight::json(Etudiant::getAll());
    }

    public static function getOne($id) {
        Flight::json(Etudiant::getById($id));
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Etudiant::create($data);
        Flight::json(['message' => 'Étudiant ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;

        // fallback si $data est vide à cause d’un PUT mal encodé
        if ((empty($data->nom) || empty($data->email)) && Flight::request()->getBody() !== '') {
            parse_str(Flight::request()->getBody(), $tmp);
            $data = (object) $tmp;
        }

        Etudiant::update($id, $data);
        Flight::json(['message' => 'Étudiant modifié']);
    }

    public static function delete($id) {
        Etudiant::delete($id);
        Flight::json(['message' => 'Étudiant supprimé']);
    }
}
