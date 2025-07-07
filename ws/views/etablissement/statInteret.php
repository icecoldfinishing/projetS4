<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ===============================================-->
  <!--    Document Title-->
  <!-- ===============================================-->
  <title>Statistiques d'Intérêts - Open Enterprise</title>

  <!-- ===============================================-->
  <!--    Favicons-->
  <!-- ===============================================-->
  <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/public/assets_template/img/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-16x16.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon.ico">
  <link rel="manifest" href="<?= BASE_URL ?>/public/assets_template/img/favicons/manifest.json">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/interets.css">
  <meta name="msapplication-TileImage" content="assets_template/img/favicons/mstile-150x150.png">
  <meta name="theme-color" content="#ffffff">

  <!-- ===============================================-->
  <!--    Stylesheets-->
  <!-- ===============================================-->
  <link href="<?= BASE_URL ?>/public/assets_template/css/theme.css" rel="stylesheet" />
  <link href="vendors/swiper/swiper-bundle.min.css" rel="stylesheet">


</head>

<body data-bs-spy="scroll" data-bs-target="#navbar">

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <nav class="navbar navbar-expand-xl navbar-light fixed-top px-0 pb-0 mb-2" id="navbar" data-navbar-darken-on-scroll="white">
      <div class="container-fluid align-items-center py-2">
        <a class="navbar-brand flex-center" href="index.html">
          <img class="logo" src="<?= BASE_URL ?>/public/assets_template/img/logo.png" alt="open enterprise" />
          <span class="ms-2 d-none d-sm-block fw-bold">Open Enterprise</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-3 mt-xl-0">
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/etablissement">Home</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/typePretPage">Type pret</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/demandePret">Demande de Pret</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/stat">Statistiques d'interet</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/login">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-8 py-lg-0" id="hero">
      <div class="container-xxl">
        <div class="stats-container">
          <div class="stats-header">
            <p class="lead">Analysez vos revenus d'intérêts par période</p>
          </div>

          <div class="form-container">
            <div class="form-row">
              <div class="form-group">
                <label>Début</label>
                <div style="display: flex; gap: 10px;">
                  <input type="number" id="moisDebut" placeholder="Mois" min="1" max="12" value="1">
                  <input type="number" id="anneeDebut" placeholder="Année" value="2020">
                </div>
              </div>
              
              <div class="form-group">
                <label>Fin</label>
                <div style="display: flex; gap: 10px;">
                  <input type="number" id="moisFin" placeholder="Mois" min="1" max="12" value="12">
                  <input type="number" id="anneeFin" placeholder="Année" value="2025">
                </div>
              </div>
              
              <button class="btn-rechercher" onclick="rechercher()">
                Analyser
              </button>
            </div>
          </div>

          <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Chargement des données...</p>
          </div>

          <div class="results-container">
            <div class="table-container">
              <h3> Détail par Mois</h3>
              <table id="tblInterets">
                <thead>
                  <tr>
                    <th> Période</th>
                    <th> Intérêt (Ar)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="2" class="no-results">Cliquez sur "Analyser" pour voir les résultats</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td>Total</td>
                    <td id="totalCell">0,00 Ar</td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <div class="chart-container">
              <h3> Évolution Graphique</h3>
              <canvas id="chart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section id="rea">
      <div class="container-xxl">
        <div class="row align-items-center">
          <div class="col-lg order-lg-1 text-center">
            <img class="img-fluid" src="<?= BASE_URL ?>/public/assets_template/img/illustrations/hero2.png" alt="" />
          </div>
          <div class="col-lg mt-5 mt-lg-0">
            <h1 class="lh-sm font-cursive fw-medium display-5">Start an Open Enterprise with :</h1>
            <p class="mt-4 fs-1">ETU003246 Sanda</p>
            <p class="mt-4 fs-1">ETU003295 Rohy</p>
            <p class="mt-4 fs-1">ETU003660 Fenitra</p>
            <button class="btn btn-success mt-4">Request early access</button>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================-->
    <!-- <section> begin ============================-->
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

  <!-- ===============================================-->
  <!--    Scripts-->
  <!-- ===============================================-->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <script>
    const apiBase = "http://localhost<?= BASE_URL ?>";

    function ajax(method, url, data, cb, json = false) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, apiBase + url, true);
      xhr.setRequestHeader(
        "Content-Type",
        json ? "application/json" : "application/x-www-form-urlencoded"
      );
      xhr.onload = () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          cb(JSON.parse(xhr.responseText || "[]"));
        } else {
          alert("Erreur " + xhr.status + " – voir console");
          console.error(xhr.responseText);
        }
      };
      xhr.send(json ? JSON.stringify(data) : data);
    }

    let chart;

    function renderChart(labels, data) {
      const ctx = document.getElementById("chart");
      if (chart) chart.destroy();
      
      chart = new Chart(ctx, {
        type: "line",
        data: {
          labels,
          datasets: [{
            label: "Intérêts (Ar)",
            data,
            borderColor: "rgb(102, 126, 234)",
            backgroundColor: "rgba(102, 126, 234, 0.1)",
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: "rgb(102, 126, 234)",
            pointBorderColor: "#fff",
            pointBorderWidth: 3,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "rgb(255, 107, 107)",
            pointHoverBorderColor: "#fff"
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                usePointStyle: true,
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            tooltip: {
              backgroundColor: 'rgba(0, 0, 0, 0.8)',
              titleColor: '#fff',
              bodyColor: '#fff',
              borderColor: 'rgb(102, 126, 234)',
              borderWidth: 1,
              cornerRadius: 8,
              displayColors: false,
              callbacks: {
                title: function(context) {
                  return `Période: ${context[0].label}`;
                },
                label: function(context) {
                  return `Intérêt: ${context.parsed.y.toFixed(2)} Ar`;
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: 'rgba(0, 0, 0, 0.1)'
              },
              ticks: {
                callback: function(value) {
                  return value.toFixed(2) + ' Ar';
                },
                font: {
                  size: 12
                }
              }
            },
            x: {
              grid: {
                color: 'rgba(0, 0, 0, 0.1)'
              },
              ticks: {
                font: {
                  size: 12
                }
              }
            }
          },
          interaction: {
            intersect: false,
            mode: 'index'
          }
        }
      });
    }

    function remplirTableau(payload) {
      const rows = payload.mois || [];
      const total = payload.total || 0;
      const tbody = document.querySelector("#tblInterets tbody");
      const totalCell = document.getElementById("totalCell");

      tbody.innerHTML = "";
      
      if (rows.length === 0) {
        tbody.innerHTML = `<tr><td colspan="2" class="no-results">
                         Aucun résultat trouvé pour cette période
                       </td></tr>`;
        totalCell.textContent = "0,00 Ar";
        renderChart([], []);
        return;
      }

      const labels = [];
      const data = [];

      rows.forEach(r => {
        const interet = Number(r.interet);
        const periode = `${String(r.mois).padStart(2,"0")}/${r.annee}`;
        labels.push(periode);
        data.push(interet);

        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td> ${periode}</td>
          <td> ${interet.toLocaleString('fr-FR', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
          })} Ar</td>`;
        tbody.appendChild(tr);
      });

      totalCell.textContent = `${total.toLocaleString('fr-FR', { 
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2 
      })} Ar`;
      
      renderChart(labels, data);
    }

    function rechercher() {
      const md = +document.getElementById("moisDebut").value;
      const ad = +document.getElementById("anneeDebut").value;
      const mf = +document.getElementById("moisFin").value;
      const af = +document.getElementById("anneeFin").value;

      if (!md || !ad || !mf || !af) {
        alert("⚠️ Veuillez renseigner tous les champs.");
        return;
      }

      if (md < 1 || md > 12 || mf < 1 || mf > 12) {
        alert("⚠️ Les mois doivent être compris entre 1 et 12.");
        return;
      }

      // Afficher le loading
      document.getElementById("loading").classList.add("active");

      ajax("POST", "/stat/interets", {
          moisDebut: md,
          anneeDebut: ad,
          moisFin: mf,
          anneeFin: af
        },
        (data) => {
          document.getElementById("loading").classList.remove("active");
          remplirTableau(data);
        }, 
        true
      );
    }

    // Charger les données par défaut au chargement de la page
    window.addEventListener('load', function() {
      setTimeout(rechercher, 1000);
    });
  </script>

  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
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