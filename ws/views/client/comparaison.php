<?php
session_start();
require_once __DIR__ . '/../../../ws/config/config.php';

// Vérifie si un utilisateur est connecté
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

if (!$user) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ===============================================-->
  <!--    Document Title-->
  <!-- ===============================================-->
  <title>Comparaison de Simulations</title>

  <!-- ===============================================-->
  <!--    Favicons-->
  <!-- ===============================================-->
  <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/public/assets_template/img/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-16x16.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon.ico">
  <link rel="manifest" href="<?= BASE_URL ?>/public/assets_template/img/favicons/manifest.json">
  <meta name="msapplication-TileImage" content="assets_template/img/favicons/mstile-150x150.png">
  <meta name="theme-color" content="#ffffff">

  <!-- ===============================================-->
  <!--    Stylesheets-->
  <!-- ===============================================-->
  <link href="<?= BASE_URL ?>/public/assets_template/css/theme.css" rel="stylesheet" />
  <link href="vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
  <style>
    .simulation-item {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
    }
    .comparison-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 20px;
    }
    .comparison-column {
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 5px;
    }
  </style>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar">

  <main class="main" id="top">
    <nav class="navbar navbar-expand-xl navbar-light fixed-top px-0 pb-0 mb-2" id="navbar" data-navbar-darken-on-scroll="white">
      <div class="container-fluid align-items-center py-2"><a class="navbar-brand flex-center" href="index.html"><img class="logo" src="<?= BASE_URL ?>/public/assets_template/img/logo.png" alt="open enterprise" /><span class="ms-2 d-none d-sm-block fw-bold">Open Enterprise</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-3 mt-xl-0">
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/client">Home</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/demande">Faire demande de pret </a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/MesPret">Mes pret</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/simulation">Simulation</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/comparaison">Comparer des simulation</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/login">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="pt-8 py-lg-0" id="hero">
      <div class="container-xxl">
        <div class="row align-items-center min-vh-lg-100">
          <h1>Comparaison de Simulations</h1>

          <div id="simulations-list">
            <p>Chargement des simulations...</p>
          </div>

          <button id="compare-button" class="btn btn-primary mt-3" disabled>Comparer les simulations sélectionnées</button>

          <div id="comparison-results" class="comparison-grid" style="display:none;">
            <!-- Comparison results will be displayed here -->
          </div>
        </div>
      </div>
    </section>

    <section class="py-4">
      <div class="container-xxl">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-6 text-sm-center text-lg-start">
            <h2 class="mb-lg-0">Open Enterprise</h2>
          </div>
          <div class="col-lg-6 text-sm-center text-lg-end">
            <p class="mb-0">&copy; This template is made with ❤️ by <a href="https://themewagon.com/">ThemeWagon</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
    const apiBase = "http://localhost<?= BASE_URL ?>";
    let allSimulations = [];

    function ajax(method, url, data, cb) {
      fetch(apiBase + url, {
          method,
          headers: {
            "Content-Type": "application/json"
          },
          body: method === "GET" ? null : JSON.stringify(data)
        })
        .then(r => r.json())
        .then(cb)
        .catch(e => {
          alert("Erreur réseau: " + e.message);
          console.error(e);
        });
    }

    function fetchSimulations() {
      ajax("GET", "/api/simulations", null, (data) => {
        allSimulations = data;
        const listDiv = document.getElementById("simulations-list");
        listDiv.innerHTML = '';
        if (allSimulations.length === 0) {
          listDiv.innerHTML = '<p>Aucune simulation trouvée pour cet utilisateur.</p>';
          return;
        }

        allSimulations.forEach(sim => {
          const div = document.createElement('div');
          div.className = 'simulation-item';
          div.innerHTML = `
            <input type="checkbox" id="sim-${sim.id}" value="${sim.id}" onchange="handleCheckboxChange()">
            <label for="sim-${sim.id}">
              Simulation #${sim.id}: Montant ${sim.montant}, Durée ${sim.duree} mois, Taux ${sim.taux}%
            </label>
            <p>Coût Total: ${sim.cout_total.toLocaleString()} </p>
            <p>Mensualité: ${sim.mensualite.toLocaleString()} </p>
          `;
          listDiv.appendChild(div);
        });
      });
    }

    function handleCheckboxChange() {
      const checkboxes = document.querySelectorAll('#simulations-list input[type="checkbox"]');
      const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
      const compareButton = document.getElementById('compare-button');

      if (checkedCount >= 2) {
        checkboxes.forEach(cb => {
          if (!cb.checked) {
            cb.disabled = true;
          }
        });
        compareButton.disabled = false;
      } else {
        checkboxes.forEach(cb => {
          cb.disabled = false;
        });
        compareButton.disabled = true;
      }
    }

    function compareSimulations() {
      const selectedIds = Array.from(document.querySelectorAll('#simulations-list input[type="checkbox"]:checked'))
        .map(cb => parseInt(cb.value));

      if (selectedIds.length !== 2) {
        alert("Veuillez sélectionner exactement deux simulations à comparer.");
        return;
      }

      const sim1 = allSimulations.find(sim => sim.id === selectedIds[0]);
      const sim2 = allSimulations.find(sim => sim.id === selectedIds[1]);

      const comparisonResultsDiv = document.getElementById('comparison-results');
      comparisonResultsDiv.style.display = 'grid';
      comparisonResultsDiv.innerHTML = `
        <div class="comparison-column">
          <h3>Simulation #${sim1.id}</h3>
          <p><strong>Montant:</strong> ${sim1.montant.toLocaleString()}</p>
          <p><strong>Durée:</strong> ${sim1.duree} mois</p>
          <p><strong>Taux:</strong> ${sim1.taux}%</p>
          <p><strong>Taux Assurance:</strong> ${sim1.taux_assurance}%</p>
          <p><strong>Mensualité:</strong> ${sim1.mensualite.toLocaleString()}</p>
          <p><strong>Coût Total:</strong> ${sim1.cout_total.toLocaleString()}</p>
          <p><strong>Coût Intérêt:</strong> ${sim1.cout_interet.toLocaleString()}</p>
          <p><strong>Coût Assurance Total:</strong> ${sim1.cout_assurance_total.toLocaleString()}</p>
          <p><strong>Coût Crédit:</strong> ${sim1.cout_credit.toLocaleString()}</p>
        </div>
        <div class="comparison-column">
          <h3>Simulation #${sim2.id}</h3>
          <p><strong>Montant:</strong> ${sim2.montant.toLocaleString()}</p>
          <p><strong>Durée:</strong> ${sim2.duree} mois</p>
          <p><strong>Taux:</strong> ${sim2.taux}%</p>
          <p><strong>Taux Assurance:</strong> ${sim2.taux_assurance}%</p>
          <p><strong>Mensualité:</strong> ${sim2.mensualite.toLocaleString()}</p>
          <p><strong>Coût Total:</strong> ${sim2.cout_total.toLocaleString()}</p>
          <p><strong>Coût Intérêt:</strong> ${sim2.cout_interet.toLocaleString()}</p>
          <p><strong>Coût Assurance Total:</strong> ${sim2.cout_assurance_total.toLocaleString()}</p>
          <p><strong>Coût Crédit:</strong> ${sim2.cout_credit.toLocaleString()}</p>
        </div>
      `;
    }

    document.addEventListener("DOMContentLoaded", () => {
      fetchSimulations();
      document.getElementById('compare-button').addEventListener('click', compareSimulations);
    });
  </script>

  <script src="vendors/@popperjs/popper.min.js"></script>
  <script src="vendors/bootstrap/bootstrap.min.js"></script>
  <script src="vendors/is/is.min.js"></script>
  <script src="vendors/swiper/swiper-bundle.min.js"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="<?= BASE_URL ?>/public/assets_template/js/theme.js"></script>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&amp;family=Roboto:wght@400;500;600;700;900&amp;display=swap" rel="stylesheet">
</body>

</html>