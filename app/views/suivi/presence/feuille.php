<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de Présence - Séance <?= htmlspecialchars($id_seances) ?></title>
    <link href="<?= Flight::base() ?>/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .presence-form { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .status-present { color: #28a745; font-weight: bold; }
        .status-absent { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Feuille de Présence - Séance <?= htmlspecialchars($id_seances) ?></h1>
                
                <!-- Formulaire d'ajout d'une présence -->
                <div class="presence-form">
                    <h3>Ajouter une présence</h3>
                    <form method="post" action="<?= Flight::base() ?>/presence">
                        <input type="hidden" name="id_seances" value="<?= htmlspecialchars($id_seances) ?>">
                        
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id_eleve" class="form-label">ID Élève :</label>
                                <input type="number" name="id_eleve" id="id_eleve" class="form-control" required>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="present" class="form-label">Statut :</label>
                                <select name="present" id="present" class="form-select">
                                    <option value="1">Présent</option>
                                    <option value="0">Absent</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="remarque" class="form-label">Remarque :</label>
                                <input type="text" name="remarque" id="remarque" class="form-control" placeholder="Remarque optionnelle">
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Liste des présences -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Liste des présences</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($presences)): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Aucune présence enregistrée pour cette séance.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID Élève</th>
                                            <th>Statut</th>
                                            <th>Remarque</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($presences as $presence): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($presence['id_eleve']) ?></td>
                                            <td>
                                                <?php if ($presence['present']): ?>
                                                    <span class="badge bg-success">Présent</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Absent</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($presence['remarque'] ?? '-') ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-warning" onclick="editPresence(<?= $presence['id'] ?>)">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" onclick="deletePresence(<?= $presence['id'] ?>)">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Statistiques -->
                <?php 
                $total = count($presences);
                $presents = array_filter($presences, function($p) { return $p['present']; });
                $absents = $total - count($presents);
                ?>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total</h5>
                                <h2 class="text-primary"><?= $total ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Présents</h5>
                                <h2 class="text-success"><?= count($presents) ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Absents</h5>
                                <h2 class="text-danger"><?= $absents ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= Flight::base() ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function editPresence(id) {
            // TODO: Implémenter la modification
            alert('Fonction de modification à implémenter pour l\'ID: ' + id);
        }

        function deletePresence(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette présence ?')) {
                // TODO: Implémenter la suppression
                fetch('/presence/delete/' + id, {
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
    </script>
</body>
</html>
