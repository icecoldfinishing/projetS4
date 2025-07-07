<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter une Réservation</title>
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
                    <h3>Ajouter une Réservation</h3>
                </div>

                <div class="page-content">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="bi bi-calendar-plus"></i> Nouvelle Réservation
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($message)): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?= htmlspecialchars($message) ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form method="post" action="<?= Flight::base() ?>/reservation/insert">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="id_club" class="form-label">Club / Groupe</label>
                                                    <select class="form-select" id="id_club" name="id_club" required>
                                                        <option value="" disabled selected>-- Choisissez un groupe --</option>
                                                        <?php foreach ($groupes as $g): ?>
                                                            <option value="<?= $g['id'] ?>">
                                                                <?= htmlspecialchars($g['nom_responsable']) ?> (<?= $g['nombre'] ?> pers)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="valeur" class="form-label">Statut</label>
                                                    <select class="form-select" id="valeur" name="valeur" required>
                                                        <option value="" disabled selected>-- Statut --</option>
                                                        <option value="demande">Demande</option>
                                                        <option value="confirme">Confirmé</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="date_reservation" class="form-label">Date de réservation</label>
                                                    <input type="datetime-local" class="form-control" id="date_reservation" name="date_reservation" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="date_reserve" class="form-label">Date réservée</label>
                                                    <input type="datetime-local" class="form-control" id="date_reserve" name="date_reserve" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="heure_debut" class="form-label">Heure de début</label>
                                                    <input type="time" class="form-control" id="heure_debut" name="heure_debut" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="heure_fin" class="form-label">Heure de fin</label>
                                                    <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="<?= Flight::base() ?>/reservations" class="btn btn-secondary">
                                                <i class="bi bi-arrow-left"></i> Retour à la liste
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Ajouter
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