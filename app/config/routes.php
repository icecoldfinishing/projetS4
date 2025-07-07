<?php

//importation de controller
use app\controllers\Controller;
use app\controllers\controllersCours\CalendrierController;
use app\controllers\controllersCours\CoursController;
use app\controllers\controllersCours\SeancesController;
use app\controllers\finance\SortieController;
use app\controllers\GroupesControllers\GroupeController;
use app\controllers\GroupesControllers\ReservationController;
use app\controllers\PaiementController;
use app\controllers\SalaireController;
use app\controllers\presence\PresenceController;
use app\controllers\salle\DashboardController;
use app\controllers\salle\FacturationController;
use app\controllers\salle\SuiviSalleController;
use app\controllers\statistique\ReportController;
use app\controllers\individu\ParentController;
use app\controllers\individu\EleveController;
use app\controllers\individu\GenreController;
use app\controllers\individu\ProfController;
use app\controllers\individu\SuperviseurController;

// tarif
use app\controllers\TarifAbonnementController\TarifAbonnementController;
use app\controllers\TarifClubController\TarifClubController;
use app\controllers\TarifEcolageController\TarifEcolageController;
use app\models\TarifClubModel\TarifClubModel;
use flight\Engine;
use flight\net\Router;

// Routes pour la gestion des sorties
$sortieController = new SortieController();
Flight::route('GET /api/sorties/motifs', [$sortieController, 'getMotifs']);
Flight::route('GET /api/sorties/statuts', [$sortieController, 'getStatuts']);
Flight::route('GET /api/sorties/categories', [$sortieController, 'getCategories']);
Flight::route('GET /api/sorties/statistiques', [$sortieController, 'getStatistiques']);
Flight::route('GET /api/sorties', [$sortieController, 'getSorties']);
Flight::route('POST /api/sorties', [$sortieController, 'createSortie']);
Flight::route('GET /api/sorties/modes-paiement', [$sortieController, 'getModePaiements']);
Flight::route('GET /api/sorties/@id', [$sortieController, 'getSortieDetails']);
Flight::route('PUT /api/sorties/@id/statut', [$sortieController, 'updateStatut']);




// Routes existantes pour les salaires
Flight::route('GET /gestion/finance/salaires', function() {
    $controller = new SalaireController();
    $controller->index();
});


// Routes pour la gestion des salaires
Flight::route('GET /api/employes', function() {
    $controller = new SalaireController();
    $controller->getAllEmployes();
});

Flight::route('GET /api/employes/@id', function($id) {
    $controller = new SalaireController();
    $controller->getEmployeById($id);
});

Flight::route('GET /api/salaires/config', function() {
    $controller = new SalaireController();
    $controller->getSalairesConfig();
});

Flight::route('PUT /api/salaires/config', function() {
    $controller = new SalaireController();
    $controller->modifierSalaireType();
});

Flight::route('POST /api/salaires/payer', function() {
    $controller = new SalaireController();
    $controller->payerSalaire();
});

Flight::route('PUT /api/salaires/config', function() {
    $controller = new SalaireController();
    $controller->modifierConfigurationSalaire();
});

Flight::route('GET /api/employes/recherche', function() {
    $controller = new SalaireController();
    $controller->rechercherEmployes();
});

Flight::route('GET /api/salaires/statistiques', function() {
    $controller = new SalaireController();
    $controller->getStatistiques();
});


// Add these routes to your routes.php file:

// Replace the existing genre and staff routes in routes.php with these:
Flight::route('GET /gestion/finance/paiements', function() {
    $controller = new PaiementController();
    $controller->index();
});

Flight::route('POST /api/paiements', function() {
    $controller = new PaiementController();
    $controller->enregistrerPaiement();
});

Flight::route('GET /api/reservations', function() {
    $controller = new PaiementController();
    $controller->getReservations();
});

Flight::route('GET /api/reservations/@id', function($id) {
    $controller = new PaiementController();
    $controller->getReservationDetails($id);
});

Flight::route('DELETE /api/paiements/@id_reservation', function($id_reservation) {
    $controller = new PaiementController();
    $controller->supprimerPaiement($id_reservation);
});


// Genre routes
Flight::route('GET /api/genres', function() {
    $controller = new GenreController();
    $controller->getAll();
});

// Staff routes using Flight::route (consistent with existing prof/superviseur routes)
Flight::route('GET /api/staff/@type', function($type) {
    if ($type === 'prof') {
        $controller = new ProfController();
        $controller->getAll();
    } elseif ($type === 'superviseur') {
        $controller = new SuperviseurController();
        $controller->getAll();
    } else {
        Flight::json(['error' => 'Invalid staff type']);
    }
});

