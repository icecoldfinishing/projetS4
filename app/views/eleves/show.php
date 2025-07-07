<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Élève - <?= htmlspecialchars($eleve['prenom'] . ' ' . $eleve['nom']) ?></title>
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
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Détails de l'Élève</h3>
                    <div>
                        <a href="/eleves" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left me-1"></i>
                            Retour
                        </a>
                        <a href="/eleves/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Nouvel Élève
                        </a>
                    </div>
                </div>
            </div>

            <div class="page-content">
                <section class="row">
                    <!-- Informations de l'élève -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <i class="bi bi-person-circle me-2"></i>
                                    <?= htmlspecialchars($eleve['prenom'] . ' ' . $eleve['nom']) ?>
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Genre :</td>
                                                <td>
                                                    <span class="badge bg-light-primary">
                                                        <?= htmlspecialchars($eleve['genre_label'] ?? 'Non spécifié') ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Date de naissance :</td>
                                                <td><?= date('d/m/Y', strtotime($eleve['date_naissance'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Contact :</td>
                                                <td><?= htmlspecialchars($eleve['contact'] ?? 'Non spécifié') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Date d'inscription :</td>
                                                <td><?= date('d/m/Y H:i', strtotime($eleve['date_inscription'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Adresse :</td>
                                                <td><?= htmlspecialchars($eleve['adresse'] ?? 'Non spécifiée') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parents associés -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-people me-2"></i>
                                    Parents
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($parents)): ?>
                                    <div class="text-center py-3">
                                        <i class="bi bi-person-x text-muted" style="font-size: 2rem;"></i>
                                        <p class="mt-2 text-muted">Aucun parent associé</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($parents as $parent): ?>
                                        <div class="mb-3 p-3 border rounded">
                                            <h6 class="mb-2">
                                                <i class="bi bi-person me-1"></i>
                                                <?= htmlspecialchars($parent['prenom'] . ' ' . $parent['nom']) ?>
                                            </h6>
                                            <?php if (!empty($parent['contact'])): ?>
                                                <div class="small text-muted mb-1">
                                                    <i class="bi bi-telephone me-1"></i>
                                                    <?= htmlspecialchars($parent['contact']) ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($parent['adresse'])): ?>
                                                <div class="small text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    <?= htmlspecialchars($parent['adresse']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
</body>
</html>