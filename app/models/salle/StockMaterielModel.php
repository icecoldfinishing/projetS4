<?php
namespace app\models\salle;
use PDO;

class StockMaterielModel {
    private $db;
    private $table = 'stock_materiel';

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_suivi = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (id_type, type_mouvement, quantite, date)
            VALUES (:id_type, :type_mouvement, :quantite, NOW())
        ");
        return $stmt->execute([
            ':id_type' => $data['id_type'],
            ':type_mouvement' => $data['type_mouvement'],
            ':quantite' => $data['quantite']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_suivi = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getStockDisponible() {
        $sql = "
        SELECT 
            mt.id_type,
            mt.label,
            COALESCE(entree.total_entree, 0) - COALESCE(sortie.total_sortie, 0) AS stock_disponible
        FROM materiel_type mt
        LEFT JOIN (
            SELECT id_type, SUM(quantite) AS total_entree
            FROM stock_materiel
            WHERE type_mouvement = 'I'
            GROUP BY id_type
        ) AS entree ON mt.id_type = entree.id_type
        LEFT JOIN (
            SELECT id_type, SUM(quantite) AS total_sortie
            FROM stock_materiel
            WHERE type_mouvement = 'O'
            GROUP BY id_type
        ) AS sortie ON mt.id_type = sortie.id_type
        ORDER BY mt.label
    ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
