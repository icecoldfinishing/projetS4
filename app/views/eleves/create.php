<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élève</title>
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
                    <h3>Ajouter un Élève</h3>
                    <a href="/eleves" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>

            <div class="page-content">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= Flight::base() ?>/eleves">
                    <div class="row">
                        <!-- Informations de l'élève -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="bi bi-person me-2"></i>
                                        Informations de l'élève
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="nom" class="form-label">Nom *</label>
                                                <input type="text" class="form-control" id="nom" name="nom" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="prenom" class="form-label">Prénom *</label>
                                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="date_naissance" class="form-label">Date de naissance *</label>
                                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="id_genre" class="form-label">Genre *</label>
                                                <select class="form-select" id="id_genre" name="id_genre" required>
                                                    <option value="">Sélectionner un genre</option>
                                                    <?php foreach ($genres as $genre): ?>
                                                        <option value="<?= $genre['id_genre'] ?>">
                                                            <?= htmlspecialchars($genre['label']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="contact" class="form-label">Contact</label>
                                        <input type="text" class="form-control" id="contact" name="contact">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="adresse" class="form-label">Adresse</label>
                                        <textarea class="form-control" id="adresse" name="adresse" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Association avec parent -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-people me-2"></i>
                                        Association Parent
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="parent_option" value="none" id="parent_none" checked onchange="toggleParentFields()">
                                        <label class="form-check-label" for="parent_none">
                                            Aucun parent pour le moment
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="parent_option" value="existing" id="parent_existing" onchange="toggleParentFields()">
                                        <label class="form-check-label" for="parent_existing">
                                            Associer à un parent existant
                                        </label>
                                    </div>

                                    <div id="existing-parent-field" style="display: none;" class="mb-3">
                                        <select class="form-select" id="existing_parent" name="existing_parent" disabled>
                                            <option value="">Sélectionner un parent</option>
                                            <?php foreach ($parents as $parent): ?>
                                                <option value="<?= $parent['id_parent'] ?>">
                                                    <?= htmlspecialchars($parent['prenom'] . ' ' . $parent['nom']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="parent_option" value="new" id="parent_new" onchange="toggleParentFields()">
                                        <label class="form-check-label" for="parent_new">
                                            Créer un nouveau parent
                                        </label>
                                    </div>

                                    <div id="new-parent-fields" style="display: none;">
                                        <div class="form-group mb-3">
                                            <label for="new_parent_nom" class="form-label">Nom du parent</label>
                                            <input type="text" class="form-control" id="new_parent_nom" name="new_parent_nom">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="new_parent_prenom" class="form-label">Prénom du parent</label>
                                            <input type="text" class="form-control" id="new_parent_prenom" name="new_parent_prenom">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="new_parent_contact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" id="new_parent_contact" name="new_parent_contact">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="new_parent_adresse" class="form-label">Adresse</label>
                                            <textarea class="form-control" id="new_parent_adresse" name="new_parent_adresse" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <a href="/eleves" class="btn btn-light me-2">Annuler</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleParentFields() {
            const option = document.querySelector('input[name="parent_option"]:checked').value;
            const existingField = document.getElementById('existing-parent-field');
            const existingSelect = document.getElementById('existing_parent');
            const newFields = document.getElementById('new-parent-fields');

            // Reset all
            existingField.style.display = 'none';
            existingSelect.disabled = true;
            existingSelect.value = '';
            newFields.style.display = 'none';

            if (option === 'existing') {
                existingField.style.display = 'block';
                existingSelect.disabled = false;
            } else if (option === 'new') {
                newFields.style.display = 'block';
            }
        }
    </script>

    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
</body>
</html>