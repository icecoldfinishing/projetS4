<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestion des Tarifs & Équipements</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div id="app">
    <?= Flight::menuAdmin() ?>
    <div id="main">
        <div class="page-heading">
            <div class="page-title mb-4">
                <h3 class="fw-bold">Gestion des Tarifs & Équipements</h3>
                <p class="text-subtitle text-muted">Modifiez les tarifs ou ajoutez de nouveaux équipements.</p>
            </div>

            <!-- Tarifs -->
            <section class="section"> 
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tarifs</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Tarif enfants</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tarif-enfant" value="<?= htmlspecialchars($ecolageEnfant ?? 'Non défini') ?>" readonly>
                                    <button class="btn btn-outline-primary edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-success validate-btn d-none"><i class="fas fa-check"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Tarif adulte</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tarif-adulte" value="<?= htmlspecialchars($ecolageAdult ?? 'Non défini') ?>" readonly>
                                    <button class="btn btn-outline-primary edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-success validate-btn d-none"><i class="fas fa-check"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Tarif abonnement</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tarif-mensuel" value="<?= htmlspecialchars($abonnement ?? 'Non défini') ?>" readonly>
                                    <button class="btn btn-outline-primary edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-success validate-btn d-none"><i class="fas fa-check"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Tarif club par heure</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tarif-heure" value="<?= htmlspecialchars($club ?? 'Non défini') ?>" readonly>
                                    <button class="btn btn-outline-primary edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-success validate-btn d-none"><i class="fas fa-check"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
<script src="<?= Flight::base() ?>/public/assets/extensions/jquery/jquery.min.js"></script>
<script>const base_url = '<?= Flight::base() ?>' </script>
<script>
    // Activer le mode édition
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const parent = button.closest('.input-group');
            const input = parent.querySelector('input');
            const validate = parent.querySelector('.validate-btn');

            input.dataset.previousValue = input.value;
            input.removeAttribute('readonly');
            input.focus();
            button.classList.add('d-none');
            validate.classList.remove('d-none');
        });
    });

    // Valider et envoyer les modifications
    document.querySelectorAll('.validate-btn').forEach(button => {
        button.addEventListener('click', () => {
            const parent = button.closest('.input-group');
            const input = parent.querySelector('input');
            const edit = parent.querySelector('.edit-btn');

            const newValue = input.value.trim();
            const oldValue = input.dataset.previousValue || '';
            const montant = parseFloat(newValue.replace(',', '.'));

            if (isNaN(montant) || montant < 0) {
                alert('Veuillez entrer un montant numérique valide.');
                return;
            }

            if (newValue !== oldValue) {
                const confirmed = confirm(`Confirmer le changement de tarif de "${oldValue}" vers "${newValue}" ?`);
                if (!confirmed) {
                    input.value = oldValue;
                    return;
                }

                let url = '';
                switch (input.id) {
                    case 'tarif-enfant': url = base_url + '/tarif/update/enfant'; break;
                    case 'tarif-adulte': url = base_url +'/tarif/update/adulte'; break;
                    case 'tarif-mensuel': url = base_url + '/tarif/update/abonnement'; break;
                    case 'tarif-heure': url = base_url + '/tarif/update/club'; break;
                    default:
                        alert('Champ non reconnu.');
                        return;
                }

                fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ montant })
                })
                .then(res => {
                    // Check if response is ok and contains content
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }

                    // Check if response has content before parsing JSON
                    return res.text().then(text => {
                        if (!text) {
                            throw new Error('Empty response from server');
                        }
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Response text:', text);
                            throw new Error('Invalid JSON response from server');
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        alert('Tarif mis à jour avec succès.');
                        location.reload();
                    } else {
                        alert('Erreur lors de la mise à jour: ' + (data.message || 'Erreur inconnue'));
                        input.value = oldValue;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Erreur de communication avec le serveur: ' + error.message);
                    input.value = oldValue;
                });
            }

            input.setAttribute('readonly', true);
            button.classList.add('d-none');
            edit.classList.remove('d-none');
        });
    });
</script>
</body>
</html>