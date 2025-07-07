<?php
namespace app\models\individu;

use PDO;
use Flight;

class SuperviseurModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function getAll() {
        $sql = "SELECT s.id_superviseur as id, p.nom, p.prenom, p.date_naissance, 
                       p.adresse, p.contact, p.id_genre, 
                       COALESCE(e.activite, 'actif') as actif
                FROM superviseur s
                JOIN personnel p ON s.id_superviseur = p.id_personnel
                LEFT JOIN employe e ON e.type_employe = 'superviseur' AND e.id_personnel = s.id_superviseur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        // Convert enum to boolean for frontend compatibility
        foreach ($result as &$row) {
            $row['actif'] = $row['actif'] === 'actif';
        }

        return $result;
    }

    public function getById($id) {
        $sql = "SELECT s.id_superviseur, p.*, COALESCE(e.activite, 'actif') as actif
                FROM superviseur s
                JOIN personnel p ON s.id_superviseur = p.id_personnel
                LEFT JOIN employe e ON e.type_employe = 'superviseur' AND e.id_personnel = s.id_superviseur
                WHERE s.id_superviseur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result) {
            $result['actif'] = $result['actif'] === 'actif';
        }

        return $result;
    }

    public function insert($nom, $prenom, $date_naissance, $adresse, $contact, $id_genre) {
        try {
            $this->db->beginTransaction();

            $sqlPersonnel = "INSERT INTO personnel (nom, prenom, date_naissance, adresse, contact, id_genre, type_personnel) 
                            VALUES (?, ?, ?, ?, ?, ?, 'superviseur') RETURNING id_personnel";
            $stmtPersonnel = $this->db->prepare($sqlPersonnel);
            $stmtPersonnel->execute([$nom, $prenom, $date_naissance, $adresse, $contact, $id_genre]);
            $personnelId = $stmtPersonnel->fetchColumn();

            $sqlSuperviseur = "INSERT INTO superviseur (id_superviseur) VALUES (?)";
            $stmtSuperviseur = $this->db->prepare($sqlSuperviseur);
            $stmtSuperviseur->execute([$personnelId]);

            $sqlEmploye = "INSERT INTO employe (type_employe, id_personnel, activite) 
                           VALUES ('superviseur', ?, 'actif')";
            $stmtEmploye = $this->db->prepare($sqlEmploye);
            $stmtEmploye->execute([$personnelId]);

            $this->db->commit();
            return "Superviseur ajouté avec succès";
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function update($id, $nom, $prenom, $date_naissance, $adresse, $contact, $id_genre, $actif = null) {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE personnel SET nom = ?, prenom = ?, date_naissance = ?, adresse = ?, contact = ?, id_genre = ? 
                    WHERE id_personnel = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$nom, $prenom, $date_naissance, $adresse, $contact, $id_genre, $id]);

            $normalizedActif = $this->normalizeActifValue($actif);

            if ($normalizedActif !== null) {
                $this->updateEmployeStatus($id, 'superviseur', $normalizedActif);
            }

            $this->db->commit();
            return "Superviseur modifié avec succès";
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    private function normalizeActifValue($actif) {
        if ($actif === null || $actif === '') {
            return null;
        }

        if (is_string($actif)) {
            $actif = trim($actif);
            if ($actif === '') {
                return null;
            }
            if ($actif === '1' || strtolower($actif) === 'true') {
                return 'actif';
            }
            if ($actif === '0' || strtolower($actif) === 'false') {
                return 'inactif';
            }
            if (in_array($actif, ['actif', 'inactif'])) {
                return $actif;
            }
        }

        if (is_bool($actif)) {
            return $actif ? 'actif' : 'inactif';
        }

        if (is_numeric($actif)) {
            return (bool)$actif ? 'actif' : 'inactif';
        }

        return null;
    }

    private function updateEmployeStatus($id, $type, $actif) {
        $normalizedActif = $this->normalizeActifValue($actif);

        $checkSql = "SELECT id_employe FROM employe WHERE type_employe = ? AND id_personnel = ?";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([$type, $id]);
        $employeExists = $checkStmt->fetchColumn();

        if ($employeExists) {
            if ($normalizedActif === 'actif') {
                $sql = "UPDATE employe SET activite = ?, date_fin = NULL 
                        WHERE type_employe = ? AND id_personnel = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(['actif', $type, $id]);
            } else {
                $sql = "UPDATE employe SET activite = ?, date_fin = NOW() 
                        WHERE type_employe = ? AND id_personnel = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(['inactif', $type, $id]);
            }
        } else {
            $sql = "INSERT INTO employe (type_employe, id_personnel, activite) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$type, $id, $normalizedActif]);
        }
    }

    public function delete($id) {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE employe SET activite = 'inactif', date_fin = NOW() 
                    WHERE type_employe = 'superviseur' AND id_personnel = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            $this->db->commit();
            return "Superviseur désactivé avec succès";
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}