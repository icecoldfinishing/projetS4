<?php
require_once __DIR__ . '/../../app/controllers/EtudiantController.php';
require_once __DIR__ . '/../../app/controllers/other/HelloController.php';
require_once __DIR__ . '/../../app/controllers/other/LoginController.php';
require_once __DIR__ . '/../../app/controllers/client/ClientController.php';
require_once __DIR__ . '/../../app/controllers/etablissement/EtablissementController.php';
require_once __DIR__ . '/../../app/controllers/investisseur/InvestisseurController.php';

//  Étudiant
Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /etudiants/@id', ['EtudiantController', 'getOne']);
Flight::route('POST /etudiants', ['EtudiantController', 'create']);
Flight::route('PUT /etudiants/@id', ['EtudiantController', 'update']);
Flight::route('DELETE /etudiants/@id', ['EtudiantController', 'delete']);

//  Hello
Flight::route('GET /hello', ['HelloController', 'afficher']);

//  Client 
Flight::route('GET /client', ['ClientController', 'afficher']);

// Etablissement 
Flight::route('GET /etablissement', ['EtablissementController', 'afficher']);

//Investisseur
Flight::route('GET /investisseur', ['InvestisseurController', 'afficher']);

//Login
Flight::route('GET /login', ['LoginController', 'afficher']);
