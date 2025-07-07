<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Élèves absents du <?= htmlspecialchars($date_debut) ?> au <?= htmlspecialchars($date_fin) ?></title>
    <link href="<?= Flight::base() ?>/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .date-range { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .student-card { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-user-times"></i> Élèves absents</h1>
                    <a href="<?= Flight::base() ?>/presences" class="btn btn-secondary">Retour à la liste</a>
                </div>

                <!-- Période sélectionnée -->
                <div class="date-range">
                    <h4 class="mb-3"><i class="fas fa-calendar-alt"></i> Période analysée</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Date de début :</strong> 
                            <span class="badge bg-info"><?= date('d/m/Y', strtotime($date_debut)) ?></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Date de fin :</strong> 
                            <span class="badge bg-info"><?= date('d/m/Y', strtotime($date_fin)) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de filtrage -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filtrer par période</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?= Flight::base() ?>/presence/absents/<?= date('Y-m-d') ?>/<?= date('Y-m-d') ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="date_debut" class="form-label">Date de début :</label>
                                    <input type="date" name="date_debut" id="date_debut" class="form-control" value="<?= $date_debut ?>" onchange="updateAction()">
                                </div>
                                <div class="col-md-4">
                                    <label for="date_fin" class="form-label">Date de fin :</label>
                                    <input type="date" name="date_fin" id="date_fin" class="form-control" value="<?= $date_fin ?>" onchange="updateAction()">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary d-block w-100">
                                        <i class="fas fa-search"></i> Rechercher
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des absents -->
                <?php if (empty($absents)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-thumbs-up"></i> 
                        Excellent ! Aucun élève absent sur cette période.
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-list"></i> 
                                Liste des élèves absents (<?= count($absents) ?> absence<?= count($absents) > 1 ? 's' : '' ?>)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID Élève</th>
                                            <th>Nom/Prénom</th>
                                            <th>Date de séance</th>
                                            <th>ID Séance</th>
                                            <th>Remarque</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($absents as $absent): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary"><?= htmlspecialchars($absent['id_eleve']) ?></span>
                                            </td>
                                            <td>
                                                <?= isset($absent['nom']) ? htmlspecialchars($absent['nom'] . ' ' . ($absent['prenom'] ?? '')) : 'N/A' ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    <?= isset($absent['date_seance']) ? date('d/m/Y', strtotime($absent['date_seance'])) : 'N/A' ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($absent['id_seances']) ?></td>
                                            <td>
                                                <?php if (!empty($absent['remarque'])): ?>
                                                    <span class="text-muted"><?= htmlspecialchars($absent['remarque']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Aucune remarque</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="/presence/absences/<?= $absent['id_eleve'] ?>" class="btn btn-outline-info" title="Voir toutes les absences">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-warning" onclick="markPresent(<?= $absent['id'] ?>)" title="Marquer présent">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary" onclick="contactParents(<?= $absent['id_eleve'] ?>)" title="Contacter les parents">
                                                        <i class="fas fa-phone"></i>
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

                    <!-- Statistiques -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Total absences</h5>
                                    <h2 class="text-danger"><?= count($absents) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Élèves différents</h5>
                                    <h2 class="text-warning">
                                        <?= count(array_unique(array_column($absents, 'id_eleve'))) ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Séances concernées</h5>
                                    <h2 class="text-info">
                                        <?= count(array_unique(array_column($absents, 'id_seances'))) ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions groupées -->
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Actions groupées</h5>
                            </div>
                            <div class="card-body">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" onclick="exportAbsents()">
                                        <i class="fas fa-download"></i> Exporter en PDF
                                    </button>
                                    <button type="button" class="btn btn-warning" onclick="sendBulkNotifications()">
                                        <i class="fas fa-envelope-bulk"></i> Notifier tous les parents
                                    </button>
                                    <button type="button" class="btn btn-info" onclick="generateReport()">
                                        <i class="fas fa-chart-line"></i> Générer un rapport
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="<?= Flight::base() ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateAction() {
            const dateDebut = document.getElementById('date_debut').value;
            const dateFin = document.getElementById('date_fin').value;
            const form = document.querySelector('form');
            
            if (dateDebut && dateFin) {
                form.action = `/presence/absents/${dateDebut}/${dateFin}`;
            }
        }

        function markPresent(id) {
            if (confirm('Marquer cet élève comme présent ?')) {
                // TODO: Implémenter la modification du statut
                alert('Fonction à implémenter pour marquer présent');
            }
        }

        function contactParents(idEleve) {
            // TODO: Implémenter le contact parents
            alert('Fonction de contact parents à implémenter pour l\'élève ' + idEleve);
        }

        function exportAbsents() {
            // TODO: Implémenter l'export PDF
            alert('Fonction d\'export PDF à implémenter');
        }

        function sendBulkNotifications() {
            if (confirm('Envoyer une notification à tous les parents des élèves absents ?')) {
                // TODO: Implémenter l'envoi groupé
                alert('Fonction d\'envoi groupé à implémenter');
            }
        }

        function generateReport() {
            // TODO: Implémenter la génération de rapport
            alert('Fonction de génération de rapport à implémenter');
        }
    </script>
</body>
</html>
