<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !is_null($seance) ? 'Modifier une séance' : 'Insertion d’une séance' ?></title>
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
                <h3>
                    <i class="bi <?= is_null($seance) ? 'bi-plus-circle' : 'bi-pencil-square' ?>"></i>
                    <?= is_null($seance) ? 'Insertion d’une séance' : 'Modification de la séance' ?>
                </h3>

                <?php if (isset($message)) : ?>
                    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mt-4">
                    <div class="card-body">
                        <form method="post" action="<?= Flight::base() ?><?= is_null($seance) ? '/insertSeance' : '/updateSeance' ?>">
                            <?php if (!is_null($seance)) : ?>
                                <input type="hidden" name="id" value="<?= htmlspecialchars($seance['id_seances']) ?>">
                            <?php endif; ?>

                            <div class="row">
                                <!-- Cours -->
                                <div class="col-md-6 mb-3">
                                    <label for="id_cours" class="form-label">
                                        <i class="bi bi-journal-bookmark-fill"></i> Cours
                                    </label>
                                    <select name="id_cours" id="id_cours" class="form-select" required>
                                        <option value="">-- Sélectionner --</option>
                                        <?php foreach ($cours as $c): ?>
                                            <option value="<?= $c['id_cours'] ?>" <?= (!is_null($seance) && $seance['id_cours'] == $c['id_cours']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['label']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label">
                                        <i class="bi bi-calendar-event"></i> Date
                                    </label>
                                    <input type="date" name="date" id="date" class="form-control" required
                                           value="<?= !is_null($seance) ? htmlspecialchars($seance['date']) : '' ?>">
                                </div>
                            </div>

                            <!-- Plage horaire (uniquement en insertion) -->
                            <?php if (is_null($seance)): ?>
                                <div class="mb-3">
                                    <label for="id_plage" class="form-label">
                                        <i class="bi bi-clock-history"></i> Plage horaire
                                    </label>
                                    <select name="id_plage" id="id_plage" class="form-select" required>
                                        <option value="">-- Sélectionner --</option>
                                        <?php foreach ($plages as $p): ?>
                                            <?php if (in_array($p['heure_debut'], ['08:00:00', '13:00:00'])): ?>
                                                <?php $label = ($p['heure_debut'] === '08:00:00') ? 'Matin' : 'Après-midi'; ?>
                                                <option value="<?= $p['id'] ?>"><?= $label ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <!-- Professeur -->
                            <div class="mb-4">
                                <label for="id_prof" class="form-label">
                                    <i class="bi bi-person-badge"></i> Professeur
                                </label>
                                <select name="id_prof" id="id_prof" class="form-select" required>
                                    <option value="">-- Sélectionner --</option>
                                    <?php foreach ($profs as $prof): ?>
                                        <option value="<?= $prof['id_prof'] ?>" <?= (!is_null($seance) && $seance['id_prof'] == $prof['id_prof']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($prof['nom']) ?> <?= htmlspecialchars($prof['prenom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Boutons -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> <?= is_null($seance) ? 'Ajouter' : 'Mettre à jour' ?>
                                </button>
                                <?php if (!is_null($seance)): ?>
                                    <a href="/formSeance" class="btn btn-secondary ms-2">
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
