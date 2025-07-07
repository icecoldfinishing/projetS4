<?php
namespace app\models\paiement;
use DateTime;
use Flight;
use PDO;
use Exception;
class PaiementModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    /**
     * Récupérer toutes les réservations avec leurs informations de paiement
     */
    public function getAllReservationsWithPaiement() {
        $query = "
            SELECT 
                r.id_reservation,
                r.date_reserve,
                r.heure_debut,
                r.heure_fin,
                r.valeur as statut_reservation,
                cg.nom_responsable as club_nom,
                cg.contact as club_contact,
                cg.discipline,
                p.montant as montant_paye,
                p.date_paiement,
                CASE 
                    WHEN p.id_payement IS NOT NULL THEN true 
                    ELSE false 
                END as est_paye,
                tc.montant_par_heure
            FROM reservation r
            LEFT JOIN club_groupe cg ON r.id_club = cg.id
            LEFT JOIN paiement p ON r.id_reservation = p.id_reservation
            LEFT JOIN tarif_club tc ON 1=1
            ORDER BY r.date_reserve DESC, r.heure_debut
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer une réservation spécifique
     */
    public function getReservationById($id_reservation) {
        $query = "
            SELECT 
                r.*,
                cg.nom_responsable as club_nom,
                cg.contact as club_contact,
                cg.discipline,
                p.montant as montant_paye,
                p.date_paiement
            FROM reservation r
            LEFT JOIN club_groupe cg ON r.id_club = cg.id
            LEFT JOIN paiement p ON r.id_reservation = p.id_reservation
            WHERE r.id_reservation = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_reservation]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Enregistrer un paiement
     */
    public function enregistrerPaiement($id_reservation, $montant, $date_paiement = null) {
        try {
            $this->db->beginTransaction();

            // Vérifier si un paiement existe déjà
            $existingPayment = $this->getPaiementByReservation($id_reservation);

            if ($existingPayment) {
                // Mettre à jour le paiement existant
                $query = "UPDATE paiement SET montant = ?, date_paiement = ? WHERE id_reservation = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    $montant,
                    $date_paiement ?: date('Y-m-d H:i:s'),
                    $id_reservation
                ]);
            } else {
                // Créer un nouveau paiement
                $query = "INSERT INTO paiement (id_reservation, montant, date_paiement) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    $id_reservation,
                    $montant,
                    $date_paiement ?: date('Y-m-d H:i:s')
                ]);
            }

            // Mettre à jour le statut de la réservation
            $updateReservation = "UPDATE reservation SET valeur = 'payee' WHERE id_reservation = ?";
            $stmt = $this->db->prepare($updateReservation);
            $stmt->execute([$id_reservation]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    /**
     * Récupérer un paiement par réservation
     */
    public function getPaiementByReservation($id_reservation) {
        $query = "SELECT * FROM paiement WHERE id_reservation = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_reservation]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Calculer le montant d'une réservation
     */
    public function calculerMontantReservation($id_reservation) {
        $reservation = $this->getReservationById($id_reservation);

        if (!$reservation) {
            return 0;
        }

        // Calculer la durée en heures
        $debut = new DateTime($reservation['heure_debut']);
        $fin = new DateTime($reservation['heure_fin']);
        $duree = $debut->diff($fin)->h + ($debut->diff($fin)->i / 60);

        // Récupérer le tarif par heure
        $query = "SELECT montant_par_heure FROM tarif_club LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $tarif = $stmt->fetch(PDO::FETCH_ASSOC);

        $tarifParHeure = $tarif ? $tarif['montant_par_heure'] : 50000; // Tarif par défaut

        return $duree * $tarifParHeure;
    }

    /**
     * Supprimer un paiement
     */
    public function supprimerPaiement($id_reservation) {
        try {
            $this->db->beginTransaction();

            // Supprimer le paiement
            $query = "DELETE FROM paiement WHERE id_reservation = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_reservation]);

            // Remettre le statut de la réservation à 'confirme'
            $updateReservation = "UPDATE reservation SET valeur = 'confirme' WHERE id_reservation = ?";
            $stmt = $this->db->prepare($updateReservation);
            $stmt->execute([$id_reservation]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}