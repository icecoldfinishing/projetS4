<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Groupe</title>
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
                <h3>Modifier un Groupe</h3>
            </div>

            <div class="page-content">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <i class="bi bi-pencil-square"></i> Modification - Groupe #<?= $groupe['id'] ?>
                                </h4>
                            </div>
                            <div class="card-body">
                                <?php if (isset($message)): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($message) ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <form method="post" action="<?= Flight::base() ?>/groupe/update/<?= $groupe['id'] ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nom_responsable" class="form-label">Responsable</label>
                                                <input type="text" class="form-control" id="nom_responsable" name="nom_responsable"
                                                       value="<?= htmlspecialchars($groupe['nom_responsable']) ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" id="contact" name="contact"
                                                       value="<?= htmlspecialchars($groupe['contact']) ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre de personnes</label>
                                                <input type="number" class="form-control" id="nombre" name="nombre"
                                                       value="<?= $groupe['nombre'] ?>" min="1" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="<?= Flight::base() ?>/groupes" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Retour
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Modifier
                                        </button>
                                    </div>
                                </form>
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