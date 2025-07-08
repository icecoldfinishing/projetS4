<?php
require_once __DIR__ . '/../../../ws/config/config.php';
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
  <title>Open Enterprise</title>


  <!-- ===============================================-->
  <!--    Favicons-->
  <!-- ===============================================-->
  <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/public/assets_template/img/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon-16x16.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets_template/img/favicons/favicon.ico">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/demande.css">
  <link rel="manifest" href="<?= BASE_URL ?>/public/assets_template/img/favicons/manifest.json">
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
      <div class="container-fluid align-items-center py-2"><a class="navbar-brand flex-center" href="index.html"><img class="logo" src="<?= BASE_URL ?>/public/assets_template/img/logo.png" alt="open enterprise" /><span class="ms-2 d-none d-sm-block fw-bold">Open Enterprise</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-3 mt-xl-0">
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/client">Home</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/demande">Faire demande de pret</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/MesPret">Mes pret</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/simulation">Simulation</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/login">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-8 py-lg-0" id="hero">

      <div class="container-xxl">
        <div class="row align-items-center min-vh-lg-100">
          <h1>Simulation de prêt</h1>

          <div class="simulation-form">
            <div>
              <label for="valeur">Montant</label>
              <input type="number" id="valeur" placeholder="Entrez le montant" required>
            </div>

            <div>
              <label for="duree">Durée</label>
              <input type="number" id="duree" placeholder="Durée en mois" required>
            </div>
            
            <div>
              <label for="id_typePret">Type de prêt</label>
              <select id="id_typePret" required>
                <option value="">Sélectionnez un type de prêt</option>
              </select>
            </div>

            <button onclick="simulerPret()">Simuler</button>
          </div>

          <!-- Résultats de la simulation -->
          <div id="resultat-simulation" style="display:none; margin-top: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h3>Résultats de la simulation</h3>
            <div id="details-simulation"></div>
          </div>

        </div>
      </div>
      <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- <section> begin ============================-->
    <section id="rea">

      <div class="container-xxl">
        <div class="row align-items-center">
          <div class="col-lg order-lg-1 text-center"><img class="img-fluid" src="<?= BASE_URL ?>/public/assets_template/img/illustrations/hero2.png" alt="" /></div>
          <div class="col-lg mt-5 mt-lg-0">
            <h1 class="lh-sm font-cursive fw-medium display-5">Start an Open Enterprise with :</h1>
            <p class="mt-4 fs-1">ETU003246 Sanda</p>
            <p class="mt-4 fs-1">ETU003295 Rohy</p>
            <p class="mt-4 fs-1">ETU003660 Fenitra</p>
            <button class="btn btn-success mt-4">Request early access</button>
          </div>
        </div>
      </div>
      <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




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
      <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->


  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->

  <script>
    const apiBase = "http://localhost<?= BASE_URL ?>";

    // Fonction Ajax réutilisable (identique au premier fichier)
    function ajax(method, url, data, callback, sendJson = false) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, apiBase + url, true);

      if (sendJson) {
        xhr.setRequestHeader("Content-Type", "application/json");
        data = JSON.stringify(data);
      } else {
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      }

      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
          if (xhr.status >= 200 && xhr.status < 300) {
            callback(JSON.parse(xhr.responseText || "{}"));
          } else {
            console.error("Erreur AJAX", xhr.status, xhr.responseText);
            alert("Erreur " + xhr.status + " — voir console.");
          }
        }
      };

      xhr.send(data);
    }

    // Charger les types de prêts dans le select
    function chargerTypesPret() {
      ajax("GET", "/typePrets", null, (data) => {
        const select = document.getElementById("id_typePret");
        select.innerHTML = '<option value="">Sélectionnez un type de prêt</option>';
        
        data.forEach(typePret => {
          const option = document.createElement("option");
          option.value = typePret.id;
          option.textContent = `${typePret.nom} (${typePret.taux}%)`;
          select.appendChild(option);
        });
      });
    }

    // Fonction pour simuler le prêt
    function simulerPret() {
      const valeur = document.getElementById("valeur").value;
      const duree = document.getElementById("duree").value;
      const idTypePret = document.getElementById("id_typePret").value;

      // Validation des champs
      if (!valeur || !duree || !idTypePret) {
        alert("Veuillez remplir tous les champs");
        return;
      }

      if (valeur <= 0) {
        alert("Le montant doit être positif");
        return;
      }

      if (duree <= 0) {
        alert("La durée doit être positive");
        return;
      }

      // Données à envoyer
      const simulationData = {
        valeur: parseFloat(valeur),
        duree: parseInt(duree),
        id_typePret: parseInt(idTypePret)
      };

      // Appel Ajax pour la simulation
      ajax("POST", "/simulation", simulationData, (resultat) => {
        afficherResultatSimulation(resultat);
      }, true);
    }

    // Fonction pour afficher les résultats de la simulation
    function afficherResultatSimulation(resultat) {
      const divResultat = document.getElementById("resultat-simulation");
      const divDetails = document.getElementById("details-simulation");
      
      if (resultat.success) {
        divDetails.innerHTML = `
          <div class="row">
            <div class="col-md-6">
              <p><strong>Montant emprunté:</strong> ${resultat.data.montant_emprunte.toLocaleString()} €</p>
              <p><strong>Taux d'intérêt:</strong> ${resultat.data.taux_interet}%</p>
              <p><strong>Durée:</strong> ${resultat.data.duree} mois</p>
            </div>
            <div class="col-md-6">
              <p><strong>Mensualité:</strong> ${resultat.data.mensualite.toLocaleString()} €</p>
              <p><strong>Coût total:</strong> ${resultat.data.cout_total.toLocaleString()} €</p>
              <p><strong>Coût du crédit:</strong> ${resultat.data.cout_credit.toLocaleString()} €</p>
            </div>
          </div>
        `;
        
        // Afficher le tableau d'amortissement si disponible
        if (resultat.data.tableau_amortissement && resultat.data.tableau_amortissement.length > 0) {
          divDetails.innerHTML += `
            <div class="mt-4">
              <h4>Tableau d'amortissement</h4>
              <div style="max-height: 300px; overflow-y: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Mois</th>
                      <th>Mensualité</th>
                      <th>Capital</th>
                      <th>Intérêts</th>
                      <th>Capital restant</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${resultat.data.tableau_amortissement.map(ligne => `
                      <tr>
                        <td>${ligne.mois}</td>
                        <td>${ligne.mensualite.toLocaleString()} €</td>
                        <td>${ligne.capital.toLocaleString()} €</td>
                        <td>${ligne.interets.toLocaleString()} €</td>
                        <td>${ligne.capital_restant.toLocaleString()} €</td>
                      </tr>
                    `).join('')}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      } else {
        divDetails.innerHTML = `
          <div class="alert alert-danger">
            <strong>Erreur:</strong> ${resultat.message || 'Erreur lors de la simulation'}
          </div>
        `;
      }
      
      divResultat.style.display = "block";
      divResultat.scrollIntoView({ behavior: 'smooth' });
    }

    // Fonction pour réinitialiser le formulaire
    function resetForm() {
      document.getElementById("valeur").value = "";
      document.getElementById("duree").value = "";
      document.getElementById("id_typePret").value = "";
      document.getElementById("resultat-simulation").style.display = "none";
    }

    // Charger les types de prêts au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
      chargerTypesPret();
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