<?php
require_once __DIR__ . '/../../app/controllers/EtudiantController.php';
require_once __DIR__ . '/../../app/controllers/HelloController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /etudiants/@id', ['EtudiantController', 'getOne']);
Flight::route('POST /etudiants', ['EtudiantController', 'create']);
Flight::route('PUT /etudiants/@id', ['EtudiantController', 'update']);
Flight::route('DELETE /etudiants/@id', ['EtudiantController', 'delete']);

Flight::route('GET /hello', ['HelloController', 'afficher']);
