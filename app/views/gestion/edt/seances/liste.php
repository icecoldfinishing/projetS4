<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des séances</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app-dark.css">

    <!-- Modules CSS -->
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/extensions/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/table-datatable-jquery.css">
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
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="fw-bold mb-1">Liste des séances</h3>
                        <p class="text-muted">Toutes les séances planifiées</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="<?= Flight::base() ?>/formSeance" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Nouvelle séance
                        </a>
                    </div>
                </div>
            </div>

            <?php if (!empty($message)) : ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Tableau des séances -->
            <section class="section mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Séances programmées</h4>
                        <div class="d-flex align-items-center">
                            <label for="dateFilter" class="me-2 mb-0 fw-semibold">Date :</label>
                            <input type="date" id="dateFilter" class="form-control form-control-sm w-auto" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive datatable-minimal">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cours</th>
                                        <th>Date</th>
                                        <th>Heures</th>
                                        <th>Professeur</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($seances as $s): ?>
                                        <tr>
                                            <td><?= $s['id_seances'] ?></td>
                                            <td><?= htmlspecialchars($s['nom_cours']) ?></td>
                                            <td><?= htmlspecialchars($s['date']) ?></td>
                                            <td><?= htmlspecialchars($s['heure_debut']) ?> - <?= htmlspecialchars($s['heure_fin']) ?></td>
                                            <td><?= htmlspecialchars($s['nom_prof']) ?> <?= htmlspecialchars($s['prenom_prof']) ?></td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= Flight::base() ?>/formSeance?id=<?= $s['id_seances'] ?>" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= Flight::base() ?>/deleteSeance?id=<?= $s['id_seances'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php if (empty($seances)) : ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Aucune séance trouvée.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
<script src="<?= Flight::base() ?>/public/assets/extensions/jquery/jquery.min.js"></script>
<script src="<?= Flight::base() ?>/public/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= Flight::base() ?>/public/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= Flight::base() ?>/public/assets/static/js/pages/datatables.js"></script>
<script>
    $(document).ready(function() {
        // Initialisation du DataTable
        var table = $('#table1').DataTable();

        // Fonction pour formater la date en YYYY-MM-DD
        function getTodayDate() {
            var today = new Date();
            var yyyy = today.getFullYear();
            var mm = ('0' + (today.getMonth() + 1)).slice(-2);
            var dd = ('0' + today.getDate()).slice(-2);
            return yyyy + '-' + mm + '-' + dd;
        }

        // Mettre la date d'aujourd'hui dans l'input
        $('#dateFilter').val(getTodayDate());

        // Ajouter un filtre personnalisé DataTables qui filtre selon la date sélectionnée
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var selectedDate = $('#dateFilter').val();
            var dateColumn = data[2]; // colonne Date (index 2)

            if (!selectedDate) return true; // pas de filtre si vide
            return dateColumn === selectedDate;
        });

        // Appliquer le filtre au chargement
        table.draw();

        // Mettre à jour le filtre à chaque changement de date
        $('#dateFilter').on('change', function() {
            table.draw();
        });
    });

</script>
</body>
</html>
