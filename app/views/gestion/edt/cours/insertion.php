<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($cours) && $cours ? 'Modifier un cours' : 'Insertion d’un cours' ?></title>

    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/extensions/bootstrap-icons/bootstrap-icons.min.css" />
</head>
<body>
<div id="app">
    <?= Flight::menuAdmin() ?>
    <div id="main">
        <div class="page-heading">
            <div class="container">
                <h3>
                    <i class="bi <?= isset($cours) && $cours ? 'bi-pencil-square' : 'bi-plus-circle' ?>"></i>
                    <?= isset($cours) && $cours ? 'Modifier un cours' : 'Insertion d’un cours' ?>
                </h3>

                <?php if (isset($message)) : ?>
                    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mt-4">
                    <div class="card-body">
                        <form method="post" action="<?= Flight::base() ?><?= isset($cours) && $cours ? '/updateCours' : '/insertCours' ?>">
                            <?php if (isset($cours) && $cours): ?>
                                <input type="hidden" name="id" value="<?= htmlspecialchars($cours['id_cours']) ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="label" class="form-label">
                                    <i class="bi bi-journal-bookmark-fill"></i> Nom du cours
                                </label>
                                <input type="text" name="label" id="label" class="form-control" required
                                    value="<?= isset($cours['label']) ? htmlspecialchars($cours['label']) : '' ?>" />
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i>
                                    <?= isset($cours) && $cours ? 'Mettre à jour' : 'Ajouter' ?>
                                </button>
                                <?php if (isset($cours) && $cours): ?>
                                    <a href="<?= Flight::base() ?>/listeCours" class="btn btn-secondary ms-2">
                                        <i class="bi bi-x-circle"></i> Annuler
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

            </div> <!-- /container -->
        </div>
    </div>
</div>

<script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
</body>
</html>
