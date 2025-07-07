<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Présences - Dojo</title>
    <link href="<?= Flight::base() ?>/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .stats-card { border-left: 4px solid; }
        .stats-card.present { border-left-color: #28a745; }
        .stats-card.absent { border-left-color: #dc3545; }
        .stats-card.total { border-left-color: #007bff; }
        .quick-actions { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-clipboard-list"></i> Gestion des Présences</h1>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPresenceModal">
                            <i class="fas fa-plus"></i> Nouvelle présence
                        </button>
                        <button type="button" class="btn btn-success" onclick="exportData()">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="quick-actions">
                    <h4 class="mb-3"><i class="fas fa-bolt"></i> Actions rapides</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?= Flight::base() ?>/presence/seance/1" class="btn btn-outline-primary d-block">
                                <i class="fas fa-users"></i><br>
                                Feuille de présence
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-info d-block" onclick="showDateRangeModal('absents')">
                                <i class="fas fa-user-times"></i><br>
                                Voir les absents
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success d-block" onclick="showDateRangeModal('presents')">
                                <i class="fas fa-user-check"></i><br>
                                Voir les présents
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-warning d-block" onclick="generateReport()">
                                <i class="fas fa-chart-line"></i><br>
                                Générer rapport
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <?php 
                $total = count($presences);
                $presents = is_array($presences) ? array_filter($presences, function($p) { return isset($p['present']) && $p['present']; }) : [];
                $absents = $total - count($presents);
                ?>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card stats-card total">
                            <div class="card-body text-center">
                                <h5 class="card-title"><i class="fas fa-list"></i> Total enregistrements</h5>
                                <h2 class="text-primary"><?= $total ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stats-card present">
                            <div class="card-body text-center">
                                <h5 class="card-title"><i class="fas fa-check-circle"></i> Présents</h5>
                                <h2 class="text-success"><?= count($presents) ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stats-card absent">
                            <div class="card-body text-center">
                                <h5 class="card-title"><i class="fas fa-times-circle"></i> Absents</h5>
                                <h2 class="text-danger"><?= $absents ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-filter"></i> Filtres</h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="filter_eleve" class="form-label">ID Élève :</label>
                                    <input type="number" id="filter_eleve" class="form-control" placeholder="Filtrer par élève">
                                </div>
                                <div class="col-md-3">
                                    <label for="filter_seance" class="form-label">ID Séance :</label>
                                    <input type="number" id="filter_seance" class="form-control" placeholder="Filtrer par séance">
                                </div>
                                <div class="col-md-3">
                                    <label for="filter_status" class="form-label">Statut :</label>
                                    <select id="filter_status" class="form-select">
                                        <option value="">Tous</option>
                                        <option value="1">Présent</option>
                                        <option value="0">Absent</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                            <i class="fas fa-search"></i> Filtrer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des présences -->
                <?php if (empty($presences)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Aucune présence enregistrée pour le moment.
                        <br><br>
                        <a href="<?= Flight::base() ?>/presence/seance/1" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Créer une feuille de présence
                        </a>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-table"></i> 
                                Liste complète des présences (<?= count($presences) ?> enregistrement<?= count($presences) > 1 ? 's' : '' ?>)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="presencesTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>ID Élève</th>
                                            <th>ID Séance</th>
                                            <th>Statut</th>
                                            <th>Remarque</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($presences as $presence): ?>
                                        <tr data-eleve="<?= $presence['id_eleve'] ?>" data-seance="<?= $presence['id_seances'] ?>" data-status="<?= $presence['present'] ?>">
                                            <td><?= htmlspecialchars($presence['id'] ?? 'N/A') ?></td>
                                            <td>
                                                <a href="<?= Flight::base() ?>/presence/absences/<?= $presence['id_eleve'] ?>" class="badge bg-primary text-decoration-none">
                                                    <?= htmlspecialchars($presence['id_eleve']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= Flight::base() ?>/presence/seance/<?= $presence['id_seances'] ?>" class="badge bg-info text-decoration-none">
                                                    <?= htmlspecialchars($presence['id_seances']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if ($presence['present']): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Présent
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times"></i> Absent
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($presence['remarque'])): ?>
                                                    <span class="text-muted"><?= htmlspecialchars($presence['remarque']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= isset($presence['created_at']) ? date('d/m/Y H:i', strtotime($presence['created_at'])) : 'N/A' ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-warning" onclick="editPresence(<?= $presence['id'] ?>)" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" onclick="deletePresence(<?= $presence['id'] ?>)" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal pour sélection de dates -->
    <div class="modal fade" id="dateRangeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateRangeModalTitle">Sélectionner une période</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="dateRangeForm">
                        <div class="mb-3">
                            <label for="modal_date_debut" class="form-label">Date de début :</label>
                            <input type="date" id="modal_date_debut" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal_date_fin" class="form-label">Date de fin :</label>
                            <input type="date" id="modal_date_fin" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="submitDateRange()">Valider</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour ajout de présence -->
    <div class="modal fade" id="addPresenceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une présence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addPresenceForm" method="post" action="<?= Flight::base() ?>/presence">
                        <div class="mb-3">
                            <label for="modal_id_eleve" class="form-label">ID Élève :</label>
                            <input type="number" id="modal_id_eleve" name="id_eleve" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal_id_seances" class="form-label">ID Séance :</label>
                            <input type="number" id="modal_id_seances" name="id_seances" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal_present" class="form-label">Statut :</label>
                            <select id="modal_present" name="present" class="form-select" required>
                                <option value="1">Présent</option>
                                <option value="0">Absent</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal_remarque" class="form-label">Remarque :</label>
                            <textarea id="modal_remarque" name="remarque" class="form-control" rows="3" placeholder="Remarque optionnelle"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" form="addPresenceForm" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= Flight::base() ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentAction = '';

        function showDateRangeModal(action) {
            currentAction = action;
            const modal = new bootstrap.Modal(document.getElementById('dateRangeModal'));
            const title = action === 'absents' ? 'Voir les élèves absents' : 'Voir les élèves présents';
            document.getElementById('dateRangeModalTitle').textContent = title;
            
            // Définir les dates par défaut (dernière semaine)
            const today = new Date();
            const lastWeek = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
            
            document.getElementById('modal_date_debut').value = lastWeek.toISOString().split('T')[0];
            document.getElementById('modal_date_fin').value = today.toISOString().split('T')[0];
            
            modal.show();
        }

        function submitDateRange() {
            const dateDebut = document.getElementById('modal_date_debut').value;
            const dateFin = document.getElementById('modal_date_fin').value;
            
            if (dateDebut && dateFin) {
                window.location.href = `/presence/${currentAction}/${dateDebut}/${dateFin}`;
            }
        }

        function applyFilters() {
            const eleveFilter = document.getElementById('filter_eleve').value;
            const seanceFilter = document.getElementById('filter_seance').value;
            const statusFilter = document.getElementById('filter_status').value;
            
            const rows = document.querySelectorAll('#presencesTable tbody tr');
            
            rows.forEach(row => {
                let show = true;
                
                if (eleveFilter && row.dataset.eleve !== eleveFilter) {
                    show = false;
                }
                
                if (seanceFilter && row.dataset.seance !== seanceFilter) {
                    show = false;
                }
                
                if (statusFilter !== '' && row.dataset.status !== statusFilter) {
                    show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        }

        function editPresence(id) {
            // TODO: Implémenter la modification
            alert('Fonction de modification à implémenter pour l\'ID: ' + id);
        }

        function deletePresence(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette présence ?')) {
                fetch(`/presence/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la suppression');
                });
            }
        }

        function exportData() {
            // TODO: Implémenter l'export
            alert('Fonction d\'export à implémenter');
        }

        function generateReport() {
            // TODO: Implémenter la génération de rapport
            alert('Fonction de génération de rapport à implémenter');
        }

        // Réinitialiser les filtres
        document.getElementById('filterForm').addEventListener('reset', function() {
            const rows = document.querySelectorAll('#presencesTable tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        });
    </script>
</body>
</html>