Flight::route('POST /api/staff/@type', function($type) {
    if ($type === 'prof') {
        $controller = new ProfController();
        $controller->insert();
    } elseif ($type === 'superviseur') {
        $controller = new SuperviseurController();
        $controller->insert();
    } else {
        Flight::json(['error' => 'Invalid staff type']);
    }
});

Flight::route('POST /api/staff/@type/update/@id', function($type, $id) {
    if ($type === 'prof') {
        $controller = new ProfController();
        $controller->update($id);
    } elseif ($type === 'superviseur') {
        $controller = new SuperviseurController();
        $controller->update($id);
    } else {
        Flight::json(['error' => 'Invalid staff type']);
    }
});

Flight::route('POST /api/staff/@type/delete/@id', function($type, $id) {
    if ($type === 'prof') {
        $controller = new ProfController();
        $controller->delete($id);
    } elseif ($type === 'superviseur') {
        $controller = new SuperviseurController();
        $controller->delete($id);
    } else {
        Flight::json(['error' => 'Invalid staff type']);
    }
});
$profController = new ProfController();
$superviseurController = new SuperviseurController();
$genreController = new GenreController();

// Professeur
$router->get('/api/profs', [ $profController, 'getAll' ]);
$router->get('/api/prof/@id:[0-9]+', [ $profController, 'getById' ]);
$router->post('/api/prof', [ $profController, 'insert' ]);
$router->post('/api/prof/update/@id:[0-9]+', [ $profController, 'update' ]);
$router->post('/api/prof/delete/@id:[0-9]+', [ $profController, 'delete' ]);

// Superviseur
$router->get('/api/superviseurs', [ $superviseurController, 'getAll' ]);
$router->get('/api/superviseur/@id:[0-9]+', [ $superviseurController, 'getById' ]);
$router->post('/api/superviseur', [ $superviseurController, 'insert' ]);
$router->post('/api/superviseur/update/@id:[0-9]+', [ $superviseurController, 'update' ]);
$router->post('/api/superviseur/delete/@id:[0-9]+', [ $superviseurController, 'delete' ]);
//

// Parent routes (add after the superviseur routes)
$parentController = new ParentController();

$router->get('/api/parents', [ $parentController, 'getAll' ]);
$router->get('/api/parent/@id:[0-9]+', [ $parentController, 'getById' ]);
$router->post('/api/parent', [ $parentController, 'insert' ]);
$router->post('/api/parent/update/@id:[0-9]+', [ $parentController, 'update' ]);
$router->post('/api/parent/delete/@id:[0-9]+', [ $parentController, 'delete' ]);

// Eleves routes
$eleveController = new EleveController();

Flight::route('GET /eleves', [$eleveController, 'index']);
Flight::route('GET /eleves/create', [$eleveController, 'create']);
Flight::route('POST /eleves', [$eleveController, 'store']);
Flight::route('GET /eleves/@id_eleve', [$eleveController, 'show']);

$Controller = new Controller();
// exemple de base
$router->get('/', [ $Controller, 'acceuil' ]);
$router->get('/login', [ $Controller, 'login' ]);
$router->get('/signin', [ $Controller, 'login' ]);

// page statistique
$router->get('/demographie', [ $Controller, 'demographie' ]);
$router->get('/abonnement', [ $Controller, 'abonnement' ]);

// page suivi
$router->get('/presence', [ $Controller, 'presence' ]);
$router->get('/personnel', [ $Controller, 'personnel' ]);
$router->get('/club', [ $Controller, 'club' ]);

$router->get('/salle', [ $Controller, 'club' ]);

// page gestion
$router->get('/tarif', [ $Controller, 'tarif' ]);

$ecolage = new TarifEcolageController();
$abonnement = new TarifAbonnementController();
$club = new TarifClubController();
$router->post('/tarif/update/enfant', [ $ecolage, 'updateTarifEnfant' ]);
$router->post('/tarif/update/adulte', [ $ecolage, 'updateTarifAdulte' ]);
$router->post('/tarif/update/abonnement', [ $abonnement, 'updateTarifAbonnement' ]);
$router->post('/tarif/update/club', [ $club, 'updateTarifClub' ]);


$router->get('/edt', [ $Controller, 'edt' ]);
$router->get('/finance', [ $Controller, 'finance' ]);


//Groupe&Reservation
$GroupeController = new GroupeController();
$ReservationController = new ReservationController();


