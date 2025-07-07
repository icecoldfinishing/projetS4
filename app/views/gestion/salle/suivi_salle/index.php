<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>titre</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">

    <!-- modul css -->    
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
</head>
<body>
    <div id="app">
        <?= Flight::menuAdmin() ?>
        <div id="main">
            <div class="container mt-4">
                <h2>Suivi du Matériel en Salle</h2>

                <form method="POST" action="<?= Flight::base() ?>/suivi-salle/add" class="row g-3 mt-4">
                    <div class="col-md-3">
                        <label>Superviseur</label>
                        <select name="id_superviseur" class="form-select" required>
                            <?php foreach ($superviseurs as $s): ?>
                                <option value="<?= $s['id_superviseur'] ?>"><?= htmlspecialchars($s['nom'] . ' ' . $s['prenom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Associer à un club ?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="has_club" id="club_yes" value="yes" onclick="toggleClub(true)">
                            <label class="form-check-label" for="club_yes">Oui</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="has_club" id="club_no" value="no" checked onclick="toggleClub(false)">
                            <label class="form-check-label" for="club_no">Non</label>
                        </div>

                        <div id="club_select" class="mt-2" style="display: none;">
                            <select name="id_club" class="form-select">
                                <option value="">-- Sélectionner un club --</option>
                                <?php foreach ($clubs as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nom_responsable']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <label>Matériel</label>
                        <div class="input-group">
                            <input type="hidden" name="id_item" id="id_item" required>
                            <input type="text" id="materiel_display" class="form-control" placeholder="Sélectionner un matériel" readonly>
                            <button type="button" class="btn btn-outline-secondary" onclick="openPopup()">...</button>
                        </div>
                    </div>

                    <div id="materielPopup" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%);
                background:#fff; padding:20px; border:1px solid #ccc; z-index:9999; width:400px; max-height:400px; overflow:auto; box-shadow:0 4px 10px rgba(0,0,0,0.3);">

                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <label>Type</label>
                            <select id="filter_type" class="form-select" style="width:200px">
                                <option value="">Tous</option>
                                <?php foreach ($types as $t): ?>
                                    <option value="<?= $t['id_type'] ?>"><?= htmlspecialchars($t['label']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <input type="text" id="popup_search" class="form-control mb-3" placeholder="Rechercher...">

                        <ul id="popup_list" class="list-group">
                            <?php foreach ($materiels as $m): ?>
                                <li class="list-group-item popup-item"
                                    data-id="<?= $m['id_item'] ?>"
                                    data-type="<?= $m['id_type'] ?>"
                                    data-num="<?= htmlspecialchars($m['num_serie']) ?>"
                                    onclick="selectMateriel(this)">
                                    <?= htmlspecialchars($m['num_serie']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <button class="btn btn-sm btn-secondary mt-3" onclick="closePopup()">Fermer</button>
                    </div>


                    <div class="col-md-3">
                        <label>État</label>
                        <select name="etat" class="form-select">
                            <option value="disponible">Disponible</option>
                            <option value="endommage">Endommagé</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button class="btn btn-primary" type="submit">Ajouter</button>
                    </div>
                </form>


                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Superviseur</th>
                        <th>Club</th>
                        <th>Matériel</th>
                        <th>État</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($suivis as $s): ?>
                        <tr>
                            <td><?=  (new DateTime($s['date']))->format('Y-m-d H:i:s') ?></td>
                            <td><?= $s['superviseur_nom'] ?> <?= $s['superviseur_prenom'] ?></td>
                            <td><?= $s['nom_club'] ?? 'N/A' ?></td>
                            <td><?= $s['num_serie'] ?></td>
                            <td><?= $s['etat'] ?></td>
                            <td><?= $s['description'] ?></td>
                            <td>
            <!--                    <a href="/suivi-salle/delete/--><?php //= $s['id_suivi_salle'] ?><!--" class="btn btn-sm btn-danger">Supprimer</a>-->
                                <?php if ($s['etat'] === 'endommage'): ?>
                                    <?php if (empty($s['facture'])): ?>
                                        <a href="<?= Flight::base() ?>/facturation/creer/<?= $s['id_suivi_salle'] ?>" class="btn btn-sm btn-warning">Faire une facturation</a>
                                    <?php else: ?>
                                        <span class="badge bg-success">Facture envoyée</span>
                                        <a href="<?= Flight::base() ?>/facturation/pdf/<?= $s['id_suivi_salle'] ?>" class="btn btn-sm btn-info">Voir PDF</a>
                                    <?php endif; ?>
                                <?php endif; ?>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="<?= Flight::base() ?>/facturation/liste" class="btn btn-outline-dark float-end mb-3">📄 Suivi des factures</a>

            </div>
        </div>
    </div>
    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
    <script>
        function openPopup() {
            document.getElementById('materielPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('materielPopup').style.display = 'none';
        }

        function selectMateriel(el) {
            const id = el.dataset.id;
            const num = el.dataset.num;
            document.getElementById('id_item').value = id;
            document.getElementById('materiel_display').value = num;
            closePopup();
        }

        document.getElementById('popup_search').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('#popup_list .popup-item').forEach(item => {
                const match = item.textContent.toLowerCase().includes(query);
                item.style.display = match ? 'block' : 'none';
            });
        });

        document.getElementById('filter_type').addEventListener('change', function () {
            const typeId = this.value;
            document.querySelectorAll('#popup_list .popup-item').forEach(item => {
                const show = typeId === '' || item.dataset.type === typeId;
                item.style.display = show ? 'block' : 'none';
            });
        });
        function toggleClub(show) {
            const select = document.getElementById('club_select');
            const selectInput = select.querySelector('select');
            if (show) {
                select.style.display = 'block';
                selectInput.required = true;
            } else {
                select.style.display = 'none';
                selectInput.required = false;
                selectInput.value = ''; // vide pour forcer NULL côté serveur
            }
        }
    </script>
</body>
</html>