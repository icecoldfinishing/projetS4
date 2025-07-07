<?php
namespace app\controllers\statistique;

use app\models\statistique\EcolageModel;
use app\models\statistique\AbonnementModel;
use app\models\statistique\SeancesCoursModel;

use Flight;

class ReportController extends BaseController {
    private $ecolageModel;
    private $abonnementModel;
    private $seancesCoursModel;

    public function __construct() {
        $this->ecolageModel = new EcolageModel(Flight::db());
        $this->abonnementModel = new AbonnementModel(Flight::db());
        $this->seancesCoursModel = new SeancesCoursModel(Flight::db());
    }

    public function getInscriptions() {
        if (!$this->checkAuth()) return;
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('m');
        $inscriptions = $this->ecolageModel->getInscriptionsByMonth($year, $month);
        Flight::json(['inscriptions' => $inscriptions['total']]);
    }

    public function getRenewalRate() {
        if (!$this->checkAuth()) return;
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('m');
        $renewalRate = $this->abonnementModel->getRenewalRate($year, $month);
        Flight::json(['renewal_rate' => round($renewalRate, 2)]);
    }

    public function getAttendance() {
        if (!$this->checkAuth()) return;
        $year = $_GET['year'] ?? date('Y');
        $week = $_GET['week'] ?? date('W');
        $attendance = $this->seancesCoursModel->getAttendanceByWeek($year, $week);
        Flight::json(['attendance' => $attendance]);
    }

    public function getRevenueByActivity() {
        if (!$this->checkAuth()) return;
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('m');
        $revenue = $this->ecolageModel->getRevenueByMonth($year, $month);
        Flight::json(['revenue' => $revenue['total']]);
    }

    public function checkOccupancyAlerts() {
        if (!$this->checkAuth()) return;
        $year = $_GET['year'] ?? date('Y');
        $week = $_GET['week'] ?? date('W');
        $currentOccupancy = $this->seancesCoursModel->getOccupancyRate($year, $week);
        $previousOccupancy = $this->seancesCoursModel->getOccupancyRate($year, $week - 1);
        $alert = ($currentOccupancy < 60 && $previousOccupancy < 60) 
            ? 'Taux d\'occupation < 60% pendant 2 semaines consécutives' 
            : 'Taux d\'occupation OK';
        Flight::json(['occupancy' => round($currentOccupancy, 2), 'alert' => $alert]);
    }

    public function checkUnsubscribeAlerts() {
        if (!$this->checkAuth()) return;
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('m');
        $unsubscribeRate = $this->abonnementModel->getUnsubscribeRate($year, $month);
        $alert = $unsubscribeRate > 10 
            ? 'Taux de désabonnement > 10%' 
            : 'Taux de désabonnement OK';
        Flight::json(['unsubscribe_rate' => round($unsubscribeRate, 2), 'alert' => $alert]);
    }

    public function getProfitability() {
        if (!$this->checkAuth()) return;
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('m');
        $revenue = $this->ecolageModel->getRevenueByMonth($year, $month)['total'];
        $coachCost = 18 * 4 * 10000; // 18h/semaine * 4 semaines * 10 000 Ar/h
        $profit = $revenue - $coachCost;
        Flight::json(['revenue' => $revenue, 'cost' => $coachCost, 'profit' => $profit]);
    }
    public function getInscriptionsData($year, $month) {
    if (!$this->checkAuth()) return ['total' => 0];
    $result = $this->ecolageModel->getInscriptionsByMonth($year, $month);
    return ['total' => $result['total'] ?? 0];
}

public function getRenewalRateData($year, $month) {
    if (!$this->checkAuth()) return ['rate' => 0];
    $rate = $this->abonnementModel->getRenewalRate($year, $month);
    return ['rate' => round($rate, 2)];
}

public function getAttendanceData($year, $week) {
    if (!$this->checkAuth()) return [];
    return $this->seancesCoursModel->getAttendanceByWeek($year, $week);
}

public function getRevenueData($year, $month) {
    if (!$this->checkAuth()) return ['revenue' => 0];
    $result = $this->ecolageModel->getRevenueByMonth($year, $month);
    return ['revenue' => $result['total'] ?? 0];
}

public function getOccupancyAlert($year, $week) {
    if (!$this->checkAuth()) return ['occupancy' => 0, 'alert' => ''];
    $currentOccupancy = $this->seancesCoursModel->getOccupancyRate($year, $week);
    $previousOccupancy = $this->seancesCoursModel->getOccupancyRate($year, $week - 1);
    $alert = ($currentOccupancy < 60 && $previousOccupancy < 60) 
        ? 'Taux d\'occupation < 60% pendant 2 semaines consécutives' 
        : 'Taux d\'occupation OK';
    return ['occupancy' => round($currentOccupancy, 2), 'alert' => $alert];
}

public function getUnsubscribeAlert($year, $month) {
    if (!$this->checkAuth()) return ['unsubscribe_rate' => 0, 'alert' => ''];
    $unsubscribeRate = $this->abonnementModel->getUnsubscribeRate($year, $month);
    $alert = $unsubscribeRate > 10 
        ? 'Taux de désabonnement > 10%' 
        : 'Taux de désabonnement OK';
    return ['unsubscribe_rate' => round($unsubscribeRate, 2), 'alert' => $alert];
}

public function getProfitabilityData($year, $month) {
    if (!$this->checkAuth()) return ['revenue' => 0, 'cost' => 0, 'profit' => 0];
    $revenue = $this->ecolageModel->getRevenueByMonth($year, $month)['total'];
    $coachCost = 18 * 4 * 10000; // 18h/semaine * 4 semaines * 10 000 Ar/h
    $profit = $revenue - $coachCost;
    return ['revenue' => $revenue, 'cost' => $coachCost, 'profit' => $profit];
}

public function getMonthlySubscriptionData($year, $month) {
    if (!$this->checkAuth()) return [];
    
    $monthlyData = [];
    for ($i = 11; $i >= 0; $i--) {
        $m = date('m', strtotime("-$i months"));
        $y = date('Y', strtotime("-$i months"));
        
        $inscriptions = $this->ecolageModel->getInscriptionsByMonth($y, $m);
        $renewalRate = $this->abonnementModel->getRenewalRate($y, $m);
        
        $monthlyData[] = [
            'month' => date('F Y', strtotime("-$i months")),
            'inscriptions' => $inscriptions['total'] ?? 0,
            'renewalRate' => round($renewalRate, 2)
        ];
    }
    
    return $monthlyData;
}
}
?>