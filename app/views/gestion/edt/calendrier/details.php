<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du groupe <?= htmlspecialchars($groupe) ?> - <?= htmlspecialchars($date) ?></title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/extensions/bootstrap-icons/bootstrap-icons.min.css">
</head>
<body>
    <div id="app">
        <?= Flight::menuAdmin() ?>
        <div id="main">
            <div class="page-heading">
                <div class="container">
                    <h3><i class="bi bi-people"></i> Groupe <?= htmlspecialchars($groupe) ?> - <i class="bi bi-calendar-event"></i> <?= htmlspecialchars($date) ?></h3>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title"><i class="bi bi-person-lines-fill"></i> Liste des élèves</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($eleves)): ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($eleves as $e): ?>
                                        <li class="list-group-item">
                                            <?= htmlspecialchars($e['nom']) ?> <?= htmlspecialchars($e['prenom']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Aucun élève trouvé pour ce groupe.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <a href="<?= Flight::base() ?>/calendrier?mois=<?= date('n', strtotime($date)) ?>&annee=<?= date('Y', strtotime($date)) ?>" class="btn btn-outline-secondary mt-4">
                        <i class="bi bi-arrow-left-circle"></i> Retour au calendrier
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
</body>
</html>
