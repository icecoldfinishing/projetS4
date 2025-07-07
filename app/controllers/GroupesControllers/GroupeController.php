<?php

namespace app\controllers\GroupesControllers;

use app\models\GroupeModels\GroupeModel;
use Flight;

class GroupeController {

    private GroupeModel $model;

    public function __construct() {
        $this->model = new GroupeModel();
    }

    public function formGroupe() {
        $message = "ok";

        Flight::render('gestion/GroupeViews/InsertGroupe', [
            'message' => $message
        ]);
    }

    public function InsertGroupe() {
        $data = Flight::request()->data;
        $message = $this->model->insert($data->nom_responsable, $data->contact, $data->nombre, $data->discipline);

        Flight::render('gestion/GroupeViews/InsertGroupe', [
            'message' => $message
        ]);
    }

    public function GetAllGroupes() {
        $groupes = $this->model->getAll();

        Flight::render('gestion/GroupeViews/ListGroupes', [
            'groupes' => $groupes
        ]);
    }

    public function GetGroupeById($id) {
        $groupe = $this->model->getById($id);

        Flight::render('gestion/GroupeViews/UpdateGroupe', [
            'groupe' => $groupe
        ]);
    }

    public function UpdateGroupe($id) {
        $groupe = $this->model->getById($id);
        $data = Flight::request()->data;
        $message = $this->model->update($id, $data->nom_responsable, $data->contact, $data->nombre, $data->discipline);

        Flight::render('gestion/GroupeViews/UpdateGroupe', [
            'message' => $message,
            'groupe' => $groupe
        ]);
    }

    public function DeleteGroupe($id) {
        $message = $this->model->delete($id);

        Flight::render('gestion/GroupeViews/DeleteGroupe', [
            'message' => $message
        ]);
    }
    public function showClubTracking() {
            $year = Flight::request()->query->year ?? date('Y');
            $month = Flight::request()->query->month ?? date('m');

            // Récupérer les données du planning
            $scheduleData = $this->model->getScheduleData($year, $month);
            $monthlyStats = $this->model->getMonthlyStats($year, $month);

            // Récupérer tous les groupes pour l'onglet "Liste des Groupes"
            $groupes = $this->model->getAll();

            // Formatter les données pour le template
            $formattedSchedule = $this->formatScheduleForCalendar($scheduleData);

            Flight::render('suivi/club', [
                'scheduleData' => $formattedSchedule,
                'monthlyStats' => $monthlyStats,
                'currentYear' => $year,
                'currentMonth' => $month,
                'groupes' => $groupes  // Add this line
            ]);
        }
    // Dans GroupeController.php, modifiez la méthode getDayDetails
    public function getDayDetails($date) {
        try {
            $db = Flight::db();

            // Vérifier si c'est un jour fermé
            $dayOfWeek = strtolower(date('l', strtotime($date)));
            $dayMapping = [
                'wednesday' => 'mercredi',
                'saturday' => 'samedi'
            ];

            if (isset($dayMapping[$dayOfWeek])) {
                Flight::json([
                    'status' => 'closed',
                    'slots' => [],
                    'available' => [],
                    'message' => 'Dojo fermé le ' . $dayMapping[$dayOfWeek]
                ]);
                return;
            }

            $stmt = $db->prepare("
                SELECT 
                    r.heure_debut,
                    r.heure_fin,
                    g.nom_responsable as group_name,
                    g.discipline,
                    g.nombre as participants
                FROM reservation r
                JOIN club_groupe g ON r.id_club = g.id
                WHERE r.date_reserve = :date
                AND r.valeur = 'payee'
                ORDER BY r.heure_debut
            ");

            $stmt->execute([':date' => $date]);
            $slots = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $availability = $this->model->getDayAvailability($date);

            $dayData = [
                'status' => $this->getDayStatus($slots, $availability),
                'slots' => array_map(function($slot) {
                    return [
                        'time' => substr($slot['heure_debut'], 0, 5) . ' - ' . substr($slot['heure_fin'], 0, 5),
                        'group' => $slot['group_name'],
                        'discipline' => $slot['discipline'],
                        'participants' => (int)$slot['participants']
                    ];
                }, $slots),
                'available' => array_map(function($slot) {
                    return substr($slot['start'], 0, 5) . ' - ' . substr($slot['end'], 0, 5);
                }, $availability['available']),
                'opening_hours' => $availability['opening_hours'] ?? null
            ];

            Flight::json($dayData);
        } catch (\Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    private function formatScheduleForCalendar($scheduleData) {
        $formatted = [];

        foreach ($scheduleData as $reservation) {
            $date = $reservation['date_reserve'];

            if (!isset($formatted[$date])) {
                $formatted[$date] = [
                    'status' => 'partial',
                    'slots' => [],
                    'available' => []
                ];
            }

            $formatted[$date]['slots'][] = [
                'time' => $reservation['heure_debut'] . ' - ' . $reservation['heure_fin'],
                'group' => $reservation['group_name'],
                'discipline' => $reservation['discipline'],
                'participants' => (int)$reservation['participants']
            ];
        }

        // Déterminer le statut de chaque jour et les créneaux disponibles
        foreach ($formatted as $date => &$dayData) {
            $availability = $this->model->getDayAvailability($date);
            $dayData['available'] = $availability['available'];
            $dayData['status'] = $this->getDayStatus($dayData['slots'], $availability);
        }

        return $formatted;
    }
    public function obtenirPlanningMensuel($year = null, $month = null): array
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');

        // Get the first and last day of the month
        $firstDay = date('Y-m-01', mktime(0, 0, 0, $month, 1, $year));
        $lastDay = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));

        $reservationModel = new \app\models\GroupeModels\ReservationModel();
        $horaires = $this->obtenirHorairesOuverture();

        $planning = [];

        // Loop through each day of the month
        $currentDate = $firstDay;
        while ($currentDate <= $lastDay) {
            $dayOfWeek = strtolower(date('l', strtotime($currentDate)));
            $dayOfWeekFr = $this->jourDeSemaine($currentDate);

            // Check if we have opening hours for this day
            if (isset($horaires[$dayOfWeekFr])) {
                // Get reservations for this day
                $reservations = $reservationModel->getByDate($currentDate);

                // Calculate available slots
                $creneauxLibres = $this->calculerCreneauxLibres(
                    $horaires[$dayOfWeekFr],
                    $reservations
                );

                // Determine day status
                $status = 'day-free'; // Default: completely free
                if (!empty($reservations)) {
                    if (empty($creneauxLibres)) {
                        $status = 'day-full'; // Completely booked
                    } else {
                        $status = 'day-partial'; // Partially booked
                    }
                }

                $planning[$currentDate] = [
                    'status' => $status,
                    'reservations' => $reservations,
                    'creneaux_libres' => $creneauxLibres,
                    'horaires' => $horaires[$dayOfWeekFr]
                ];
            } else {
                // No opening hours for this day (closed)
                $planning[$currentDate] = [
                    'status' => 'closed',
                    'reservations' => [],
                    'creneaux_libres' => [],
                    'horaires' => null
                ];
            }

            // Move to next day
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return $planning;
    }

    private function obtenirHorairesOuverture(): array
    {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT jour, debut, fin FROM horaire WHERE debut IS NOT NULL AND fin IS NOT NULL");
            $horaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $planning = [];
            foreach ($horaires as $horaire) {
                $planning[$horaire['jour']] = [
                    'debut' => $horaire['debut'],
                    'fin' => $horaire['fin']
                ];
            }

            // Default hours if no data in database
            if (empty($planning)) {
                $defaultHours = ['08:00', '18:00'];
                $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

                foreach ($days as $day) {
                    $planning[$day] = [
                        'debut' => $defaultHours[0],
                        'fin' => $defaultHours[1]
                    ];
                }
            }

            return $planning;
        } catch (Exception $e) {
            error_log("Error getting opening hours: " . $e->getMessage());
            return [];
        }
    }

