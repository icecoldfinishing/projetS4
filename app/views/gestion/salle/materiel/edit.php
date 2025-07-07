<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Éditer matériel</title>
  <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
  <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css" />
  <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
  <div id="app">
    <?= Flight::menuAdmin() ?>
    <div id="main">
      <div class="page-heading">
        <div class="page-title">
          <div class="row align-items-center mb-3">
            <div class="col-md-6">
              <h3 class="fw-bold">Éditer matériel</h3>
              <p class="text-muted">Modification des informations du matériel</p>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Informations du matériel</h4>
            </div>
            <div class="card-body">
              <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                  <?= htmlspecialchars($error) ?>
                </div>
              <?php endif; ?>

              <form method="post" action="<?= Flight::base() ?>/materiel/<?= $type['id_type'] ?>/update">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="label" class="form-label">Label <span class="text-danger">*</span></label>
                    <input
                      type="text"
                      id="label"
                      name="label"
                      class="form-control"
                      value="<?= htmlspecialchars($type['label']) ?>"
                      required
                    />
                  </div>

                  <div class="col-md-6">
                    <label for="prix" class="form-label">Prix (Ar) <span class="text-danger">*</span></label>
                    <input
                      type="number"
                      id="prix"
                      name="prix"
                      class="form-control"
                      step="0.01"
                      min="0"
                      value="<?= htmlspecialchars($type['prix']) ?>"
                      required
                    />
                  </div>

                  <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                      id="description"
                      name="description"
                      class="form-control"
                      rows="4"
                    ><?= htmlspecialchars($type['description']) ?></textarea>
                  </div>

                  <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-save me-1"></i> Mettre à jour
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
</body>
</html>