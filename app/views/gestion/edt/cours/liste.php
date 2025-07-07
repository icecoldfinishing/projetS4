<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liste des cours</title>
    
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    
    <!-- CSS Mazer & modules -->
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/table-datatable-jquery.css" />
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
                <div class="page-title">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0">Liste des cours</h3>
                            <p class="text-subtitle text-muted">Cours disponibles dans le système</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?= Flight::base() ?>/formCours" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Ajouter un cours
                            </a>
                        </div>
                    </div>

                    <?php if (isset($message)) : ?>
                        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                            <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                </div>

                <section class="section mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Cours enregistrés</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom du cours</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($cours)) : ?>
                                            <?php foreach ($cours as $c) : ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($c['id_cours']) ?></td>
                                                    <td><?= htmlspecialchars($c['label']) ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= Flight::base() ?>/formCours?id=<?= urlencode($c['id_cours']) ?>" class="btn btn-sm btn-outline-warning">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <a href="<?= Flight::base() ?>/deleteCours?id=<?= urlencode($c['id_cours']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">aucun cours disponible</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= Flight::base() ?>/public/assets/extensions/jquery/jquery.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/static/js/pages/datatables.js"></script>
</body>
</html>
