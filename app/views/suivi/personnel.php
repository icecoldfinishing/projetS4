<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>titre</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1zbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">

    <!-- modul css -->    
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    .staff-type-btn.active {
      background-color: #4fa8da;
      color: white;
    }
    .staff-item.active {
      border: 2px solid #4fa8da;
      background-color: #e1f0ff;
      cursor: pointer;
    }
    .staff-item {
      cursor: pointer;
      border: 1px solid transparent;
      padding: 0.8rem 1rem;
      border-radius: 5px;
      margin-bottom: 0.5rem;
    }
    .form-actions {
      display: none;
      margin-top: 1rem;
    }
    .form-actions button {
      margin-right: 0.5rem;
    }
  </style>
</head>
<body>
<div id="app">
    <div id="main">
        <?= Flight::menuAdmin() ?>
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
        </header>

        <div class="page-heading">
            <h3>Suivi de Personnel</h3>
        </div>

        <div class="page-content">
            <section class="row">
                <div class="col-12">
                    <div class="card p-3">
                        <!-- Choix type personnel -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                            <button class="btn btn-outline-primary staff-type-btn active" data-type="professeur">
                                <i class="fas fa-chalkboard-teacher me-1"></i> Professeur
                            </button>
                            <button class="btn btn-outline-primary staff-type-btn" data-type="superviseur">
                                <i class="fas fa-user-tie me-1"></i> Superviseur
                            </button>
                            </div>
                            <button class="btn btn-success" onclick="showAddForm()">
                            <i class="fas fa-plus"></i> Ajouter
                            </button>
                        </div>

                        <div class="row">
                            <!-- Liste du personnel -->
                            <div class="col-lg-5 col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 id="staff-list-title">Liste des Professeurs</h5>
                                <span><strong><span id="total-staff">0</span></strong> personnes</span>
                                </div>
                                <div
                                class="card-body overflow-auto"
                                style="max-height: 480px;"
                                id="staff-list-container"
                                >
                                <!-- Les items seront injectés ici -->
                                </div>
                            </div>
                            </div>

                            <!-- Détails + formulaire -->
                            <div class="col-lg-7 col-md-6">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Détails du Personnel</h5>
                                <div>
                                    <button class="btn btn-primary me-2" id="editBtn" onclick="enableEdit()">
                                    <i class="fas fa-edit"></i> Modifier
                                    </button>
                                    <button class="btn btn-danger" id="deleteBtn" onclick="deleteStaff()">
                                    <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </div>
                                </div>
                                <div class="card-body">
                                <form id="staffForm" class="needs-validation" novalidate>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="firstName" class="form-label">Prénom</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" disabled required />
                                        </div>
                                        <div class="col">
                                            <label for="lastName" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" disabled required />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="contact" class="form-label">Contact</label>
                                            <input type="tel" class="form-control" id="contact" name="contact" disabled required />
                                        </div>
                                        <div class="col">
                                            <label for="gender" class="form-label">Sexe</label>
                                            <select class="form-select" id="gender" name="gender" disabled required>
                                                <!-- Options will be populated dynamically -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="dateNaissance" class="form-label">Date de naissance</label>
                                            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" disabled required />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Adresse</label>
                                        <textarea class="form-control" id="address" name="address" rows="3" disabled required></textarea>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="actifSwitch" disabled>
                                        <label class="form-check-label" for="actifSwitch">Actif</label>
                                    </div>

                                    <div class="form-actions d-flex">
                                        <button type="button" class="btn btn-success me-2" onclick="saveStaff()">
                                            <i class="fas fa-save"></i> Sauvegarder
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Modal ajout -->
                        <div
                            class="modal fade"
                            id="addStaffModal"
                            tabindex="-1"
                            aria-labelledby="addStaffModalLabel"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="addStaffModalLabel">Ajouter un nouveau membre du personnel</h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                                </div>
                                <form id="addStaffForm" class="needs-validation" novalidate>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="addFirstName" class="form-label">Prénom</label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="addFirstName"
                                        name="firstName"
                                        required
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="addLastName" class="form-label">Nom</label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="addLastName"
                                        name="lastName"
                                        required
                                        />
                                    </div>
                                    </div>

                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="addContact" class="form-label">Contact</label>
                                        <input
                                        type="tel"
                                        class="form-control"
                                        id="addContact"
                                        name="contact"
                                        required
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="addGender" class="form-label">Sexe</label>
                                        <select class="form-select" id="addGender" name="gender" required>
                                            <!-- Options will be populated dynamically -->
                                        </select>
                                    </div>
                                    </div>

                                    <div class="row mb-3">
                                    <div class="col">
                                        <label for="addDateNaissance" class="form-label">Date de naissance</label>
                                        <input
                                        type="date"
                                        class="form-control"
                                        id="addDateNaissance"
                                        name="dateNaissance"
                                        required
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="addType" class="form-label">Type</label>
                                        <select
                                            class="form-select"
                                            id="addType"
                                            name="type"
                                            required
                                        >
                                            <option value="">Sélectionner</option>
                                            <option value="professeur">Professeur</option>
                                            <option value="superviseur">Superviseur</option>
                                        </select>
                                    </div>
                                    </div>

                                    <div class="mb-3">
                                    <label for="addAddress" class="form-label">Adresse</label>
                                    <textarea
                                        class="form-control"
                                        id="addAddress"
                                        name="address"
                                        rows="3"
                                        required
                                    ></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Ajouter
                                    </button>
                                    <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                    >
                                    Annuler
                                    </button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= Flight::base() ?>/public/vendor/jquery/jquery.js"></script>
