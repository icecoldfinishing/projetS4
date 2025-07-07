<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Finances</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">

    <!-- modul css -->    
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
    <script>
        window.BASE_URL = '<?= Flight::base() ?>';
    </script>
    <script src="<?= Flight::base() ?>/public/js/finance/sortie.js"></script>
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
                <h3>Gestion des finances</h3>
            </div>
            
            <div class="page-content">
                <!-- Boutons de navigation -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center gap-3">
                                    <button type="button" class="btn btn-danger btn-lg" id="btnSortie">
                                        <i class="bi bi-box-arrow-up"></i>
                                        Sortie
                                    </button>
                                    <button type="button" class="btn btn-success btn-lg" id="btnPaiement">
                                        <i class="bi bi-credit-card"></i>
                                        Paiement
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg" id="btnSalaire">
                                        <i class="bi bi-cash-stack"></i>
                                        Salaire
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Sortie -->
                <div class="row" id="sectionSortie">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Gestion des Sorties d'Argent</h4>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary btn-sm" id="btnNouvelleDepense">
                                            <i class="bi bi-plus"></i> Nouvelle Dépense
                                        </button>
                                        <select class="form-select form-select-sm" id="filterCategorie" style="width: auto;">
                                            <option value="">Toutes catégories</option>
                                            <!-- Options chargées dynamiquement -->
                                        </select>
                                        <select class="form-select form-select-sm" id="filterStatut" style="width: auto;">
                                            <option value="">Tous statuts</option>
                                            <!-- Options chargées dynamiquement -->
                                        </select>
                                        <input type="text" class="form-control form-control-sm" id="searchSortie" placeholder="Recherche..." style="width: 200px;">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Statistiques rapides -->
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-primary" id="totalDepenses">0 AR</h5>
                                                    <small class="text-muted">Total Dépenses</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-warning" id="enAttenteCount">0</h5>
                                                    <small class="text-muted">En Attente</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-success" id="valideCount">0</h5>
                                                    <small class="text-muted">Validées</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-danger" id="refuseCount">0</h5>
                                                    <small class="text-muted">Refusées</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Table des sorties -->
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="tableSorties">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Motif</th>
                                                    <th>Catégorie</th>
                                                    <th>Montant</th>
                                                    <th>Mode Paiement</th>
                                                    <th>Statut</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listeSorties">
                                                <!-- Chargement dynamique via JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <nav aria-label="Pagination sorties">
                                        <ul class="pagination pagination-sm justify-content-center" id="paginationSorties">
                                            <!-- Pagination générée dynamiquement -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Nouvelle Dépense -->
                    <div class="modal fade" id="modalNouvelleDepense" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Nouvelle Dépense</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formNouvelleDepense">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="depenseCategorie" class="form-label">Catégorie</label>
                                                    <select class="form-select" id="depenseCategorie" required>
                                                        <option value="">Sélectionner une catégorie</option>
                                                        <!-- Options chargées dynamiquement -->
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="depenseMotif" class="form-label">Motif</label>
                                                    <input type="text" class="form-control" id="depenseMotif" required placeholder="Saisir le motif de la dépense">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="depenseMontant" class="form-label">Montant (AR)</label>
                                                    <input type="number" class="form-control" id="depenseMontant" required min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="depenseModePaiement" class="form-label">Mode de Paiement</label>
                                                    <select class="form-select" id="depenseModePaiement" required>
                                                        <option value="">Sélectionner un mode</option>
                                                        <!-- Options chargées dynamiquement -->
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="depenseDescription" class="form-label">Description</label>
                                                    <textarea class="form-control" id="depenseDescription" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="button" class="btn btn-primary" id="btnSauvegarderDepense">Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Détails Dépense (manquant) -->
                <div class="modal fade" id="modalDetailsDepense" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Détails de la Dépense</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="detailsDepenseContent">
                                <!-- Contenu chargé dynamiquement -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row" id="sectionPaiement" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Gestion des Paiements</h4>
                                <div class="d-flex">
                                    <input type="text" class="form-control" id="searchPaiement" placeholder="Rechercher une réservation...">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <form id="formPaiement">
                                            <div class="mb-3">
                                                <label for="reservationPaiement" class="form-label">Réservation</label>
                                                <select class="form-select" id="reservationPaiement" required>
                                                    <option value="">Sélectionner une réservation</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="montantPaiement" class="form-label">Montant (AR)</label>
                                                <input type="number" class="form-control" id="montantPaiement" step="0.01" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="datePaiement" class="form-label">Date de paiement</label>
                                                <input type="datetime-local" class="form-control" id="datePaiement">
                                            </div>
                                            <div class="mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6>Détails de la réservation</h6>
                                                        <div id="reservationDetails">
                                                            <p class="text-muted">Sélectionnez une réservation pour voir les détails</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary flex-grow-1">
                                                    <i class="bi bi-check-circle"></i> Enregistrer Paiement
                                                </button>
                                                <button type="reset" class="btn btn-secondary flex-grow-1">
                                                    <i class="bi bi-x-circle"></i> Annuler
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5>Liste des réservations et paiements</h5>
                                            <button class="btn btn-outline-primary btn-sm" id="btnRefreshPaiements">
                                                <i class="bi bi-arrow-clockwise"></i> Actualiser
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Réservation</th>
                                                    <th>Club/Groupe</th>
                                                    <th>Date & Heure</th>
                                                    <th>Montant</th>
                                                    <th>Statut</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tablePaiements">
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="visually-hidden">Chargement...</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="sectionSalaire" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Gestion des Salaires</h4>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm" id="btnConfigSalaires">
                                        <i class="bi bi-gear"></i> Configuration
                                    </button>
                                    <input type="text" class="form-control" id="searchPersonnel" placeholder="Recherche personnel...">
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Configuration des salaires (masquée par défaut) -->
                                <div class="row mb-4" id="configSalaires" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="card border-info">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Configuration des salaires par type</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Salaire Professeur</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="salaireProf" value="450000">
                                                            <span class="input-group-text">AR</span>
                                                            <button class="btn btn-outline-primary" onclick="modifierSalaireType('prof')">
                                                                <i class="bi bi-save"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Salaire Superviseur</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="salaireSuperviseur" value="500000">
                                                            <span class="input-group-text">AR</span>
                                                            <button class="btn btn-outline-primary" onclick="modifierSalaireType('superviseur')">
                                                                <i class="bi bi-save"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Liste du personnel (Gauche) -->
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5>Liste du personnel</h5>
                                            <button class="btn btn-sm btn-outline-primary" id="btnRefreshEmployes">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </div>
                                        <div class="list-group" id="listePersonnel">
                                            <!-- Chargement dynamique via JavaScript -->
                                        </div>
                                    </div>

                                    <!-- Détails et paiement -->
                                    <div class="col-md-8">
                                        <!-- Message quand aucun employé sélectionné -->
                                        <div id="noEmployeSelected" class="text-center text-muted py-5">
                                            <i class="bi bi-person-plus fs-1"></i>
                                            <h5>Sélectionnez un employé</h5>
                                            <p>Choisissez un employé dans la liste pour gérer son salaire</p>
                                        </div>

                                        <!-- Détails de l'employé -->
                                        <div id="detailsEmploye" style="display: none;">
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h5 class="mb-0" id="nomEmploye"></h5>
                                                    <small class="text-muted" id="typeEmploye"></small>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>ID:</strong> <span id="idEmploye"></span></p>
                                                            <p><strong>Date d'embauche:</strong> <span id="dateEmbauche"></span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Salaire mensuel:</strong> <span id="salaireMensuel"></span></p>
                                                            <p><strong>Dernier paiement:</strong> <span id="dernierPaiement"></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Formulaire de paiement -->
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h6>Nouveau paiement</h6>
                                                </div>
                                                <div class="card-body">
                                                    <form id="formSalaire">
                                                        <input type="hidden" id="currentEmployeId">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="salaireMois" class="form-label">Mois à payer</label>
                                                                    <select class="form-select" id="salaireMois" required>
                                                                        <!-- Options générées dynamiquement -->
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="salaireMontant" class="form-label">Montant (AR)</label>
                                                                    <input type="number" class="form-control" id="salaireMontant" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="modePaiement" class="form-label">Mode de paiement</label>
                                                                    <select class="form-select" id="modePaiement" required>
                                                                        <option value="espece">Espèce</option>
                                                                        <option value="virement">Virement</option>
                                                                        <option value="cheque">Chèque</option>
                                                                        <option value="mobile_money">Mobile Money</option>
                                                                        <option value="carte">Carte</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="remarquesPaiement" class="form-label">Remarques</label>
                                                                    <textarea class="form-control" id="remarquesPaiement" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-grid">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="bi bi-cash-stack"></i> Enregistrer le paiement
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Historique des paiements -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6>Historique des paiements</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Période</th>
                                                                <th>Montant</th>
                                                                <th>Mode</th>
                                                                <th>Remarques</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="historiquePaiements">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>

    <script>
        // Gestion des paiements
        document.addEventListener('DOMContentLoaded', function() {
            let reservations = [];

            // Charger les réservations
            function loadReservations() {
                fetch('<?= Flight::base() ?>/api/reservations')
                    .then(response => response.json())
                    .then(data => {
                        reservations = data;
                        updateReservationSelect();
                        updatePaiementsTable();
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Mettre à jour le select des réservations
            function updateReservationSelect() {
                const select = document.getElementById('reservationPaiement');
                select.innerHTML = '<option value="">Sélectionner une réservation</option>';

                reservations.filter(r => !r.est_paye).forEach(reservation => {
                    const option = document.createElement('option');
                    option.value = reservation.id_reservation;
                    option.textContent = `#${reservation.id_reservation} - ${reservation.club_nom} (${reservation.date_reserve})`;
                    select.appendChild(option);
                });
            }

            // Mettre à jour le tableau des paiements
            function updatePaiementsTable() {
                const tbody = document.getElementById('tablePaiements');
                tbody.innerHTML = '';

                reservations.forEach(reservation => {
                    const row = document.createElement('tr');
                    const montant = reservation.montant_paye || reservation.montant_calcule || 0;
                    const statut = getStatutBadge(reservation);

                    row.innerHTML = `
                <td>#${reservation.id_reservation}</td>
                <td>${reservation.club_nom}</td>
                <td>${formatDateTime(reservation.date_reserve, reservation.heure_debut, reservation.heure_fin)}</td>
                <td>${formatMontant(montant)}</td>
                <td>${statut}</td>
                <td>
                    ${reservation.est_paye ?
                        `<button class="btn btn-sm btn-outline-danger" onclick="supprimerPaiement(${reservation.id_reservation})">
                            <i class="bi bi-trash"></i>
                        </button>` :
                        `<button class="btn btn-sm btn-outline-primary" onclick="selectionnerReservation(${reservation.id_reservation})">
                            <i class="bi bi-credit-card"></i> Payer
                        </button>`
                    }
                </td>
            `;
                    tbody.appendChild(row);
                });
            }

            // Sélectionner une réservation pour paiement
            window.selectionnerReservation = function(id_reservation) {
                const reservation = reservations.find(r => r.id_reservation == id_reservation);
                if (reservation) {
                    document.getElementById('reservationPaiement').value = id_reservation;
                    document.getElementById('montantPaiement').value = reservation.montant_calcule || 0;
                    showReservationDetails(reservation);
                }
            };

            // Afficher les détails de la réservation
            function showReservationDetails(reservation) {
                const detailsDiv = document.getElementById('reservationDetails');
                detailsDiv.innerHTML = `
            <p><strong>Club:</strong> ${reservation.club_nom}</p>
            <p><strong>Date:</strong> ${reservation.date_reserve}</p>
            <p><strong>Horaire:</strong> ${reservation.heure_debut} - ${reservation.heure_fin}</p>
            <p><strong>Discipline:</strong> ${reservation.discipline}</p>
            <p><strong>Montant calculé:</strong> ${formatMontant(reservation.montant_calcule || 0)}</p>
        `;
            }

            // Gestionnaire de changement de réservation
            document.getElementById('reservationPaiement').addEventListener('change', function() {
                const id_reservation = this.value;
                if (id_reservation) {
                    fetch(`<?= Flight::base() ?>/api/reservations/${id_reservation}`)
                        .then(response => response.json())
                        .then(reservation => {
                            document.getElementById('montantPaiement').value = reservation.montant_calcule || 0;
                            showReservationDetails(reservation);
                        })
                        .catch(error => console.error('Erreur:', error));
                } else {
                    document.getElementById('reservationDetails').innerHTML =
                        '<p class="text-muted">Sélectionnez une réservation pour voir les détails</p>';
                }
            });

            // Soumettre le formulaire de paiement
            document.getElementById('formPaiement').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    id_reservation: document.getElementById('reservationPaiement').value,
                    montant: document.getElementById('montantPaiement').value,
                    date_paiement: document.getElementById('datePaiement').value
                };

                fetch('<?= Flight::base() ?>/api/paiements', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Paiement enregistré avec succès!');
                            this.reset();
                            document.getElementById('reservationDetails').innerHTML =
                                '<p class="text-muted">Sélectionnez une réservation pour voir les détails</p>';
                            loadReservations();
                        } else {
                            alert('Erreur: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de l\'enregistrement du paiement');
                    });
            });

            // Supprimer un paiement
            window.supprimerPaiement = function(id_reservation) {
                if (confirm('Êtes-vous sûr de vouloir supprimer ce paiement?')) {
                    fetch(`<?= Flight::base() ?>/api/paiements/${id_reservation}`, {
                        method: 'DELETE'
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Paiement supprimé avec succès!');
                                loadReservations();
                            } else {
                                alert('Erreur: ' + data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert('Erreur lors de la suppression du paiement');
                        });
                }
            };

            // Fonctions utilitaires
            function getStatutBadge(reservation) {
                if (reservation.est_paye) {
                    return '<span class="badge bg-success">Payé</span>';
                }

                switch (reservation.statut_reservation) {
                    case 'demande':
                        return '<span class="badge bg-warning">En attente</span>';
                    case 'confirme':
                        return '<span class="badge bg-info">Confirmé</span>';
                    case 'annule':
                        return '<span class="badge bg-danger">Annulé</span>';
                    default:
                        return '<span class="badge bg-secondary">Inconnu</span>';
                }
            }

            function formatDateTime(date, heureDebut, heureFin) {
                return `${date}<br><small>${heureDebut} - ${heureFin}</small>`;
            }

            function formatMontant(montant) {
                return new Intl.NumberFormat('fr-FR').format(montant) + ' AR';
            }

            // Recherche
            document.getElementById('searchPaiement').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tablePaiements tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Actualiser
            document.getElementById('btnRefreshPaiements').addEventListener('click', loadReservations);

            // Initialiser
            loadReservations();
        });
    </script>
    <script>
        // Nouvelles fonctions JavaScript
        function modifierSalaireType(type) {
            const inputId = type === 'prof' ? 'salaireProf' : 'salaireSuperviseur';
            const montant = document.getElementById(inputId).value;

            fetch('<?= Flight::base() ?>/api/salaires/config', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    type_employe: type,
                    nouveau_montant: montant
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Salaire modifié avec succès');
                        loadEmployes(); // Recharger la liste
                    } else {
                        alert('Erreur: ' + data.error);
                    }
                });
        }

        // Afficher/masquer la configuration
        document.getElementById('btnConfigSalaires').addEventListener('click', function() {
            const config = document.getElementById('configSalaires');
            config.style.display = config.style.display === 'none' ? 'block' : 'none';
        });
    </script>
    <script>
        // Gestion des salaires
        document.addEventListener('DOMContentLoaded', function() {
            loadSalairesConfig();
            let employes = [];
            let employeSelectionne = null;

            // Charger la liste des employés
            function loadEmployes() {
                fetch('<?= Flight::base() ?>/api/employes')
                    .then(response => response.json())
                    .then(data => {
                        employes = data;
                        updateEmployesList();
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Mettre à jour la liste des employés
            function updateEmployesList() {
                const liste = document.getElementById('listePersonnel');
                liste.innerHTML = '';

                employes.forEach((employe, index) => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.className = 'list-group-item list-group-item-action';
                    item.dataset.employeId = employe.id_employe;

                    item.innerHTML = `
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">${employe.nom} ${employe.prenom}</h6>
                                        <small class="text-muted">${employe.type_employe}</small>
                                    </div>
                                    <div class="text-end">
                                        <small class="fw-bold">${formatMontant(employe.montant_mensuel || 0)}</small>
                                    </div>
                                </div>
                            `;

                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectionnerEmploye(employe.id_employe);
                    });

                    liste.appendChild(item);
                });
            }

            // Sélectionner un employé
            function selectionnerEmploye(id_employe) {
                // Mettre à jour l'apparence de la liste
                document.querySelectorAll('#listePersonnel .list-group-item').forEach(item => {
                    item.classList.remove('active');
                });
                document.querySelector(`[data-employe-id="${id_employe}"]`).classList.add('active');

                // Charger les détails de l'employé
                fetch(`<?= Flight::base() ?>/api/employes/${id_employe}`)
                    .then(response => response.json())
                    .then(data => {
                        employeSelectionne = data.employe;
                        afficherDetailsEmploye(data.employe, data.historique);
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            // Afficher les détails de l'employé
            function afficherDetailsEmploye(employe, historique) {
                document.getElementById('noEmployeSelected').style.display = 'none';
                document.getElementById('detailsEmploye').style.display = 'block';

                // Informations de base
                document.getElementById('nomEmploye').textContent = `${employe.nom} ${employe.prenom}`;
                document.getElementById('typeEmploye').textContent = `Profession: ${capitalizeFirst(employe.type_employe)}`;
                document.getElementById('idEmploye').textContent = `E-${employe.id_employe.toString().padStart(3, '0')}`;
                document.getElementById('dateEmbauche').textContent = formatDate(employe.date_embauche);
                document.getElementById('salaireMensuel').textContent = formatMontant(employe.montant_mensuel || 0);
                document.getElementById('dernierPaiement').textContent = employe.dernier_paiement ?
                    formatDate(employe.dernier_paiement) : 'Aucun';

                // Formulaire
                document.getElementById('currentEmployeId').value = employe.id_employe;
                document.getElementById('salaireMontant').value = employe.montant_mensuel || 0;

                // Générer les options de mois
                generateMoisOptions();

                // Historique des paiements
                updateHistoriquePaiements(historique);
            }

            // Générer les options de mois
            function generateMoisOptions() {
                const select = document.getElementById('salaireMois');
                select.innerHTML = '';

                const moisNoms = [
                    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ];

                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;

                // Ajouter les 3 prochains mois à partir du mois courant
                for (let i = 0; i < 6; i++) {
                    let month = currentMonth + i;
                    let year = currentYear;

                    if (month > 12) {
                        month -= 12;
                        year += 1;
                    }

                    const option = document.createElement('option');
                    option.value = `${month}-${year}`;
                    option.textContent = `${moisNoms[month - 1]} ${year}`;

                    if (i === 0) option.selected = true; // Sélectionner le mois courant par défaut

                    select.appendChild(option);
                }
            }

            // Mettre à jour l'historique des paiements
            function updateHistoriquePaiements(historique) {
                const tbody = document.getElementById('historiquePaiements');
                tbody.innerHTML = '';

                if (!historique || historique.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Aucun paiement enregistré</td></tr>';
                    return;
                }

                historique.forEach(paiement => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                                <td>${formatDate(paiement.date_paiement)}</td>
                                <td>${getMoisNom(paiement.mois_a_payer)} ${paiement.annee_a_payer}</td>
                                <td>${formatMontant(paiement.montant)}</td>
                                <td><span class="badge bg-info">${capitalizeFirst(paiement.mode_paiement)}</span></td>
                                <td>${paiement.remarques || '-'}</td>
                            `;
                    tbody.appendChild(row);
                });
            }// Charger les configurations de salaires au chargement de la page
            function loadSalairesConfig() {
                fetch('<?= Flight::base() ?>/api/salaires/config')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(config => {
                            if (config.type_employe === 'prof') {
                                document.getElementById('salaireProf').value = config.montant_mensuel;
                            } else if (config.type_employe === 'superviseur') {
                                document.getElementById('salaireSuperviseur').value = config.montant_mensuel;
                            }
                        });
                    })
                    .catch(error => console.error('Erreur lors du chargement des configurations:', error));
            }

            // Modifier la fonction modifierSalaireType
            function modifierSalaireType(type) {
                const inputId = type === 'prof' ? 'salaireProf' : 'salaireSuperviseur';
                const montant = document.getElementById(inputId).value;

                fetch('<?= Flight::base() ?>/api/salaires/config', {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        type_employe: type,
                        nouveau_montant: montant
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Salaire modifié avec succès');
                            loadSalairesConfig(); // Recharger les configurations
                            if (typeof loadEmployes === 'function') {
                                loadEmployes(); // Recharger la liste des employés si disponible
                            }
                        } else {
                            alert('Erreur: ' + data.error);
                        }
                    });
            }

            // Soumettre le formulaire de paiement
            document.getElementById('formSalaire').addEventListener('submit', function(e) {
                e.preventDefault();

                const [mois, annee] = document.getElementById('salaireMois').value.split('-');

                const formData = {
                    id_employe: document.getElementById('currentEmployeId').value,
                    montant: document.getElementById('salaireMontant').value,
                    mois: parseInt(mois),
                    annee: parseInt(annee),
                    mode_paiement: document.getElementById('modePaiement').value,
                    remarques: document.getElementById('remarquesPaiement').value
                };

                fetch('<?= Flight::base() ?>/api/salaires/payer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Salaire payé avec succès!');
                            document.getElementById('remarquesPaiement').value = '';
                            // Recharger les détails pour mettre à jour l'historique
                            selectionnerEmploye(employeSelectionne.id_employe);
                        } else {
                            alert('Erreur: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors du paiement du salaire');
                    });
            });

            // Recherche d'employés
            document.getElementById('searchPersonnel').addEventListener('input', function() {
                const terme = this.value.toLowerCase();

                if (terme.length === 0) {
                    updateEmployesList();
                    return;
                }

                if (terme.length < 2) return;

                const employesFiltres = employes.filter(employe =>
                    employe.nom.toLowerCase().includes(terme) ||
                    employe.prenom.toLowerCase().includes(terme) ||
                    employe.contact?.toLowerCase().includes(terme)
                );

                const liste = document.getElementById('listePersonnel');
                liste.innerHTML = '';

                employesFiltres.forEach(employe => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.className = 'list-group-item list-group-item-action';
                    item.dataset.employeId = employe.id_employe;

                    item.innerHTML = `
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">${employe.nom} ${employe.prenom}</h6>
                                        <small class="text-muted">${employe.type_employe}</small>
                                    </div>
                                    <div class="text-end">
                                        <small class="fw-bold">${formatMontant(employe.montant_mensuel || 0)}</small>
                                    </div>
                                </div>
                            `;

                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectionnerEmploye(employe.id_employe);
                    });

                    liste.appendChild(item);
                });
            });

            // Actualiser la liste
            document.getElementById('btnRefreshEmployes').addEventListener('click', loadEmployes);

            // Fonctions utilitaires
            function formatMontant(montant) {
                return new Intl.NumberFormat('fr-FR').format(montant) + ' AR';
            }

            function formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('fr-FR');
            }

            function capitalizeFirst(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            function getMoisNom(numeroMois) {
                const mois = [
                    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ];
                return mois[numeroMois - 1] || '';
            }

            // Initialiser
            loadEmployes();
        });
    </script>
    <!-- Script pour la navigation entre les sections -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSortie = document.getElementById('btnSortie');
            const btnPaiement = document.getElementById('btnPaiement');
            const btnSalaire = document.getElementById('btnSalaire');
            
            const sectionSortie = document.getElementById('sectionSortie');
            const sectionPaiement = document.getElementById('sectionPaiement');
            const sectionSalaire = document.getElementById('sectionSalaire');
            
            // Afficher la section Sortie par défaut
            sectionSortie.style.display = 'flex';
            
            btnSortie.addEventListener('click', function() {
                sectionSortie.style.display = 'flex';
                sectionPaiement.style.display = 'none';
                sectionSalaire.style.display = 'none';
                
                btnSortie.classList.add('active');
                btnPaiement.classList.remove('active');
                btnSalaire.classList.remove('active');
            });
            
            btnPaiement.addEventListener('click', function() {
                sectionSortie.style.display = 'none';
                sectionPaiement.style.display = 'flex';
                sectionSalaire.style.display = 'none';
                
                btnSortie.classList.remove('active');
                btnPaiement.classList.add('active');
                btnSalaire.classList.remove('active');
            });
            
            btnSalaire.addEventListener('click', function() {
                sectionSortie.style.display = 'none';
                sectionPaiement.style.display = 'none';
                sectionSalaire.style.display = 'flex';
                
                btnSortie.classList.remove('active');
                btnPaiement.classList.remove('active');
                btnSalaire.classList.add('active');
            });
        });
    </script>

</body>
</html>