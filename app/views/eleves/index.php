<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Élèves</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
    <style>
        .student-card {
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, #007bff, #0056b3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .student-info .badge {
            font-size: 0.75rem;
        }
    </style>
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
                    <h3>Liste des Élèves</h3>
                    <a href="/eleves/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Nouvel Élève
                    </a>
                </div>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Élèves inscrits (<?= count($eleves) ?>)</h4>
                            </div>
                            <div class="card-body">
                                <?php if (empty($eleves)): ?>
                                    <div class="text-center py-5">
                                        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                        <h5 class="mt-3 text-muted">Aucun élève trouvé</h5>
                                        <p class="text-muted">Commencez par ajouter votre premier élève</p>
                                        <a href="<?= Flight::base() ?>/eleves/create" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Ajouter un élève
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <?php foreach ($eleves as $eleve): ?>
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card student-card h-100" onclick="window.location.href='<?= Flight::base() ?>/eleves/<?= $eleve['id_eleve'] ?>'">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-start">
                                                            <div class="student-avatar me-3">
                                                                <?= strtoupper(substr($eleve['prenom'], 0, 1) . substr($eleve['nom'], 0, 1)) ?>
                                                            </div>
                                                            <div class="student-info flex-grow-1">
                                                                <h5 class="card-title mb-1">
                                                                    <?= htmlspecialchars($eleve['prenom'] . ' ' . $eleve['nom']) ?>
                                                                </h5>
                                                                <div class="mb-2">
                                                                    <span class="badge bg-light-primary">
                                                                        <?= htmlspecialchars($eleve['genre_label'] ?? 'Non spécifié') ?>
                                                                    </span>
                                                                </div>
                                                                <div class="text-muted small">
                                                                    <div class="mb-1">
                                                                        <i class="bi bi-calendar-event me-1"></i>
                                                                        <?= date('d/m/Y', strtotime($eleve['date_naissance'])) ?>
                                                                    </div>
                                                                    <?php if (!empty($eleve['contact'])): ?>
                                                                        <div class="mb-1">
                                                                            <i class="bi bi-telephone me-1"></i>
                                                                            <?= htmlspecialchars($eleve['contact']) ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <div>
                                                                        <i class="bi bi-calendar-plus me-1"></i>
                                                                        Inscrit le <?= date('d/m/Y', strtotime($eleve['date_inscription'])) ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
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