    private function getDayStatus($slots, $availability) {
        if (empty($slots)) {
            return 'day-free';  // Jour complètement libre
        }

        if (empty($availability['available'])) {
            return 'day-full';  // Jour complètement occupé
        }

        return 'day-partial';  // Jour partiellement occupé
    }

    // API pour les statistiques du mois
    public function getMonthlyData($year, $month) {
        try {
            $scheduleData = $this->model->getScheduleData($year, $month);
            $monthlyStats = $this->model->getMonthlyStats($year, $month);
            $formattedSchedule = $this->formatScheduleForCalendar($scheduleData);

            Flight::json([
                'schedule' => $formattedSchedule,
                'stats' => $monthlyStats
            ]);
        } catch (\Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
    // API pour récupérer tous les groupes en JSON
    public function getAllGroupesAPI() {
        try {
            $groupes = $this->model->getAll();
            Flight::json(['success' => true, 'data' => $groupes]);
        } catch (\Exception $e) {
            Flight::json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function insertGroupeAPI() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                Flight::json(['success' => false, 'error' => 'Données invalides'], 400);
                return;
            }

            $result = $this->model->insert(
                $data['nom_responsable'] ?? '',
                $data['contact'] ?? '',
                $data['nombre'] ?? 0,
                $data['discipline'] ?? ''
            );

            Flight::json(['success' => true, 'message' => $result]);
        } catch (\Exception $e) {
            Flight::json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // API pour supprimer un groupe
    public function deleteGroupeAPI($id) {
        try {
            $result = $this->model->delete($id);
            Flight::json(['success' => true, 'message' => $result]);
        } catch (\Exception $e) {
            Flight::json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}