<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absences de l'élève <?= htmlspecialchars($id_eleve) ?></title>
    <link href="<?= Flight::base() ?>/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .absence-card { margin-bottom: 15px; }
        .date-badge { font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Absences de l'élève <?= htmlspecialchars($id_eleve) ?></h1>
                    <a href="<?= Flight::base() ?>/presences" class="btn btn-secondary">Retour à la liste</a>
                </div>

                <?php if (empty($absences)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Aucune absence enregistrée pour cet élève. Parfait !
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-calendar-times"></i> 
                                Liste des absences (<?= count($absences) ?> absence<?= count($absences) > 1 ? 's' : '' ?>)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Date de séance</th>
                                            <th>ID Séance</th>
                                            <th>Remarque</th>
                                            <th>Date d'enregistrement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($absences as $absence): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-warning text-dark date-badge">
                                                    <?= isset($absence['date_seance']) ? date('d/m/Y', strtotime($absence['date_seance'])) : 'N/A' ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($absence['id_seances']) ?></td>
                                            <td>
                                                <?php if (!empty($absence['remarque'])): ?>
                                                    <span class="text-muted"><?= htmlspecialchars($absence['remarque']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Aucune remarque</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= isset($absence['created_at']) ? date('d/m/Y H:i', strtotime($absence['created_at'])) : 'N/A' ?>
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
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total des absences</h5>
                                    <h2 class="text-danger"><?= count($absences) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Taux d'absence</h5>
                                    <h2 class="text-warning">
                                        <?php 
                                        // Calcul approximatif du taux d'absence (nécessiterait le total de séances)
                                        echo count($absences) > 0 ? count($absences) : '0';
                                        ?> séances
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Actions disponibles</h5>
                            </div>
                            <div class="card-body">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" onclick="exportAbsences()">
                                        <i class="fas fa-download"></i> Exporter en PDF
                                    </button>
                                    <button type="button" class="btn btn-info" onclick="sendNotification()">
                                        <i class="fas fa-envelope"></i> Notifier les parents
                                    </button>
                                    <a href="<?= Flight::base() ?>/presence/seance/new?eleve=<?= $id_eleve ?>" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Ajouter une présence
                                    </a>
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
        function exportAbsences() {
            // TODO: Implémenter l'export PDF
            alert('Fonction d\'export PDF à implémenter');
        }

        function sendNotification() {
            // TODO: Implémenter l'envoi de notification
            alert('Fonction de notification à implémenter');
        }
    </script>
</body>
</html>
