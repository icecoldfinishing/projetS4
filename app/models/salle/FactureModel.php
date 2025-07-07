<?php
namespace app\models\salle;
use PDO;

class FactureModel {
    private $db;
    private $table = 'facture_materiel';

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function findBySuivi($id_suivi) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_suivi_salle = :id");
        $stmt->execute([':id' => $id_suivi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (id_suivi_salle, destinataire, montant)
            VALUES (:id_suivi_salle, :destinataire, :montant)
        ");
        return $stmt->execute([
            ':id_suivi_salle' => $data['id_suivi_salle'],
            ':destinataire' => $data['destinataire'],
            ':montant' => $data['montant']
        ]);
    }
    public function getAll() {
        $stmt = $this->db->query("SELECT f.*, s.id_item, mi.num_serie, mt.label, s.description
                              FROM facture_materiel f
                              JOIN suivi_salle s ON f.id_suivi_salle = s.id_suivi_salle
                              JOIN materiel_item mi ON s.id_item = mi.id_item
                              JOIN materiel_type mt ON mi.id_type = mt.id_type
                              ORDER BY f.date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function validerPaiement($id_facture) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET est_paye = TRUE WHERE id_facture = :id");
        return $stmt->execute([':id' => $id_facture]);
    }

}
