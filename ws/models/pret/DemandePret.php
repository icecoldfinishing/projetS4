<?php
require_once __DIR__ . '/../../../ws/db.php';

class DemandePret {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM demandePret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère une demande par son ID
    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM demandePret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crée une nouvelle demande de prêt
    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO demandePret (id_user, id_statut, valeur, dateDebut, duree, id_typePret, commentaire)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data->id_user,
            $data->id_statut,
            $data->valeur,
            $data->dateDebut,
            $data->duree,
            $data->id_typePret,
            $data->commentaire
        ]);
    }

    // Met à jour une demande existante
    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE demandePret SET id_user = ?, id_statut = ?, valeur = ?, dateDebut = ?, duree = ?, id_typePret = ?, commentaire = ? WHERE id = ?");
        $stmt->execute([
            $data->id_user,
            $data->id_statut,
            $data->valeur,
            $data->dateDebut,
            $data->duree,
            $data->id_typePret,
            $data->commentaire ?? null,
            $id
        ]);
    }

    // Supprime une demande
    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM demandePret WHERE id = ?");
        $stmt->execute([$id]);
    }
}
