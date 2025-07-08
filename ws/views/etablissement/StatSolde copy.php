<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Liste des soldes mensuels - Open Enterprise</title>

  <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/public/assets_template/img/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-16x16.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon.ico">
  <link rel="manifest" href="<?= BASE_URL ?>/public/assets_template/img/favicons/manifest.json">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/interets.css">
  <meta name="theme-color" content="#ffffff">

  <!-- Optional local CSS fallback -->
  <link href="<?= BASE_URL ?>/public/assets_template/css/theme.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar">
  <main class="main" id="top">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-xl navbar-light fixed-top px-0 pb-0 mb-2" id="navbar" data-navbar-darken-on-scroll="white">
      <div class="container-fluid align-items-center py-2">
        <a class="navbar-brand flex-center" href="#">
          <img class="logo" src="<?= BASE_URL ?>/public/assets_template/img/logo.png" alt="open enterprise" />
          <span class="ms-2 d-none d-sm-block fw-bold">Open Enterprise</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-3 mt-xl-0">
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/etablissement">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/typePretPage">Type pret</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/demandePret">Demande de Pret</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/stat">Statistiques d'intérêt</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/login">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- FORM + RESULTS -->
    <section class="pt-8 py-lg-0" id="hero">
      <div class="container-xxl">
        <div class="stats-container">
          <div class="stats-header">
            <p class="lead">Solde Mensuel</p>
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
              <button class="btn-rechercher" onclick="rechercher()">Analyser</button>
            </div>
          </div>

          <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Chargement des données...</p>
          </div>

          <div class="results-container">
            <div class="table-container">
              <h3> Détail par Mois</h3>
              <table id="tblSolde">
                <thead>
                  <tr>
                    <th>Période</th>
                    <th>Solde (Ar)</th>
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

    <!-- Footer -->
    <section class="py-4">
      <div class="container-xxl">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-6 text-sm-center text-lg-start">
            <h2 class="mb-lg-0">Open Enterprise</h2>
          </div>
          <div class="col-lg-6 text-sm-center text-lg-end">
            <p class="mb-0">&copy; Made with ❤️ by <a href="#">Sanda, Rohy, Fenitra</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- JS Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const apiBase = "<?= BASE_URL ?>";

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
            label: "Solde (Ar)",
            data,
            borderColor: "rgb(102, 126, 234)",
            backgroundColor: "rgba(102, 126, 234, 0.1)",
            fill: true,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          plugins: {
            tooltip: {
              callbacks: {
                label: ctx => `Solde: ${ctx.parsed.y.toFixed(2)} Ar`
              }
            }
          },
          scales: {
            y: {
              ticks: {
                callback: v => v.toFixed(2) + ' Ar'
              }
            }
          }
        }
      });
    }

    function remplirTableau(payload) {
      const rows = payload.mois || [];
      const total = payload.total || 0;
      const tbody = document.querySelector("#tblSolde tbody");
      const totalCell = document.getElementById("totalCell");

      tbody.innerHTML = "";

      if (rows.length === 0) {
        tbody.innerHTML = `<tr><td colspan="2" class="no-results">Aucun résultat trouvé pour cette période</td></tr>`;
        totalCell.textContent = "0,00 Ar";
        renderChart([], []);
        return;
      }

      const labels = [];
      const data = [];

      rows.forEach(r => {
        const solde = Number(r.solde);
        const periode = `${String(r.mois).padStart(2, "0")}/${r.annee}`;
        labels.push(periode);
        data.push(solde);

        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${periode}</td>
          <td>${solde.toLocaleString('fr-FR', { minimumFractionDigits: 2 })} Ar</td>
        `;
        tbody.appendChild(tr);
      });

      totalCell.textContent = `${total.toLocaleString('fr-FR', { minimumFractionDigits: 2 })} Ar`;
      renderChart(labels, data);
    }

    function rechercher() {
      const md = +document.getElementById("moisDebut").value;
      const ad = +document.getElementById("anneeDebut").value;
      const mf = +document.getElementById("moisFin").value;
      const af = +document.getElementById("anneeFin").value;

      if (!md || !ad || !mf || !af || md < 1 || md > 12 || mf < 1 || mf > 12) {
        alert("⚠️ Champs invalides ou manquants");
        return;
      }

      document.getElementById("loading").classList.add("active");

      ajax("POST", "/stat/solde", {
        moisDebut: md,
        anneeDebut: ad,
        moisFin: mf,
        anneeFin: af
      }, data => {
        document.getElementById("loading").classList.remove("active");
        remplirTableau(data);
      }, true);
    }

    window.addEventListener('load', () => setTimeout(rechercher, 1000));
  </script>

  <!-- Optionally add Bootstrap via CDN if not available locally -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>