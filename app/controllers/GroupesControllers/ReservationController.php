<?php

namespace app\controllers\GroupesControllers;

use app\models\GroupeModels\ReservationModel;
use app\models\GroupeModels\StatusModel;
use app\models\GroupeModels\GroupeModel;
use Flight;

class ReservationController {


    public static function  formReservation()
    {

        $groupeModel = new GroupeModel();
        $groupes = $groupeModel->getAll();
        $message = Flight::get('message') ?? '';

        Flight::render('gestion/GroupeViews/reservation_form', [
            'groupes'  => $groupes,
            'message'  => $message
        ]);
    }


    public function InsertReservation() {
        $id_club = Flight::request()->data->id_club;
        $date_reservation = Flight::request()->data->date_reservation;
        $date_reserve = Flight::request()->data->date_reserve;
        $heure_debut = Flight::request()->data->heure_debut;
        $heure_fin = Flight::request()->data->heure_fin;
        $valeur = Flight::request()->data->valeur ?? 'demande';

        $model = new ReservationModel();
        $idReservation = $model->insert($id_club, $date_reservation, $date_reserve, $heure_debut, $heure_fin);

        $statusModel = new StatusModel();
        $statusMsg   = $statusModel->insert($idReservation, $valeur);

        $groupeModel = new GroupeModel();
        $groupes = $groupeModel->getAll();


        Flight::render('gestion/GroupeViews/reservation_form', ['groupes'  => $groupes,'message' => $statusMsg]);
    }

    public function GetAllReservations() {
        $model = new ReservationModel();
        $statusModel = new StatusModel();
        $reservations = $model->getAll();
        $status= $statusModel->getAll();

        Flight::render('gestion/GroupeViews/reservation_list', ['reservations' => $reservations,'status'=> $status]);
    }

    public function GetReservationById($id) {
        $model = new ReservationModel();
        $reservation = $model->getById($id);
        $statusModel = new StatusModel();
        $status = $statusModel->getByIdReservation($id);

        Flight::render('gestion/GroupeViews/reservation_detail', ['reservation' => $reservation,'status'=> $status]);
    }

    public function UpdateReservation($id) {
        $id_club = Flight::request()->data->id_club;
        $date_reservation = Flight::request()->data->date_reservation;
        $date_reserve = Flight::request()->data->date_reserve;
        $heure_debut = Flight::request()->data->heure_debut;
        $heure_fin = Flight::request()->data->heure_fin;

        $model = new ReservationModel();
        $message = $model->update($id, $id_club, $date_reservation, $date_reserve, $heure_debut, $heure_fin);

        $reservation = $model->getById($id);
        Flight::render('gestion/GroupeViews/reservation_detail', ['reservation' => $reservation, 'message' => $message]);
    }

    public function DeleteReservation($id) {
        $model = new ReservationModel();
        $message = $model->delete($id);

        $reservations = $model->getAll();
        Flight::render('gestion/GroupeViews/reservation_list', ['reservations' => $reservations, 'message' => $message]);
    }

    public function UpdateStatusReservation()
    {
        $idReservation = (int) Flight::request()->data->id_reservation;
        $valeur        =       Flight::request()->data->valeur ?? 'demande';

        $statusModel = new StatusModel();
        $message     = $statusModel->updateByReservation($idReservation, $valeur);

        Flight::render('gestion/GroupeViews/reservation_list', ['message' => $message]);
    }

}
