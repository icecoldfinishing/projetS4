<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Détails du matériel - InfraProject</title>
  <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
  <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css" />
  <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
  <div id="app">
    <?= Flight::menuAdmin() ?>
    <div id="main" class="page-content container py-4">
      <div class="page-heading mb-4">
        <h2 class="fw-bold">Détails du matériel</h2>
        <p class="text-muted">Informations complètes sur le matériel sélectionné</p>
      </div>

      <div class="card">
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-3">Référence :</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($type['reference']) ?></dd>

            <dt class="col-sm-3">Label :</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($type['label']) ?></dd>

            <dt class="col-sm-3">Description :</dt>
            <dd class="col-sm-9"><?= nl2br(htmlspecialchars($type['description'])) ?></dd>

            <dt class="col-sm-3">Prix :</dt>
            <dd class="col-sm-9"><?= number_format($type['prix'], 2, ',', ' ') ?> Ar</dd>
          </dl>

          <a href="<?= Flight::base() ?>/materiel" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
</body>
</html>
