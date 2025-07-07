<?php

namespace app\controllers;

use app\models\Status;
use Flight;

class Controller {

    public function __construct() {
    }

    public function acceuil() {
        Flight::render('acceuil');
    }
}
