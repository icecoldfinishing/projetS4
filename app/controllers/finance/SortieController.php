<?php
namespace app\controllers\finance;

use app\models\finance\SortieModel;
use Flight;

class SortieController {

    public function getMotifs() {
        try {
            $query = "SELECT id_motif, libelle, categorie FROM motif_sortie WHERE actif = TRUE ORDER BY categorie, libelle";
            $stmt = Flight::db()->prepare($query);
            $stmt->execute();
            $motifs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            Flight::json([
                'success' => true,
                'motifs' => $motifs
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors du chargement des motifs: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getStatuts() {
        try {
            $query = "SELECT id_statut, libelle, couleur FROM statut_sortie WHERE actif = TRUE ORDER BY id_statut";
            $stmt = Flight::db()->prepare($query);
            $stmt->execute();
            $statuts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            Flight::json([
                'success' => true,
                'statuts' => $statuts
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors du chargement des statuts: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCategories() {
        try {
            // Récupérer les catégories depuis l'ENUM
            $query = "SELECT unnest(enum_range(NULL::categorie_depense)) as categorie";
            $stmt = Flight::db()->prepare($query);
            $stmt->execute();
            $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            Flight::json([
                'success' => true,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors du chargement des catégories: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getModePaiements() {
        try {
            // Récupérer les modes de paiement depuis l'ENUM
            $query = "SELECT unnest(enum_range(NULL::mode_paiement)) as mode_paiement";
            $stmt = Flight::db()->prepare($query);
            $stmt->execute();
            $modes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            Flight::json([
                'success' => true,
                'modes_paiement' => $modes
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors du chargement des modes de paiement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSorties() {
        try {
            $page = Flight::request()->query['page'] ?? 1;
            $limit = Flight::request()->query['limit'] ?? 10;
            $offset = ($page - 1) * $limit;

            $where = "WHERE 1=1";
            $params = [];

            if (!empty(Flight::request()->query['categorie'])) {
                $where .= " AND sd.categorie = ?";
                $params[] = Flight::request()->query['categorie'];
            }

            if (!empty(Flight::request()->query['statut'])) {
                $where .= " AND sd.id_statut = ?";
                $params[] = Flight::request()->query['statut'];
            }

            $query = "
                SELECT sd.*, ms.libelle as motif, ss.libelle as statut, ss.couleur 
                FROM suivi_depense sd
                LEFT JOIN motif_sortie ms ON sd.id_motif = ms.id_motif
                LEFT JOIN statut_sortie ss ON sd.id_statut = ss.id_statut
                $where
                ORDER BY sd.date_demande DESC
                LIMIT ? OFFSET ?
            ";

            $params[] = $limit;
            $params[] = $offset;

            $stmt = Flight::db()->prepare($query);
            $stmt->execute($params);
            $sorties = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Count total
            $countQuery = "SELECT COUNT(*) as total FROM suivi_depense sd $where";
            $countParams = array_slice($params, 0, -2); // Remove limit and offset
            $countStmt = Flight::db()->prepare($countQuery);
            $countStmt->execute($countParams);
            $total = $countStmt->fetch(\PDO::FETCH_ASSOC)['total'];

            Flight::json([
                'success' => true,
                'sorties' => $sorties,
                'pagination' => [
                    'current_page' => (int)$page,
                    'total_pages' => ceil($total / $limit),
                    'total_items' => (int)$total
                ]
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors du chargement des sorties: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getStatistiques() {
        try {
            $query = "
                SELECT
                    COALESCE(SUM(montant), 0) as total_depenses,
                    COUNT(CASE WHEN id_statut = 1 THEN 1 END) as en_attente,
                    COUNT(CASE WHEN id_statut = 2 THEN 1 END) as valide,
                    COUNT(CASE WHEN id_statut = 3 THEN 1 END) as refuse
                FROM suivi_depense
                WHERE EXTRACT(MONTH FROM date_demande) = EXTRACT(MONTH FROM CURRENT_DATE)
                AND EXTRACT(YEAR FROM date_demande) = EXTRACT(YEAR FROM CURRENT_DATE)
            ";

            $stmt = Flight::db()->prepare($query);
            $stmt->execute();
            $stats = $stmt->fetch(\PDO::FETCH_ASSOC);

            Flight::json([
                'success' => true,
                'total_depenses' => $stats['total_depenses'],
                'en_attente_count' => $stats['en_attente'],
                'valide_count' => $stats['valide'],
                'refuse_count' => $stats['refuse']
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors du chargement des statistiques: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createSortie() {
        try {
            $data = Flight::request()->data;

            // Créer d'abord le motif s'il n'existe pas
            $motifId = $this->getOrCreateMotif($data->motif_libelle, $data->categorie);

            $query = "
                INSERT INTO suivi_depense (id_motif, montant, mode_paiement, description, categorie, id_statut)
                VALUES (?, ?, ?, ?, ?, 1)
            ";

            $stmt = Flight::db()->prepare($query);
            $stmt->execute([
                $motifId,
                $data->montant,
                $data->mode_paiement,
                $data->description,
                $data->categorie
            ]);

            Flight::json([
                'success' => true,
                'message' => 'Dépense enregistrée avec succès'
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement: ' . $e->getMessage()
            ], 500);
        }
    }
    private function getOrCreateMotif($libelle, $categorie) {
        // Vérifier si le motif existe déjà
        $query = "SELECT id_motif FROM motif_sortie WHERE libelle = ? AND categorie = ?";
        $stmt = Flight::db()->prepare($query);
        $stmt->execute([$libelle, $categorie]);
        $motif = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($motif) {
            return $motif['id_motif'];
        }

        // Créer le nouveau motif
        $query = "INSERT INTO motif_sortie (libelle, categorie) VALUES (?, ?) RETURNING id_motif";
        $stmt = Flight::db()->prepare($query);
        $stmt->execute([$libelle, $categorie]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result['id_motif'];
    }
    public function getSortieDetails($id) {
        try {
            $query = "
                SELECT 
                    sd.*,
                    ms.libelle as motif,
                    ss.libelle as statut,
                    ss.couleur,
                    a_demandeur.nom as demandeur,
                    a_validateur.nom as validateur
                FROM suivi_depense sd
                LEFT JOIN motif_sortie ms ON sd.id_motif = ms.id_motif
                LEFT JOIN statut_sortie ss ON sd.id_statut = ss.id_statut
                LEFT JOIN admin a_demandeur ON sd.id_demandeur = a_demandeur.id_admin
                LEFT JOIN admin a_validateur ON sd.id_admin_validateur = a_validateur.id_admin
                WHERE sd.id_depense = ?
            ";

            $stmt = Flight::db()->prepare($query);
            $stmt->execute([$id]);
            $sortie = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$sortie) {
                Flight::json([
                    'success' => false,
                    'message' => 'Dépense non trouvée'
                ], 404);
                return;
            }

            Flight::json([
                'success' => true,
                'sortie' => $sortie
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors du chargement des détails: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateStatut($id) {
        try {
            $data = Flight::request()->data;

            if (!isset($data->statut)) {
                Flight::json([
                    'success' => false,
                    'message' => 'Statut requis'
                ], 400);
                return;
            }

            // Get current admin ID from session
            $idAdmin = $_SESSION['admin']['id_admin'] ?? null;

            if (!$idAdmin) {
                Flight::json([
                    'success' => false,
                    'message' => 'Administrateur non identifié'
                ], 401);
                return;
            }

            $query = "
                UPDATE suivi_depense 
                SET id_statut = ?, 
                    id_admin_validateur = ?,
                    date_validation = CURRENT_TIMESTAMP
                WHERE id_depense = ?
            ";

            $stmt = Flight::db()->prepare($query);
            $result = $stmt->execute([
                $data->statut,
                $idAdmin,
                $id
            ]);

            if ($result) {
                // Log the status change in history table if it exists
                $historyQuery = "
                    INSERT INTO historique_statut_sortie 
                    (id_depense, id_statut, id_admin, commentaire, date_changement)
                    VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
                ";

                $historyStmt = Flight::db()->prepare($historyQuery);
                $historyStmt->execute([
                    $id,
                    $data->statut,
                    $idAdmin,
                    $data->commentaire ?? null
                ]);

                Flight::json([
                    'success' => true,
                    'message' => 'Statut mis à jour avec succès'
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour du statut'
                ], 500);
            }

        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut: ' . $e->getMessage()
            ], 500);
        }
    }
}