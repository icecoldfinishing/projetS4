<?php

 namespace app\models\paiement;

 use Flight;
 use PDO;
 use Exception;

 class SalaireModel {
     private $db;

     public function __construct() {
         $this->db = Flight::db();
     }

     public function getAllEmployes() {
         $query = "
        SELECT
            e.id_employe,
            p.nom,
            p.prenom,
            p.contact,
            e.type_employe,
            e.date_embauche,
            s.montant_mensuel,
            MAX(ss.date_paiement) as dernier_paiement
        FROM employe e
        JOIN personnel p ON e.id_personnel = p.id_personnel
        LEFT JOIN salaire s ON e.type_employe = s.type_employe AND s.actif = true
        LEFT JOIN suivi_salaire ss ON e.id_employe = ss.id_employe
        WHERE e.activite = 'actif'::activite
        GROUP BY e.id_employe, p.nom, p.prenom, p.contact, e.type_employe, e.date_embauche, s.montant_mensuel
        ORDER BY p.nom, p.prenom
    ";

         $stmt = $this->db->prepare($query);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getEmployeById($id_employe) {
         $query = "
        SELECT
            e.id_employe,
            p.nom,
            p.prenom,
            p.contact,
            e.type_employe,
            e.date_embauche,
            s.montant_mensuel,
            MAX(ss.date_paiement) as dernier_paiement
        FROM employe e
        JOIN personnel p ON e.id_personnel = p.id_personnel
        LEFT JOIN salaire s ON e.type_employe = s.type_employe AND s.actif = true
        LEFT JOIN suivi_salaire ss ON e.id_employe = ss.id_employe
        WHERE e.id_employe = ? AND e.activite = 'actif'::activite
        GROUP BY e.id_employe, p.nom, p.prenom, p.contact, e.type_employe, e.date_embauche, s.montant_mensuel
    ";

         $stmt = $this->db->prepare($query);
         $stmt->execute([$id_employe]);
         return $stmt->fetch(PDO::FETCH_ASSOC);
     }
     public function getHistoriquePaiements($id_employe) {
         $query = "
             SELECT 
                 date_paiement,
                 montant,
                 mois_a_payer,
                 annee_a_payer,
                 mode_paiement,
                 remarques
             FROM suivi_salaire
             WHERE id_employe = ?
             ORDER BY annee_a_payer DESC, mois_a_payer DESC, date_paiement DESC
         ";

         $stmt = $this->db->prepare($query);
         $stmt->execute([$id_employe]);
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getAllSalairesConfig() {
         $query = "
             SELECT type_employe, montant_mensuel, date_changement
             FROM salaire
             WHERE actif = true
             ORDER BY type_employe
         ";

         $stmt = $this->db->prepare($query);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function modifierSalaireParType($type_employe, $nouveau_montant) {
         try {
             $this->db->beginTransaction();

             // Désactiver l'ancien salaire
             $query1 = "UPDATE salaire SET actif = false WHERE type_employe = ? AND actif = true";
             $stmt1 = $this->db->prepare($query1);
             $stmt1->execute([$type_employe]);

             // Insérer le nouveau salaire
             $query2 = "INSERT INTO salaire (type_employe, montant_mensuel) VALUES (?, ?)";
             $stmt2 = $this->db->prepare($query2);
             $stmt2->execute([$type_employe, $nouveau_montant]);

             $this->db->commit();
             return true;
         } catch (Exception $e) {
             $this->db->rollBack();
             throw $e;
         }
     }

     public function payerSalaire($id_employe, $mois, $annee, $mode_paiement = 'espece', $remarques = null) {
         try {
             // Vérifier si déjà payé
             if ($this->salaireDejaPayePour($id_employe, $mois, $annee)) {
                 throw new Exception("Le salaire pour ce mois a déjà été payé");
             }

             // Récupérer le montant du salaire
             $employe = $this->getEmployeById($id_employe);
             if (!$employe) {
                 throw new Exception("Employé non trouvé");
             }

             $montant = $employe['montant_mensuel'];
             if (!$montant || $montant <= 0) {
                 throw new Exception("Montant de salaire non configuré pour ce type d'employé");
             }

             // Insérer le paiement
             $query = "
                 INSERT INTO suivi_salaire (id_employe, montant, mois_a_payer, annee_a_payer, mode_paiement, remarques)
                 VALUES (?, ?, ?, ?, ?, ?)
             ";

             $stmt = $this->db->prepare($query);
             return $stmt->execute([$id_employe, $montant, $mois, $annee, $mode_paiement, $remarques]);

         } catch (Exception $e) {
             throw $e;
         }
     }

     public function salaireDejaPayePour($id_employe, $mois, $annee) {
         $query = "
             SELECT COUNT(*) as count
             FROM suivi_salaire
             WHERE id_employe = ? AND mois_a_payer = ? AND annee_a_payer = ?
         ";

         $stmt = $this->db->prepare($query);
         $stmt->execute([$id_employe, $mois, $annee]);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         return $result['count'] > 0;
     }
 }