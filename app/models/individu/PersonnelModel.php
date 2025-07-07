<?php
namespace app\models\individu;

use PDO;
use Flight;
use Exception;

class PersonnelModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function getByType($type) {
        if ($type === 'prof') {
            $sql = "SELECT p.id_personnel as id, p.nom, p.prenom, p.date_naissance, 
                          p.adresse, p.contact, p.id_genre, 
                          COALESCE(e.activite, 'actif') as actif
                   FROM personnel p
                   INNER JOIN prof pr ON pr.id_prof = p.id_personnel
                   LEFT JOIN employe e ON e.id_personnel = p.id_personnel AND e.type_employe = 'prof'
                   ORDER BY p.nom, p.prenom";
        } elseif ($type === 'superviseur') {
            $sql = "SELECT p.id_personnel as id, p.nom, p.prenom, p.date_naissance, 
                          p.adresse, p.contact, p.id_genre, 
                          COALESCE(e.activite, 'actif') as actif
                   FROM personnel p
                   INNER JOIN superviseur s ON s.id_superviseur = p.id_personnel
                   LEFT JOIN employe e ON e.id_personnel = p.id_personnel AND e.type_employe = 'superviseur'
                   ORDER BY p.nom, p.prenom";
        } else {
            return [];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert enum to boolean for frontend compatibility
        foreach ($result as &$row) {
            $row['actif'] = $row['actif'] === 'actif';
        }

        return $result;
    }

    public function getById($id) {
        $checkSql = "SELECT p.*, 
                           CASE 
                               WHEN pr.id_prof IS NOT NULL THEN 'prof'
                               WHEN s.id_superviseur IS NOT NULL THEN 'superviseur'
                               ELSE NULL
                           END as type,
                           COALESCE(e.activite, 'actif') as actif
                    FROM personnel p
                    LEFT JOIN prof pr ON pr.id_prof = p.id_personnel
                    LEFT JOIN superviseur s ON s.id_superviseur = p.id_personnel
                    LEFT JOIN employe e ON e.id_personnel = p.id_personnel
                    WHERE p.id_personnel = ?";

        $stmt = $this->db->prepare($checkSql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $result['id'] = $result['id_personnel'];
            $result['actif'] = $result['actif'] === 'actif';
        }

        return $result;
    }

    public function insert($nom, $prenom, $date_naissance, $adresse, $contact, $id_genre, $type) {
        try {
            $this->db->beginTransaction();

            $sqlPersonnel = "INSERT INTO personnel (nom, prenom, date_naissance, adresse, contact, id_genre, type_personnel) 
                           VALUES (?, ?, ?, ?, ?, ?, ?) RETURNING id_personnel";
            $stmtPersonnel = $this->db->prepare($sqlPersonnel);
            $stmtPersonnel->execute([$nom, $prenom, $date_naissance, $adresse, $contact, $id_genre, $type]);
            $personnelId = $stmtPersonnel->fetchColumn();

            if ($type === 'prof') {
                $sqlSpecific = "INSERT INTO prof (id_prof) VALUES (?)";
            } else {
                $sqlSpecific = "INSERT INTO superviseur (id_superviseur) VALUES (?)";
            }
            $stmtSpecific = $this->db->prepare($sqlSpecific);
            $stmtSpecific->execute([$personnelId]);

            $sqlEmploye = "INSERT INTO employe (id_personnel, type_employe, activite) VALUES (?, ?, ?)";
            $stmtEmploye = $this->db->prepare($sqlEmploye);
            $stmtEmploye->execute([$personnelId, $type, 'actif']);

            $this->db->commit();
            return "Personnel ajouté avec succès";
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function update($id, $nom, $prenom, $date_naissance, $adresse, $contact, $id_genre, $actif = null) {
        try {
            $this->db->beginTransaction();

            $sqlPersonnel = "UPDATE personnel SET nom = ?, prenom = ?, date_naissance = ?, 
                           adresse = ?, contact = ?, id_genre = ? 
                           WHERE id_personnel = ?";
            $stmtPersonnel = $this->db->prepare($sqlPersonnel);
            $stmtPersonnel->execute([$nom, $prenom, $date_naissance, $adresse, $contact, $id_genre, $id]);

            $normalizedActif = $this->normalizeActifValue($actif);

            if ($normalizedActif !== null) {
                $this->updateEmployeStatus($id, $normalizedActif);
            }

            $this->db->commit();
            return "Personnel modifié avec succès";
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

    private function updateEmployeStatus($id, $actif) {
        if (!in_array($actif, ['actif', 'inactif'])) {
            return;
        }

        $checkSql = "SELECT id_employe FROM employe WHERE id_personnel = ?";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([$id]);
        $employeExists = $checkStmt->fetchColumn();

        if ($employeExists) {
            $sql = "UPDATE employe SET activite = ?, date_fin = CASE WHEN ? = 'actif' THEN NULL ELSE NOW() END 
                   WHERE id_personnel = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$actif, $actif, $id]);
        } else {
            $personnel = $this->getById($id);
            if ($personnel && $personnel['type']) {
                $sql = "INSERT INTO employe (id_personnel, type_employe, activite) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id, $personnel['type'], $actif]);
            }
        }
    }

    public function delete($id) {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE employe SET activite = 'inactif', date_fin = NOW() 
                   WHERE id_personnel = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            $this->db->commit();
            return "Personnel désactivé avec succès";
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}