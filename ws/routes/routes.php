<?php
require_once __DIR__ . '/../controllers/EtudiantController.php';
require_once __DIR__ . '/../controllers/other/HelloController.php';
require_once __DIR__ . '/../controllers/other/LoginController.php';
require_once __DIR__ . '/../controllers/client/ClientController.php';
require_once __DIR__ . '/../controllers/etablissement/EtablissementController.php';
require_once __DIR__ . '/../controllers/etablissement/TypePretController.php';
require_once __DIR__ . '/../controllers/investisseur/InvestisseurController.php';

//  Étudiant
Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /etudiants/@id', ['EtudiantController', 'getOne']);
Flight::route('POST /etudiants', ['EtudiantController', 'create']);
Flight::route('PUT /etudiants/@id', ['EtudiantController', 'update']);
Flight::route('DELETE /etudiants/@id', ['EtudiantController', 'delete']);

// --- API
Flight::route('GET  /typePrets',           ['TypePretController', 'getAllJson']);
Flight::route('GET  /typePrets/@id',       ['TypePretController', 'getById']);
Flight::route('POST /typePrets',           ['TypePretController', 'create']);
Flight::route('PUT  /typePrets/@id',       ['TypePretController', 'update']);
Flight::route('DELETE /typePrets/@id',     ['TypePretController', 'delete']);

// --- Front‑end page
Flight::route('GET /typePretPage',         ['TypePretController', 'showPage']);

//  Hello
Flight::route('GET /hello', ['HelloController', 'afficher']);

//  Client 
Flight::route('GET /client', ['ClientController', 'afficher']);
Flight::route('GET /demande', ['ClientController', 'demande']);
Flight::route('POST /client/create', ['ClientController', 'store']);


// Etablissement 
Flight::route('GET /etablissement', ['EtablissementController', 'afficher']);

//Investisseur
Flight::route('GET /investisseur', ['InvestisseurController', 'afficher']);

// Login
Flight::route('GET /login', ['LoginController', 'afficher']);
Flight::route('POST /login', ['LoginController', 'connecter']);