$router->get('/test', function() {
    Flight::json(['message' => 'Test OK']);
});

// Routes API pour les groupes
Flight::route('GET /groupes/api/all', [$GroupeController, 'getAllGroupesAPI']);
Flight::route('POST /groupes/api/insert', [$GroupeController, 'insertGroupeAPI']);
Flight::route('DELETE /groupes/api/delete/@id', [$GroupeController, 'deleteGroupeAPI']);

// Routes pour les pages de gestion des groupes
Flight::route('GET /groupes/insert', [$GroupeController, 'formGroupe']);
Flight::route('POST /groupes/insert', [$GroupeController, 'InsertGroupe']);
Flight::route('GET /groupes/update/@id', [$GroupeController, 'GetGroupeById']);
Flight::route('POST /groupes/update/@id', [$GroupeController, 'UpdateGroupe']);
Flight::route('GET /groupes/details/@id', [$GroupeController, 'GetGroupeById']);
Flight::route('DELETE /groupes/delete/@id', [$GroupeController, 'DeleteGroupe']);
Flight::route('GET /groupes', [$GroupeController, 'GetAllGroupes']);

// Routes pour la page de suivi des clubs
Flight::route('GET /suivi/club', [$GroupeController, 'showClubTracking']);
Flight::route('GET /suivi/club/@year/@month', [$GroupeController, 'showClubTracking']);

// Routes pour les détails du calendrier
Flight::route('GET /api/day-details/@date', [$GroupeController, 'getDayDetails']);
Flight::route('GET /api/monthly-data/@year/@month', [$GroupeController, 'getMonthlyData']);
Flight::route('GET /api/month/@year/@month', [$GroupeController, 'getMonthlyData']);


$router->get('/reservations', [ $ReservationController, 'GetAllReservations' ]);
$router->get('/reservation/@id:[0-9]+', [ $ReservationController, 'GetReservationById' ]);
$router->get('/reservation/insert', [ $ReservationController, 'formReservation' ]);
$router->post('/reservation/insert', [ $ReservationController, 'InsertReservation' ]);
$router->post('/reservation/update/@id:[0-9]+', [ $ReservationController, 'UpdateReservation' ]);
$router->get('/reservation/delete/@id:[0-9]+', [ $ReservationController, 'DeleteReservation' ]);


//presences
$presenceController = new PresenceController();

$router->get('/presences', [ $presenceController, 'index' ]);
$router->get('/presence/seance/@id_seances:[0-9]+', [ $presenceController, 'showFeuillePresence' ]);
$router->post('/presence', function() use ($presenceController) {
    $data = $_POST;
    return $presenceController->store($data);
});

$router->post('/presence/update/@id:[0-9]+', function($id) use ($presenceController) {
    $data = $_POST;
    return $presenceController->update($id, $data);
});

$router->post('/presence/delete/@id:[0-9]+', function($id) use ($presenceController) {
    return $presenceController->delete($id);
});

$router->get('/presence/absences/@id_eleve:[0-9]+', [ $presenceController, 'showAbsencesEleve' ]);
$router->get('/presence/absents/@date_debut:[0-9]{4}-[0-9]{2}-[0-9]{2}/@date_fin:[0-9]{4}-[0-9]{2}-[0-9]{2}', [ $presenceController, 'showAbsentsParDate' ]);
$router->get('/presence/presents/@date_debut:[0-9]{4}-[0-9]{2}-[0-9]{2}/@date_fin:[0-9]{4}-[0-9]{2}-[0-9]{2}', [ $presenceController, 'showPresentsParDate' ]);
$router->get('/presence/annulation-possible/@id_seances:[0-9]+', function($id_seances) use ($presenceController) {
    return $presenceController->annulationPossible($id_seances) ? 'true' : 'false';
});

// emploi du temps
$coursController = new CoursController();
$seancesController = new SeancesController();
$calendrierController = new CalendrierController();
// Cours
$router->get('/listeCours',[$coursController,'getAllCours']);
$router->get('/formCours', [$coursController, 'getFormCours']);
$router->post('/insertCours', [$coursController, 'insertCours']);
$router->post('/updateCours', [$coursController, 'updateCours']);
$router->get('/deleteCours', [$coursController, 'deleteCours']);
// Seances
$router->get('/formSeance', [$seancesController, 'getFormSeance']);
$router->post('/insertSeance', [$seancesController, 'insertSeance']);
$router->post('/updateSeance', [$seancesController, 'updateSeance']);
$router->get('/deleteSeance', [$seancesController, 'deleteSeance']);
$router->get('/listeSeances', [$seancesController, 'getAllSeances']);
$router->get('/historiqueSeances', [$seancesController, 'historiqueSeances']);
// EDT
$router->get('/calendrier', [$calendrierController, 'afficherMois']);
$router->get('/calendrier/details', [$calendrierController, 'detailsGroupe']);


