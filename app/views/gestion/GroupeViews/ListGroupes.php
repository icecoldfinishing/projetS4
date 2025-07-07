<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Liste des Groupes</title>
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
                            <h3>Liste des Groupes</h3>
                        </div>

                        <div class="page-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Groupes enregistrés</h4>
                                            <div class="d-flex gap-2">
                                                <input type="text" class="form-control" placeholder="Rechercher un groupe...">
                                                <a href="<?= Flight::base() ?>/groupe/insert" class="btn btn-primary">
                                                    <i class="bi bi-plus-circle"></i> Nouveau Groupe
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Responsable</th>
                                                            <th>Contact</th>
                                                            <th>Nombre</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($groupes as $groupe): ?>
                                                            <tr>
                                                                <td><?= $groupe['id'] ?></td>
                                                                <td><?= htmlspecialchars($groupe['nom_responsable']) ?></td>
                                                                <td><?= htmlspecialchars($groupe['contact']) ?></td>
                                                                <td>
                                                                    <span class="badge bg-info"><?= $groupe['nombre'] ?> pers.</span>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group" role="group">
                                                                        <a href="<?= Flight::base() ?>/groupe/<?= $groupe['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                                            <i class="bi bi-eye"></i> Voir
                                                                        </a>
                                                                        <a href="<?= Flight::base() ?>/groupe/delete/<?= $groupe['id'] ?>"
                                                                           class="btn btn-sm btn-outline-danger"
                                                                           onclick="return confirm('Supprimer ce groupe ?')">
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