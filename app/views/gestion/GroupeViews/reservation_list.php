<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Liste des Réservations</title>
            <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
            <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">
            <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
        </head>
        <body>
            <div id="app">
                <?= Flight::menuAdmin() ?>
                <div id="main">
                    <header class="mb-3">
                        <a href="#" class="burger-btn d-block d-xl-none">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                    </header>

                    <div class="page-heading">
                        <h3>Liste des Réservations</h3>
                    </div>

                    <div class="page-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Réservations enregistrées</h4>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" placeholder="Rechercher une réservation...">
                                            <a href="<?= Flight::base() ?>/reservation/insert" class="btn btn-primary">
                                                <i class="bi bi-plus-circle"></i> Nouvelle Réservation
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($message)): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <?= htmlspecialchars($message) ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        <?php endif; ?>

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>ID Club</th>
                                                        <th>Date de réservation</th>
                                                        <th>Date réservée</th>
                                                        <th>Horaires</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($reservations as $res): ?>
                                                        <tr>
                                                            <td>
                                                                <span class="badge bg-primary">#<?= $res['id_reservation'] ?></span>
                                                            </td>
                                                            <td><?= $res['id_club'] ?></td>
                                                            <td><?= date('d/m/Y H:i', strtotime($res['date_reservation'])) ?></td>
                                                            <td><?= date('d/m/Y', strtotime($res['date_reserve'])) ?></td>
                                                            <td>
                                                                <span class="badge bg-info">
                                                                    <?= $res['heure_debut'] ?> - <?= $res['heure_fin'] ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="<?= Flight::base() ?>/reservation/<?= $res['id_reservation'] ?>"
                                                                       class="btn btn-sm btn-outline-primary">
                                                                        <i class="bi bi-eye"></i> Voir
                                                                    </a>
                                                                    <a href="<?= Flight::base() ?>/reservation/delete/<?= $res['id_reservation'] ?>"
                                                                       class="btn btn-sm btn-outline-danger"
                                                                       onclick="return confirm('Confirmer la suppression ?')">
                                                                        <i class="bi bi-trash"></i> Supprimer
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
        </body>
        </html>