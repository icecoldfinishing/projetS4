<?php
namespace app\models\salle;
use PDO;

class SuiviSalleModel {
    public $db;
    private $table = 'suivi_salle';

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function all() {
        $sql = "
            SELECT ss.*, 
               m.num_serie, 
               m.id_type, 
               s.nom AS superviseur_nom, 
               s.prenom AS superviseur_prenom,
               c.nom_responsable AS nom_club,
               f.id_facture AS facture

            FROM suivi_salle ss
            JOIN materiel_item m ON ss.id_item = m.id_item
            JOIN superviseur s ON ss.id_superviseur = s.id_superviseur
            LEFT JOIN facture_materiel f ON ss.id_suivi_salle = f.id_suivi_salle
            LEFT JOIN club_groupe c ON ss.id_club = c.id
            ORDER BY ss.date DESC
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
        INSERT INTO suivi_salle (id_superviseur, id_item, id_club, date, description, etat)
        VALUES (:id_superviseur, :id_item, :id_club, NOW(), :description, :etat)
    ");
        return $stmt->execute([
            ':id_superviseur' => $data['id_superviseur'],
            ':id_item' => $data['id_item'],
            ':id_club' => $data['id_club'],
            ':description' => $data['description'],
            ':etat' => $data['etat']
        ]);
    }


    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_suivi_salle = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function find($id_suivi)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_suivi_salle = :id");
        $stmt->execute([':id' => $id_suivi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
