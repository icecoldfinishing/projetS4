<?php

namespace app\controllers;

use app\controllers\statistique\ReportController;
use app\models\TarifAbonnementModel\TarifAbonnementModel;
use app\models\TarifClubModel\TarifClubModel;
use app\models\TarifEcolageModel\TarifEcolageModel;

use Flight;

class Controller {

    public function __construct() {
    }

    public function acceuil() {
        Flight::render('acceuil');
    }

    public function login() {
        Flight::render('template/auth/login');

    }
    public function signin() {
        Flight::render('template/auth/signin');

    }

    public function demographie() {
        Flight::render('statistique/demographie');
    }

    // en utilisation
    public function abonnement() {
        $reportController = new ReportController();
        
        // Paramètres de date
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('m');
        $week = $_GET['week'] ?? date('W');
        
        // Données d'abonnement
        $inscriptions = $reportController->getInscriptionsData($year, $month);
        $renewalRate = $reportController->getRenewalRateData($year, $month);
        $newSubscriptions = $inscriptions['total'] - ($inscriptions['total'] * $renewalRate['rate'] / 100);
        
        // Données mensuelles
        $monthlyData = $reportController->getMonthlySubscriptionData($year, $month);
        
        // Données de présence
        $attendanceData = $reportController->getAttendanceData($year, $week);
        
        // Données de revenus
        $revenueData = $reportController->getRevenueData($year, $month);
        
        // Alertes
        $occupancyAlert = $reportController->getOccupancyAlert($year, $week);
        $unsubscribeAlert = $reportController->getUnsubscribeAlert($year, $month);
        
        // Rentabilité
        $profitability = $reportController->getProfitabilityData($year, $month);
        
        // Rendre la vue avec toutes les données
        Flight::render('statistique/abonnement', [
            // Données abonnement
            'totalClients' => $inscriptions['total'],
            'totalReabonnement' => round($inscriptions['total'] * $renewalRate['rate'] / 100),
            'totalNouveau' => round($newSubscriptions),
            'reabonnementPourcentage' => round($renewalRate['rate'], 2),
            'nouveauPourcentage' => round(100 - $renewalRate['rate'], 2),
            'monthlyData' => $monthlyData,
            
            // Données présence
            'attendanceData' => $attendanceData,
            'occupancyRate' => $occupancyAlert['occupancy'],
            'occupancyAlert' => $occupancyAlert['alert'],
            
            // Données financières
            'revenue' => $revenueData['revenue'],
            'unsubscribeRate' => $unsubscribeAlert['unsubscribe_rate'],
            'unsubscribeAlert' => $unsubscribeAlert['alert'],
            'profit' => $profitability['profit'],
            'cost' => $profitability['cost'],
            
            // Paramètres date
            'year' => $year,
            'month' => $month,
            'week' => $week
        ]);
    }

    public function presence() {
        Flight::render('suivi/presence');
    }

    public function personnel() {
        Flight::render('suivi/personnel');
    }

    public function club() {
        Flight::render('suivi/club');
    }

    // en utilisation
    public function tarif() {
        $m1 = new TarifAbonnementModel();
        $m2 = new TarifEcolageModel();
        $m3 = new TarifClubModel();

        $tarifAbo = $m1->getCurrentTarif();
        $tarifEcoEnfant = $m2->getCurrentTarifEnfant();
        $tarifEcoAdult = $m2->getCurrentTarifAdulte();
        $tarifClub = $m3->getCurrentTarif();

        Flight::render('gestion/tarif', [
            'abonnement' => isset($tarifAbo['montant']) ? $tarifAbo['montant'] : null,
            'ecolageEnfant' => isset($tarifEcoEnfant['montant']) ? $tarifEcoEnfant['montant'] : null,
            'ecolageAdult' => isset($tarifEcoAdult['montant']) ? $tarifEcoAdult['montant'] : null,
            'club' => isset($tarifClub['montant_par_heure']) ? $tarifClub['montant_par_heure'] : null,
        ]);
    }


    public function edt() {
        Flight::render('gestion/edt');
    }

    public function finance() {
        Flight::render('gestion/finance');
    }

}
