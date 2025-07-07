<?php
require_once __DIR__ . '/../../../ws/db.php';

class Pret {

    // Récupère tous les prêts
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un prêt par son ID
    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crée un nouveau prêt
    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO pret (id_user, id_statut, valeur, dateDebut, duree, id_typePret, commentaire)
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

    // Met à jour un prêt existant
    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("
            UPDATE pret 
            SET id_user = ?, id_statut = ?, valeur = ?, dateDebut = ?, duree = ?, id_typePret = ?, commentaire = ?
            WHERE id = ?
        ");
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

    // Supprime un prêt
    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM pret WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function getPretsNonStatut() {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pret WHERE id_statut = ?");
        $stmt->execute([1]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getPretsAccepte($id_user) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pret WHERE id_statut = ? AND id_user = ?");
        $stmt->execute([2, $id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function updateStatut($id, $nouveauStatut) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE pret SET id_statut = ? WHERE id = ?");
        $stmt->execute([$nouveauStatut, $id]);
    }

}
