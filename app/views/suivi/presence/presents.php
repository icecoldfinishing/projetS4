<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Élèves présents du <?= htmlspecialchars($date_debut) ?> au <?= htmlspecialchars($date_fin) ?></title>
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
                    <h1><i class="fas fa-user-check"></i> Élèves présents</h1>
                    <a href="<?= Flight::base() ?>/presences" class="btn btn-secondary">Retour à la liste</a>
                </div>

                <!-- Période sélectionnée -->
                <div class="date-range">
                    <h4 class="mb-3"><i class="fas fa-calendar-alt"></i> Période analysée</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Date de début :</strong> 
                            <span class="badge bg-success"><?= date('d/m/Y', strtotime($date_debut)) ?></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Date de fin :</strong> 
                            <span class="badge bg-success"><?= date('d/m/Y', strtotime($date_fin)) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de filtrage -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filtrer par période</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?= Flight::base() ?>/presence/presents/<?= date('Y-m-d') ?>/<?= date('Y-m-d') ?>">
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

                <!-- Liste des présents -->
                <?php if (empty($presents) || !is_array($presents)): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Aucune présence enregistrée sur cette période.
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-list"></i> 
                                Liste des élèves présents (<?= count($presents) ?> présence<?= count($presents) > 1 ? 's' : '' ?>)
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
                                        <?php foreach ($presents as $present): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-success"><?= htmlspecialchars($present['id_eleve']) ?></span>
                                            </td>
                                            <td>
                                                <?= isset($present['nom']) ? htmlspecialchars($present['nom'] . ' ' . ($present['prenom'] ?? '')) : 'N/A' ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    <?= isset($present['date_seance']) ? date('d/m/Y', strtotime($present['date_seance'])) : 'N/A' ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($present['id_seances']) ?></td>
                                            <td>
                                                <?php if (!empty($present['remarque'])): ?>
                                                    <span class="text-muted"><?= htmlspecialchars($present['remarque']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Aucune remarque</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= Flight::base() ?>/presence/absences/<?= $present['id_eleve'] ?>" class="btn btn-outline-info" title="Voir l'historique">
                                                        <i class="fas fa-history"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-warning" onclick="markAbsent(<?= $present['id'] ?>)" title="Marquer absent">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary" onclick="addNote(<?= $present['id'] ?>)" title="Ajouter une note">
                                                        <i class="fas fa-sticky-note"></i>
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
                                    <h5 class="card-title">Total présences</h5>
                                    <h2 class="text-success"><?= count($presents) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Élèves différents</h5>
                                    <h2 class="text-primary">
                                        <?= count(array_unique(array_column($presents, 'id_eleve'))) ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Séances concernées</h5>
                                    <h2 class="text-info">
                                        <?= count(array_unique(array_column($presents, 'id_seances'))) ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top des élèves les plus assidus -->
                    <?php 
                    $assiduite = [];
                    foreach ($presents as $present) {
                        $id_eleve = $present['id_eleve'];
                        if (!isset($assiduite[$id_eleve])) {
                            $assiduite[$id_eleve] = 0;
                        }
                        $assiduite[$id_eleve]++;
                    }
                    arsort($assiduite);
                    $top_assidus = array_slice($assiduite, 0, 5, true);
                    ?>

                    <?php if (!empty($top_assidus)): ?>
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-trophy"></i> Top 5 des élèves les plus assidus</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php $position = 1; foreach ($top_assidus as $id_eleve => $nombre_presences): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <?php if ($position == 1): ?>
                                                    <span class="badge bg-warning text-dark fs-6">🥇</span>
                                                <?php elseif ($position == 2): ?>
                                                    <span class="badge bg-secondary fs-6">🥈</span>
                                                <?php elseif ($position == 3): ?>
                                                    <span class="badge bg-info fs-6">🥉</span>
                                                <?php else: ?>
                                                    <span class="badge bg-light text-dark fs-6"><?= $position ?>.</span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <strong>Élève <?= $id_eleve ?></strong><br>
                                                <small class="text-muted"><?= $nombre_presences ?> présence<?= $nombre_presences > 1 ? 's' : '' ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $position++; endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Actions groupées -->
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Actions groupées</h5>
                            </div>
                            <div class="card-body">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" onclick="exportPresents()">
                                        <i class="fas fa-download"></i> Exporter en PDF
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="sendCongratulations()">
                                        <i class="fas fa-certificate"></i> Féliciter les assidus
                                    </button>
                                    <button type="button" class="btn btn-info" onclick="generateAttendanceReport()">
                                        <i class="fas fa-chart-bar"></i> Rapport d'assiduité
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
                form.action = `/presence/presents/${dateDebut}/${dateFin}`;
            }
        }

        function markAbsent(id) {
            if (confirm('Marquer cet élève comme absent ?')) {
                // TODO: Implémenter la modification du statut
                alert('Fonction à implémenter pour marquer absent');
            }
        }

        function addNote(id) {
            const note = prompt('Ajouter une remarque :');
            if (note) {
                // TODO: Implémenter l'ajout de note
                alert('Fonction d\'ajout de note à implémenter : ' + note);
            }
        }

        function exportPresents() {
            // TODO: Implémenter l'export PDF
            alert('Fonction d\'export PDF à implémenter');
        }

        function sendCongratulations() {
            if (confirm('Envoyer des félicitations aux élèves les plus assidus ?')) {
                // TODO: Implémenter l'envoi de félicitations
                alert('Fonction d\'envoi de félicitations à implémenter');
            }
        }

        function generateAttendanceReport() {
            // TODO: Implémenter la génération de rapport d'assiduité
            alert('Fonction de génération de rapport d\'assiduité à implémenter');
        }
    </script>
</body>
</html>
