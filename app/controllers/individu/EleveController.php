<?php

namespace app\controllers\individu;

use app\models\individu\EleveModel;
use app\models\individu\ParentModel;
use app\models\individu\GenreModel;
use Flight;

class EleveController {

    public function index() {
        $eleveModel = new EleveModel();
        $eleves = $eleveModel->getWithParents();

        Flight::render('eleves/index', [
            'eleves' => $eleves
        ]);
    }

    public function show($id_eleve) {
        $eleveModel = new EleveModel();
        $eleve = $eleveModel->getByIdWithParents($id_eleve);

        if (!$eleve) {
            Flight::notFound();
            return;
        }

        $parents = $eleveModel->getParentsByEleveId($id_eleve);

        Flight::render('eleves/show', [
            'eleve' => $eleve,
            'parents' => $parents
        ]);
    }

    public function create() {
        $genreModel = new GenreModel();
        $parentModel = new ParentModel();

        $genres = $genreModel->getAll();
        $parents = $parentModel->getAll();

        Flight::render('eleves/create', [
            'genres' => $genres,
            'parents' => $parents
        ]);
    }

    public function store() {
        $data = Flight::request()->data;

        $eleveModel = new EleveModel();
        $parentModel = new ParentModel();

        // Insert student
        $result = $eleveModel->insert(
            $data->nom,
            $data->prenom,
            $data->date_naissance,
            $data->adresse,
            $data->contact,
            date('Y-m-d H:i:s'),
            $data->id_genre
        );

        if ($result === "Insertion réussie !") {
            $db = Flight::db();
            $id_eleve = $db->lastInsertId();

            // Handle parent association
            if (isset($data->existing_parent) && $data->existing_parent) {
                $eleveModel->associateParent($id_eleve, $data->existing_parent);
            } elseif (isset($data->new_parent_nom) && $data->new_parent_nom) {
                $id_parent = $parentModel->insert(
                    $data->new_parent_nom,
                    $data->new_parent_prenom,
                    $data->new_parent_contact,
                    $data->new_parent_adresse
                );
                if ($id_parent) {
                    $eleveModel->associateParent($id_eleve, $id_parent);
                }
            }

            Flight::redirect('/eleves');
        } else {
            Flight::render('eleves/create', ['error' => $result]);
        }
    }
}