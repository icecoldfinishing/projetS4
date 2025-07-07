<?php
require_once __DIR__ . '/../../models/etablissement/TypePret.php';
require_once __DIR__ . '/../../helpers/Utils.php';

class TypePretController
{
    /* ----------  API : JSON only  ---------- */

    public static function getAllJson()
    {
        $typePrets = TypePret::getAll();
        Flight::json($typePrets); 
    }

    public static function getById($id)
    {
        $typePret = TypePret::getById($id);
        Flight::json($typePret);
    }

    public static function create()
    {
        $data = Flight::request()->data;
        $id   = TypePret::create($data);
        Flight::json(['message' => 'Type prêt ajouté', 'id' => $id]);
    }

    public static function update($id)
    {
        $data = Flight::request()->data;
        TypePret::update($id, $data);
        Flight::json(['message' => 'Type prêt modifié']);
    }

    public static function delete($id)
    {
        TypePret::delete($id);
        Flight::json(['message' => 'Type prêt supprimé']);
    }


    public static function showPage()
    {
        include __DIR__ . '/../../views/etablissement/typePret.php';
    }
}