<script src="<?= Flight::base() ?>/public/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStaffId = null;
    let isEditing = false;
    let staffData = [];
    let genres = [];

    const staffTypeBtns = document.querySelectorAll(".staff-type-btn");
    const staffListTitle = document.getElementById("staff-list-title");
    const staffListContainer = document.getElementById("staff-list-container");
    const genderSelect = document.getElementById("gender");
    const addGenderSelect = document.getElementById("addGender");

    // Initialize
    enumGender();
    enumStaff('prof');

    // Make functions globally accessible
    window.showAddForm = function() {
        clearForm();
        const addModal = new bootstrap.Modal(document.getElementById('addStaffModal'));
        addModal.show();
        isEditing = false;
        currentStaffId = null;
        enableAddForm();
    }

    window.enableEdit = function() {
        if (!currentStaffId) return;
        isEditing = true;
        enableForm();
        const formActions = document.querySelector('.form-actions');
        if (formActions) formActions.style.display = 'flex';
    }

    window.cancelEdit = function() {
        if (currentStaffId) {
            selectStaff(currentStaffId);
        }
        isEditing = false;
        disableForm();
        const formActions = document.querySelector('.form-actions');
        if (formActions) formActions.style.display = 'none';
    }

    window.deleteStaff = function() {
        if (!currentStaffId) return;

        if (!confirm('Êtes-vous sûr de vouloir supprimer ce membre du personnel ?')) {
            return;
        }

        const staff = staffData.find(s => s.id == currentStaffId);
        if (!staff) return;

        const url = getStaffApiUrl(staff.type, 'delete', currentStaffId);

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success || data.message) {
                alert("Personnel supprimé avec succès");
                enumStaff(staff.type);
                clearForm();
            } else {
                alert("Erreur lors de la suppression");
            }
        })
        .catch(e => {
            console.error('Error deleting staff:', e);
            alert("Erreur lors de la suppression: " + e.message);
        });
    }

    window.saveStaff = function() {
        if (!isEditing || !currentStaffId) return;

        const staff = staffData.find(s => s.id == currentStaffId);
        if (!staff) return;

        const formData = {
            nom: document.getElementById('lastName').value,
            prenom: document.getElementById('firstName').value,
            date_naissance: document.getElementById('dateNaissance').value || null,
            adresse: document.getElementById('address').value,
            contact: document.getElementById('contact').value,
            id_genre: document.getElementById('gender').value,
            actif: document.getElementById('actifSwitch').checked
        };

        const url = getStaffApiUrl(staff.type, 'update', currentStaffId);

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Personnel modifié avec succès");
                enumStaff(staff.type);
                isEditing = false;
                disableForm();
                const formActions = document.querySelector('.form-actions');
                if (formActions) formActions.style.display = 'none';
            } else {
                alert("Erreur lors de la modification");
            }
        })
        .catch(e => {
            console.error('Error updating staff:', e);
            alert("Erreur lors de la mise à jour: " + e.message);
        });
    }

    window.toggleStaffStatus = function(id, isActive) {
        const staff = staffData.find(s => s.id == id);
        if (!staff) return;

        // Convert boolean to string explicitly to avoid backend boolean parsing issues
        const actifValue = isActive ? "1" : "0";

        const formData = {
            nom: staff.nom,
            prenom: staff.prenom,
            date_naissance: staff.date_naissance,
            adresse: staff.adresse,
            contact: staff.contact,
            id_genre: staff.id_genre,
            actif: actifValue  // Send as string "1" or "0" instead of boolean
        };

        const url = getStaffApiUrl(staff.type, 'update', id);

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text(); // Get text first to handle empty responses
        })
        .then(text => {
            let data;
            try {
                data = text ? JSON.parse(text) : {};
            } catch (e) {
                console.error('Response is not valid JSON:', text);
                throw new Error('Invalid JSON response from server');
            }

            if (data.success) {
                enumStaff(staff.type);
            } else {
                alert("Erreur lors de la modification du statut: " + (data.message || 'Erreur inconnue'));
                enumStaff(staff.type);
            }
        })
        .catch(e => {
            console.error('Error toggling staff status:', e);
            alert("Erreur lors de la modification du statut: " + e.message);
            enumStaff(staff.type);
        });
    }

    // Add form submission handler
    const addStaffForm = document.getElementById('addStaffForm');
    if (addStaffForm) {
        addStaffForm.addEventListener('submit', function(e) {
            e.preventDefault();
            addStaff();
        });
    }

    async function enumGender() {
        try {
            const response = await fetch('<?= Flight::base() ?>/api/genres');
            if (!response.ok) throw new Error('Failed to fetch genres');
            genres = await response.json();
            populateGenderSelects();
        } catch (error) {
            console.error('Error fetching genres:', error);
        }
    }

    function populateGenderSelects() {
        const options = genres.map(genre =>
            `<option value="${genre.id_genre}">${genre.label}</option>`
        ).join('');

        if (genderSelect) {
            genderSelect.innerHTML = '<option value="">Sélectionner le genre</option>' + options;
        }
        if (addGenderSelect) {
            addGenderSelect.innerHTML = '<option value="">Sélectionner le genre</option>' + options;
        }
    }

    function getStaffApiUrl(type, action, id = '') {
        const baseUrls = {
            'prof': '<?= Flight::base() ?>/api/prof',
            'professeur': '<?= Flight::base() ?>/api/prof',
            'superviseur': '<?= Flight::base() ?>/api/superviseur'
        };

        const baseUrl = baseUrls[type];
        if (!baseUrl) return '';

        switch (action) {
            case 'list':
                return type === 'prof' || type === 'professeur' ? '<?= Flight::base() ?>/api/profs' : '<?= Flight::base() ?>/api/superviseurs';
            case 'get':
                return `${baseUrl}/${id}`;
            case 'insert':
                return baseUrl;
            case 'update':
                return `${baseUrl}/update/${id}`;
            case 'delete':
                return `${baseUrl}/delete/${id}`;
            default:
                return baseUrl;
        }
    }

    async function enumStaff(type) {
        const url = getStaffApiUrl(type, 'list');
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Failed to fetch ${type} data`);

            const data = await response.json();
            staffData = data.map(staff => ({
                id: staff.id,
                nom: staff.nom,
                prenom: staff.prenom,
                date_naissance: staff.date_naissance,
                adresse: staff.adresse,
                contact: staff.contact,
                id_genre: staff.id_genre,
                actif: staff.actif !== undefined ? staff.actif : true,
                type: type === 'professeur' ? 'prof' : type
            }));

            loadStaffList(type);
        } catch (error) {
            console.error(`Error fetching ${type}:`, error);
            staffData = [];
            loadStaffList(type);
        }
    }

    function loadStaffList(type) {
        const normalizedType = type === 'professeur' ? 'prof' : type;
        const filteredStaff = staffData.filter((s) => s.type === normalizedType);

        const totalStaffEl = document.getElementById('total-staff');
        if (totalStaffEl) {
            totalStaffEl.textContent = filteredStaff.length;
        }

        if (staffListContainer) {
            staffListContainer.innerHTML = "";
            filteredStaff.forEach((staff, index) => {
                const div = document.createElement("div");
                div.className = "staff-item" + (index === 0 ? " active" : "");
                div.dataset.id = staff.id;
                div.dataset.type = staff.type;
                div.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${staff.prenom} ${staff.nom}</h6>
                            <small class="text-muted">${staff.contact || 'Pas de contact'}</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" ${staff.actif ? 'checked' : ''}
                                   onchange="toggleStaffStatus(${staff.id}, this.checked)">
                        </div>
                    </div>
                `;
                div.addEventListener("click", (e) => {
                    if (!e.target.classList.contains('form-check-input')) {
                        selectStaff(staff.id);
                    }
                });
                staffListContainer.appendChild(div);
            });
        }

        if (filteredStaff.length > 0) {
            selectStaff(filteredStaff[0].id);
        } else {
            clearForm();
        }
    }

    function enableAddForm() {
        const addFormFields = ['addFirstName', 'addLastName', 'addDateNaissance', 'addAddress', 'addContact', 'addGender'];
        addFormFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.disabled = false;
            }
        });
    }

    function clearForm() {
        const addFormFields = ['addFirstName', 'addLastName', 'addDateNaissance', 'addAddress', 'addContact', 'addGender'];
        addFormFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.value = '';
            }
        });

        const viewFormFields = ['firstName', 'lastName', 'dateNaissance', 'address', 'contact', 'gender'];
        viewFormFields.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.value = '';
            }
        });

        const activeSwitch = document.getElementById('actifSwitch');
        if (activeSwitch) {
            activeSwitch.checked = false;
        }

        currentStaffId = null;
    }

    function selectStaff(id) {
        currentStaffId = id;
        const staff = staffData.find(s => s.id == id);

        if (!staff) return;

        document.querySelectorAll('.staff-item').forEach(item => item.classList.remove('active'));
        const activeItem = document.querySelector(`[data-id="${id}"]`);
        if (activeItem) activeItem.classList.add('active');

        // Format date properly for input field
        let formattedDate = '';
        if (staff.date_naissance) {
            const date = new Date(staff.date_naissance);
            formattedDate = date.toISOString().split('T')[0]; // Convert to yyyy-MM-dd
        }

        const viewFields = {
            firstName: staff.prenom || '',
            lastName: staff.nom || '',
            dateNaissance: formattedDate,
            address: staff.adresse || '',
            contact: staff.contact || '',
            gender: staff.id_genre || '',
            actifSwitch: staff.actif !== false
        };

        Object.entries(viewFields).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                if (element.type === 'checkbox') {
                    element.checked = value;
                } else {
                    element.value = value;
                }
            }
        });

        disableForm();
        isEditing = false;
        const formActions = document.querySelector('.form-actions');
        if (formActions) formActions.style.display = 'none';
    }

    function enableForm() {
        const inputs = ['firstName', 'lastName', 'dateNaissance', 'address', 'contact', 'gender', 'actifSwitch'];
        inputs.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.disabled = false;
            }
        });
    }

    function disableForm() {
        const inputs = ['firstName', 'lastName', 'dateNaissance', 'address', 'contact', 'gender', 'actifSwitch'];
        inputs.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.disabled = true;
            }
        });
    }

    function addStaff() {
        const currentType = getCurrentStaffType();

        const formData = {
            nom: document.getElementById('addLastName').value.trim(),
            prenom: document.getElementById('addFirstName').value.trim(),
            date_naissance: document.getElementById('addDateNaissance').value || null,
            adresse: document.getElementById('addAddress').value.trim(),
            contact: document.getElementById('addContact').value.trim(),
            id_genre: parseInt(document.getElementById('addGender').value)
        };

        // Validation
        if (!formData.nom || !formData.prenom) {
            alert("Le nom et le prénom sont obligatoires");
            return;
        }

        if (!formData.id_genre) {
            alert("Veuillez sélectionner un genre");
            return;
        }

        const url = getStaffApiUrl(currentType, 'insert');

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Personnel ajouté avec succès");
                const modalElement = document.getElementById('addStaffModal');
                if (modalElement) {
                    // Use the older method compatible with Bootstrap 5.3.0
                    const modal = new bootstrap.Modal(modalElement);
                    modal.hide();
                }
                clearForm();
                enumStaff(currentType);
            } else {
                alert("Erreur lors de l'ajout: " + (data.message || 'Erreur inconnue'));
            }
        })
        .catch(e => {
            console.error('Error adding staff:', e);
            alert("Erreur lors de l'ajout: " + e.message);
        });
    }

    function getCurrentStaffType() {
        const activeBtn = document.querySelector('.staff-type-btn.active');
        return activeBtn ? activeBtn.dataset.type : 'prof';
    }

    staffTypeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.dataset.type;

            staffTypeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            if (staffListTitle) {
                staffListTitle.textContent = type === 'professeur' ? 'Liste des Professeurs' : 'Liste des Superviseurs';
            }

            enumStaff(type);
            clearForm();
        });
    });
});
</script>
</html>
