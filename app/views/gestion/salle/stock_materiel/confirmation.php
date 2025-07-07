<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirmer un mouvement</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
<div id="app">
    <?= Flight::menuAdmin() ?>
    <div id="main" class="page-content container py-4">
        <div class="page-heading mb-4">
            <h3 class="fw-bold">Confirmation du mouvement : 
                <span class="text-primary"><?= $mouvement == 'I' ? 'Entrée' : 'Sortie' ?></span>
            </h3>
            <p class="text-muted">Veuillez <?= $mouvement == 'I' ? 'saisir les numéros de série à entrer' : 'sélectionner les matériels à retirer' ?>.</p>
        </div>

        <div class="card">
            <div class="card-body">

                <?php if ($mouvement == 'I'): ?>
                    <form method="POST" action="<?= Flight::base() ?>/stock/insert-series">
                        <input type="hidden" name="id_type" value="<?= $id_type ?>">
                        <input type="hidden" name="quantite" value="<?= $quantite ?>">

                        <?php for ($i = 1; $i <= $quantite; $i++): ?>
                            <div class="mb-3">
                                <label class="form-label">Numéro de série #<?= $i ?></label>
                                <input type="text" name="series[]" class="form-control"
                                       required
                                       value="<?= htmlspecialchars($label_type) . str_pad($i, 3, '0', STR_PAD_LEFT) ?>">
                            </div>
                        <?php endfor; ?>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>

                <?php else: ?>
                    <div class="mb-3">
                        <input type="text" id="search" placeholder="Rechercher un numéro de série..." class="form-control">
                    </div>

                    <form method="POST" action="<?= Flight::base() ?>/stock/remove-items">
                        <input type="hidden" name="id_type" value="<?= $id_type ?>">

                        <div id="materiel-list" class="mb-4">
                            <?php foreach ($materiels as $item): ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="selected[]" value="<?= $item['id_item'] ?>" id="item<?= $item['id_item'] ?>">
                                    <label class="form-check-label" for="item<?= $item['id_item'] ?>">
                                        <?= htmlspecialchars($item['num_serie']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-x-circle me-1"></i> Retirer la sélection
                            </button>
                        </div>
                    </form>

                    <script>
                        const searchInput = document.getElementById('search');
                        const items = document.querySelectorAll('#materiel-list .form-check');
                        searchInput.addEventListener('input', () => {
                            const query = searchInput.value.toLowerCase();
                            items.forEach(item => {
                                item.style.display = item.textContent.toLowerCase().includes(query) ? 'block' : 'none';
                            });
                        });
                    </script>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
</body>
</html>
