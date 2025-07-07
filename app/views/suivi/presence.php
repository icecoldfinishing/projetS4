<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Suivi de présence</title>
  <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
  <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css" />
  <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    .user-type-btn.active {
      background-color: var(--bs-primary) !important;
      color: #fff !important;
      border-color: var(--bs-primary) !important;
    }

    .user-type-btn {
      margin-right: 0.5rem;
    }

    .person-item.active {
      border: 2px solid var(--bs-primary);
      background-color: #e9f1ff;
    }

    .card-body .form-label {
      font-weight: 500;
    }

    .card .card-header h5 {
      margin-bottom: 0;
    }
  </style>
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
        <h3>Suivi de Présence</h3>
      </div>

      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                  <button class="btn btn-outline-primary user-type-btn active" data-type="eleve">
                    <i class="fas fa-user-graduate me-1"></i> Élève
                  </button>
                  <button class="btn btn-outline-primary user-type-btn" data-type="professeur">
                    <i class="fas fa-chalkboard-teacher me-1"></i> Prof
                  </button>
                  <button class="btn btn-outline-primary user-type-btn" data-type="superviseur">
                    <i class="fas fa-user-tie me-1"></i> Superviseur
                  </button>
                </div>
              </div>

              <div class="card-body">
                <div class="row mb-4">
                  <div class="col-md-3">
                    <label for="date-debut" class="form-label">Date début</label>
                    <input type="date" id="date-debut" class="form-control" value="2025-06-01" />
                  </div>
                  <div class="col-md-3">
                    <label for="date-fin" class="form-label">Date fin</label>
                    <input type="date" id="date-fin" class="form-control" value="2025-06-24" />
                  </div>
                  <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-success w-100">
                      <i class="fas fa-search me-1"></i> Appliquer
                    </button>
                  </div>
                </div>

                <div class="row g-4">
                  <div class="col-lg-8">
                    <div class="card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 id="list-title">Liste des Élèves</h5>
                        <div class="text-success fw-bold">
                          <span id="total-people">4</span> personnes
                        </div>
                      </div>
                      <div class="card-body" style="max-height: 450px; overflow-y: auto">
                        <div class="table-responsive">
                          <table class="table table-hover" id="table1">
                            <thead>
                              <tr>
                                <th>nom</th>
                                <th>nombre d'absences</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Patrick</td>
                                <td>5</td>
                              </tr>
                              <tr>
                                <td>Dylan</td>
                                <td>5</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-header">
                        <h5>Détails de présence</h5>
                        <div class="text-primary fw-bold selected-person-name">Marie Dubois</div>
                      </div>
                      <div class="card-body details-content">
                        <!-- Élève -->
                        <div class="detail-section eleve-details">
                          <div class="mb-3">
                            <h6><i class="fas fa-calendar-times me-2"></i>Jours d'absence</h6>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">15 Juin 2025</li>
                              <li class="list-group-item">18 Juin 2025</li>
                            </ul>
                          </div>
                          <div class="mb-3">
                            <h6><i class="fas fa-fist-raised me-2"></i>Cours ratés</h6>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item">Self Defense - 15/06</li>
                              <li class="list-group-item">Judo - 18/06</li>
                            </ul>
                          </div>
                        </div>

                        <div class="detail-section professeur-details d-none">Détails professeur...</div>
                        <div class="detail-section superviseur-details d-none">Détails superviseur...</div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
  <script src="<?= Flight::base() ?>/public/assets/extensions/jquery/jquery.min.js"></script>
  <script src="<?= Flight::base() ?>/public/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= Flight::base() ?>/public/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="<?= Flight::base() ?>/public/assets/static/js/pages/datatables.js"></script>

  <script>
    const userTypeBtns = document.querySelectorAll('.user-type-btn');
    const listTitle = document.getElementById('list-title');
    const detailSections = document.querySelectorAll('.detail-section');

    userTypeBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        userTypeBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const type = btn.dataset.type;
        detailSections.forEach(sec => sec.classList.add('d-none'));
        const active = document.querySelector(`.${type}-details`);
        if (active) active.classList.remove('d-none');

        switch (type) {
          case 'eleve':
            listTitle.textContent = 'Liste des Élèves';
            break;
          case 'professeur':
            listTitle.textContent = 'Liste des Professeurs';
            break;
          case 'superviseur':
            listTitle.textContent = 'Liste des Superviseurs';
            break;
        }
      });
    });

    function switchToSupervisor() {
      window.location.href = 'suivi-materiel.html';
    }
  </script>
</body>
</html>