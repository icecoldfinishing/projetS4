<?php
namespace app\models\finance;
use PDO;

class SortieModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Récupérer toutes les sorties avec pagination et filtres
    public function getAllSorties($filters = [], $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $whereConditions = [];
        $params = [];

        // Construction des conditions WHERE
        if (!empty($filters['categorie'])) {
            $whereConditions[] = "sd.categorie = :categorie";
            $params[':categorie'] = $filters['categorie'];
        }

        if (!empty($filters['statut'])) {
            $whereConditions[] = "sd.id_statut = :statut";
            $params[':statut'] = $filters['statut'];
        }

        if (!empty($filters['search'])) {
            $whereConditions[] = "(ms.libelle ILIKE :search OR sd.beneficiaire ILIKE :search OR sd.description ILIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

        $query = "
            SELECT * FROM vue_toutes_sorties 
            {$whereClause}
            ORDER BY date_demande DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($query);

        // Bind des paramètres
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compter le total des sorties pour la pagination
    public function countSorties($filters = []) {
        $whereConditions = [];
        $params = [];

        if (!empty($filters['categorie'])) {
            $whereConditions[] = "sd.categorie = :categorie";
            $params[':categorie'] = $filters['categorie'];
        }

        if (!empty($filters['statut'])) {
            $whereConditions[] = "sd.id_statut = :statut";
            $params[':statut'] = $filters['statut'];
        }

        if (!empty($filters['search'])) {
            $whereConditions[] = "(ms.libelle ILIKE :search OR sd.beneficiaire ILIKE :search OR sd.description ILIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

        $query = "SELECT COUNT(*) FROM vue_toutes_sorties {$whereClause}";
        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Récupérer les statistiques
    public function getStatistiques() {
        $query = "
            SELECT 
                SUM(montant) as total_depenses,
                COUNT(CASE WHEN statut = 'EN ATTENTE' THEN 1 END) as en_attente_count,
                COUNT(CASE WHEN statut = 'VALIDE' THEN 1 END) as valide_count,
                COUNT(CASE WHEN statut = 'REFUSE' THEN 1 END) as refuse_count
            FROM vue_toutes_sorties
        ";

        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les motifs de sortie
    public function getMotifsSortie() {
        $query = "
            SELECT id_motif, libelle, categorie 
            FROM motif_sortie 
            WHERE actif = TRUE 
            ORDER BY categorie, libelle
        ";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Créer une nouvelle dépense
    // In SortieModel.php, update the creerDepense method
    public function creerDepense($data) {
        try {
            $this->db->beginTransaction();

            // Remove beneficiaire parameter since column was dropped
            $stmt = $this->db->prepare("SELECT enregistrer_sortie_generale(?, ?, ?, ?, ?) as id_depense");
            $stmt->execute([
                $data['id_motif'],
                $data['montant'],
                $data['mode_paiement'] ?? 'espece',
                $data['id_demandeur'] ?? null,
                $data['description'] ?? null
            ]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->db->commit();

            return $result['id_depense'];
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Changer le statut d'une sortie
    public function changerStatut($idDepense, $nouveauStatut, $idAdmin, $commentaire = null) {
        try {
            $stmt = $this->db->prepare("SELECT changer_statut_sortie(?, ?, ?, ?) as success");
            $stmt->execute([$idDepense, $nouveauStatut, $idAdmin, $commentaire]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['success'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Récupérer les détails d'une sortie
    public function getSortieDetails($idDepense) {
        $query = "
            SELECT 
                vts.*,
                hss.date_changement,
                hss.commentaire,
                a.nom as admin_nom
            FROM vue_toutes_sorties vts
            LEFT JOIN historique_statut_sortie hss ON vts.id_depense = hss.id_depense
            LEFT JOIN admin a ON hss.id_admin = a.id_admin
            WHERE vts.id_depense = ?
            ORDER BY hss.date_changement DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$idDepense]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les statuts disponibles
    public function getStatutsSortie() {
        $query = "SELECT id_statut, libelle, couleur FROM statut_sortie WHERE actif = TRUE ORDER BY id_statut";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}