// abonnement 
$router->get('/api/reports/inscriptions', [ReportController::class, 'getInscriptions']);
$router->get('/api/reports/renewal', [ReportController::class, 'getRenewalRate']);
$router->get('/api/reports/attendance', [ReportController::class, 'getAttendance']);
$router->get('/api/reports/revenue', [ReportController::class, 'getRevenueByActivity']);
$router->get('/api/reports/occupancy_alerts', [ReportController::class, 'checkOccupancyAlerts']);
$router->get('/api/reports/unsubscribe_alerts', [ReportController::class, 'checkUnsubscribeAlerts']);
$router->get('/api/reports/profitability', [ReportController::class, 'getProfitability']);


// salle
define('BASE', '/materiel');
Flight::route("GET " . BASE,                ['app\\controllers\\salle\\MaterielTypeController', 'index']);
Flight::route("GET " . BASE . "/create",    ['app\\controllers\\salle\\MaterielTypeController', 'create']);
Flight::route("POST " . BASE . "/store",    ['app\\controllers\\salle\\MaterielTypeController', 'store']);
Flight::route("GET " . BASE . "/@id",       ['app\\controllers\\salle\\MaterielTypeController', 'show']);
Flight::route("GET " . BASE . "/@id/edit",  ['app\\controllers\\salle\\MaterielTypeController', 'edit']);
Flight::route("POST " . BASE . "/@id/update", ['app\\controllers\\salle\\MaterielTypeController', 'update']);
Flight::route("GET " . BASE . "/@id/delete", ['app\\controllers\\salle\\MaterielTypeController', 'delete']);


Flight::route('GET /stock', ['app\\controllers\\salle\\StockMaterielController', 'index']);
Flight::route('POST /stock/add', ['app\\controllers\\salle\\StockMaterielController', 'store']);
Flight::route('GET /stock/delete/@id', function($id) {
    (new app\controllers\salle\StockMaterielController())->delete($id);
});
Flight::route('GET /stock/confirmation/@mouvement/@id_type/@quantite', function($mouvement, $id_type, $quantite){
    (new app\controllers\salle\StockMaterielController())->confirm($mouvement, $id_type, $quantite);
});
Flight::route('POST /stock/insert-series', ['app\\controllers\\salle\\StockMaterielController', 'insertSeries']);
Flight::route('POST /stock/remove-items', ['app\\controllers\\salle\\StockMaterielController', 'removeItems']);


$c = new SuiviSalleController();
Flight::route('GET /suivi-salle', [$c, 'index']);
Flight::route('POST /suivi-salle/add', [$c, 'store']);
Flight::route('GET /suivi-salle/delete/@id', function($id) {
    (new SuiviSalleController())->delete($id);
});


$facturationController = new  FacturationController();
Flight::route('GET /facturation/creer/@id_suivi_salle', function($id) {
    (new  FacturationController())->create($id);
});
Flight::route('POST /facturation/valider', [$facturationController, 'store']);
Flight::route('/facturation/pdf/@id', [$facturationController, 'generatePdf']);
Flight::route('GET /facturation/liste', [$facturationController, 'liste']);
Flight::route('GET /facturation/valider/@id_facture', [$facturationController, 'valider']);


// Liste des historiques
Flight::route('GET /historique-garde', ['app\\controllers\\salle\\HistoriqueGardeController', 'index']);
// Formulaire création
Flight::route('GET /historique-garde/create', ['app\\controllers\\salle\\HistoriqueGardeController', 'createForm']);
// Soumission création
Flight::route('POST /historique-garde/create', ['app\\controllers\\salle\\HistoriqueGardeController', 'create']);
// Formulaire modification
Flight::route('GET /historique-garde/edit/@id', ['app\\controllers\\salle\\HistoriqueGardeController', 'editForm']);
// Soumission modification
Flight::route('POST /historique-garde/edit/@id', ['app\\controllers\\salle\\HistoriqueGardeController', 'update']);
// Suppression
Flight::route('GET /historique-garde/delete/@id', ['app\\controllers\\salle\\HistoriqueGardeController', 'delete']);


$dashboardController = new  DashboardController();
Flight::route('GET /dashboard', [$dashboardController, 'index']);



//// Genre
//$router->get('/api/genres', [ $genreController, 'getAll' ]);
?>