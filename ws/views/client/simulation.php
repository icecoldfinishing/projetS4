<?php
session_start();
require_once __DIR__ . '/../../../ws/config/config.php';
require_once __DIR__ . '/../../../ws/models/other/SImulation.php';


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
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/simulation.css">
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
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/demande"">Faire demande de pret </a></li>
              <li class=" nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/MesPret">Mes pret</a></li>
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

          <h1></h1>

          <div class="simulation-form">
            <div>
              <label for="valeur">Montant</label>
              <input type="number" id="valeur" placeholder="Montant " required>
            </div>
            <div>
              <label for="duree">Durée (mois)</label>
              <input type="number" id="duree" placeholder="Durée" required>
            </div>
            <div>
              <label for="id_typePret">Type de prêt</label>
              <select id="id_typePret" required>
                <option value="">Sélectionnez...</option>
              </select>
            </div>
            <button onclick="simulerPret()">Simuler</button>
          </div>

          <!-- Résultats -->
          <div id="resultat-simulation" style="display:none;margin-top:20px;padding:20px;border:1px solid #ddd;border-radius:5px;">
            <h3>Résultats</h3>
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

    /* ------------- AJAX helper (JSON) ------------- */
    function ajax(method, url, data, cb) {
      fetch(apiBase + url, {
          method,
          headers: {
            "Content-Type": "application/json"
          },
          body: method === "GET" ? null : JSON.stringify(data)
        })
        .then(r => r.json()).then(cb)
        .catch(e => {
          alert("Erreur réseau");
          console.error(e);
        });
    }

    /* ------------- Charger types de prêt ----------- */
    function chargerTypesPret() {
      ajax("GET", "/typePrets", null, data => {
        const sel = document.getElementById("id_typePret");
        sel.innerHTML = '<option value="">Sélectionnez...</option>';
        data.forEach(tp => {
          const opt = document.createElement("option");
          opt.value = tp.id;
          opt.textContent = `${tp.nom} (${tp.taux} % annuel)`;
          opt.dataset.taux = tp.taux; // ← indispensable
          sel.appendChild(opt);
        });
      });
    }

    /* ------------- Simulation côté client ---------- */
    function simulerPret() {
      const val = +document.getElementById("valeur").value;
      const n = +document.getElementById("duree").value;
      const sel = document.getElementById("id_typePret");
      const tauxAnnuel = parseFloat(sel.options[sel.selectedIndex].dataset.taux);

      if (!val || !n || isNaN(tauxAnnuel)) {
        alert("Champs manquants");
        return;
      }
      if (val <= 0 || n <= 0) {
        alert("Valeurs positives requises");
        return;
      }

      const r = tauxAnnuel / 100 / 12;
      const M = +(val * r / (1 - Math.pow(1 + r, -n))).toFixed(2);
      const ct = +(M * n).toFixed(2);
      const cc = +(ct - val).toFixed(2);

      // Afficher le résultat
      afficherResultat({
        success: true,
        data: {
          montant_emprunte: val,
          taux_interet: tauxAnnuel,
          duree: n,
          mensualite: M,
          cout_total: ct,
          cout_credit: cc
        }
      });

      // 🟢 Enregistrer en base via AJAX POST
      const dataToSave = {
        montant: val,
        taux: tauxAnnuel,
        duree: n,
        mensualite: M,
        total: ct,
        credit: cc
      };

      ajax("POST", "/simulation", dataToSave, res => {
        if (res.success) {
          console.log("✅ Simulation enregistrée !");
        } else {
          console.warn("❌ Erreur d’enregistrement :", res.message);
        }
      });
    }


    /* ------------- Affichage résultat -------------- */
    function afficherResultat(res) {
      const divRes = document.getElementById("resultat-simulation");
      const divDet = document.getElementById("details-simulation");
      if (res.success) {
        const d = res.data;
        divDet.innerHTML = `
      <p><strong>Montant emprunté :</strong> ${d.montant_emprunte.toLocaleString()} </p>
      <p><strong>Taux annuel :</strong> ${d.taux_interet}%</p>
      <p><strong>Durée :</strong> ${d.duree} mois</p>
      <p><strong>Mensualité :</strong> ${d.mensualite.toLocaleString()} </p>
      <p><strong>Coût total :</strong> ${d.cout_total.toLocaleString()} </p>
      <p><strong>Coût du crédit :</strong> ${d.cout_credit.toLocaleString()} </p>`;
      } else {
        divDet.innerHTML = `<div class="alert alert-danger">Erreur : ${res.message}</div>`;
      }
      divRes.style.display = "block";
      divRes.scrollIntoView({
        behavior: "smooth"
      });
    }

    /* ------------- Init ---------------------------- */
    document.addEventListener("DOMContentLoaded", chargerTypesPret);
  </script>



  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
  <script src="vendors/@popperjs/popper.min.js"></script>
  <script src="vendors/bootstrap/bootstrap.min.js"></script>
  <script src="vendors/is/is.min.js"></script>
  <script src="vendors/swiper/swiper-bundle.min.js"> </script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="<?= BASE_URL ?>/public/assets_template/js/theme.js"></script>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&amp;family=Roboto:wght@400;500;600;700;900&amp;display=swap" rel="stylesheet">
</body>

</html>