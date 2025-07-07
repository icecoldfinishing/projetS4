<?php
namespace app\controllers;
use app\models\paiement\PaiementModel;
use Flight;

class PaiementController {
    private $paiementModel;

    public function __construct() {
        $this->paiementModel = new PaiementModel();
    }

    /**
     * Afficher la page de gestion des paiements
     */
    public function index() {
        try {
            $reservations = $this->paiementModel->getAllReservationsWithPaiement();

            // Calculer les montants pour les réservations non payées
            foreach ($reservations as &$reservation) {
                if (!$reservation['montant_paye']) {
                    $reservation['montant_calcule'] = $this->paiementModel->calculerMontantReservation($reservation['id_reservation']);
                }
            }

            Flight::render('gestion/finance', [
                'reservations' => $reservations,
                'section' => 'paiement'
            ]);

        } catch (Exception $e) {
            Flight::json(['error' => 'Erreur lors du chargement des données: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Enregistrer un paiement
     */
    public function enregistrerPaiement() {
        try {
            $data = Flight::request()->data;

            // Validation des données
            if (empty($data->id_reservation) || empty($data->montant)) {
                Flight::json(['error' => 'Données manquantes'], 400);
                return;
            }

            $id_reservation = $data->id_reservation;
            $montant = floatval($data->montant);
            $date_paiement = $data->date_paiement ?: date('Y-m-d H:i:s');

            // Vérifier que la réservation existe
            $reservation = $this->paiementModel->getReservationById($id_reservation);
            if (!$reservation) {
                Flight::json(['error' => 'Réservation introuvable'], 404);
                return;
            }

            // Enregistrer le paiement
            $success = $this->paiementModel->enregistrerPaiement($id_reservation, $montant, $date_paiement);

            if ($success) {
                Flight::json(['success' => 'Paiement enregistré avec succès']);
            } else {
                Flight::json(['error' => 'Erreur lors de l\'enregistrement du paiement'], 500);
            }

        } catch (Exception $e) {
            Flight::json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Récupérer les détails d'une réservation
     */
    public function getReservationDetails($id_reservation) {
        try {
            $reservation = $this->paiementModel->getReservationById($id_reservation);

            if (!$reservation) {
                Flight::json(['error' => 'Réservation introuvable'], 404);
                return;
            }

            // Calculer le montant si pas encore payé
            if (!$reservation['montant_paye']) {
                $reservation['montant_calcule'] = $this->paiementModel->calculerMontantReservation($id_reservation);
            }

            Flight::json($reservation);

        } catch (Exception $e) {
            Flight::json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Supprimer un paiement
     */
    public function supprimerPaiement($id_reservation) {
        try {
            $success = $this->paiementModel->supprimerPaiement($id_reservation);

            if ($success) {
                Flight::json(['success' => 'Paiement supprimé avec succès']);
            } else {
                Flight::json(['error' => 'Erreur lors de la suppression du paiement'], 500);
            }

        } catch (Exception $e) {
            Flight::json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Récupérer toutes les réservations (pour AJAX)
     */
    public function getReservations() {
        try {
            $reservations = $this->paiementModel->getAllReservationsWithPaiement();

            // Calculer les montants pour les réservations non payées
            foreach ($reservations as &$reservation) {
                if (!$reservation['montant_paye']) {
                    $reservation['montant_calcule'] = $this->paiementModel->calculerMontantReservation($reservation['id_reservation']);
                }
            }

            Flight::json($reservations);

        } catch (Exception $e) {
            Flight::json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }
}