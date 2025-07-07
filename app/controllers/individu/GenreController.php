<?php
namespace app\controllers\individu;

use app\models\individu\GenreModel;
use Flight;

class GenreController {
    private $model;
    public function __construct() {
        $this->model = new GenreModel();
    }

    public function getAll() {
        $genres = $this->model->getAll();
        Flight::json($genres);
    }
}

