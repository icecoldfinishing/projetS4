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
  <link rel="manifest" href="<?= BASE_URL ?>/public/assets_template/img/favicons/manifest.json">
  <meta name="msapplication-TileImage" content="assets_template/img/favicons/mstile-150x150.png">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/typePret.css">
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
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/etablissement">Home</a></li>
            <li class="nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/typePretPage"">Type pret</a></li>
              <li class=" nav-item ps-0 ps-xl-4 ms-2"><a class="nav-link fs-2 fw-medium" href="<?php echo BASE_URL; ?>/demandePret">Demande de Pret</a></li>
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
        <div class="row align-items-center min-vh-lg-100">
          <h1>Gestion des types de prêt</h1>

          <div>
            <input type="hidden" id="id">
            <input type="text" id="nom" placeholder="Nom">
            <input type="number" id="taux" placeholder="Taux" step="0.01">
            <input type="number" id="assurance" placeholder="Assurance" step="0.01">
            <input type="hidden" id="duree" value="1">
            <button onclick="ajouterOuModifier()">Ajouter / Modifier</button>
          </div>
          <table id="table-TypePret">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Taux</th>
                <th>Assurance</th>
                <th>Durée</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>

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

    function chargerTypePret() {
      ajax("GET", "/typePrets", null, (data) => {
        const tbody = document.querySelector("#table-TypePret tbody");
        tbody.innerHTML = "";
        data.forEach(tp => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${tp.id}</td>
            <td>${tp.nom}</td>
            <td>${tp.taux}</td>
            <td>${tp.assurance}</td>
            <td>${tp.duree}</td>
            <td>
              <button onclick='remplirFormulaire(${JSON.stringify(tp)})'>✏️</button>
              <button onclick='supprimerTypePret(${tp.id})'>🗑️</button>
            </td>
          `;
          tbody.appendChild(tr);
        });
      });
    }

    function ajouterOuModifier() {
      const id = document.getElementById("id").value;
      const nom = document.getElementById("nom").value;
      const taux = document.getElementById("taux").value;
      const assurance = document.getElementById("assurance").value;
      const duree = document.getElementById("duree").value;

      const urlData = `nom=${encodeURIComponent(nom)}&taux=${taux}&assurance=${assurance}&duree=${duree}`;
      const body = {
        nom,
        taux,
        assurance,
        duree
      };

      if (id) {
        ajax("PUT", `/typePrets/${id}`, body, () => {
          resetForm();
          chargerTypePret();
        }, true);
      } else {
        ajax("POST", "/typePrets", urlData, () => {
          resetForm();
          chargerTypePret();
        });
      }
    }

    function remplirFormulaire(tp) {
      document.getElementById("id").value = tp.id;
      document.getElementById("nom").value = tp.nom;
      document.getElementById("taux").value = tp.taux;
      document.getElementById("assurance").value = tp.assurance;
      document.getElementById("duree").value = tp.duree;
    }

    function supprimerTypePret(id) {
      if (confirm("Supprimer ce type de prêt ?")) {
        ajax("DELETE", `/typePrets/${id}`, null, () => {
          chargerTypePret();
        });
      }
    }

    function resetForm() {
      document.getElementById("id").value = "";
      document.getElementById("nom").value = "";
      document.getElementById("taux").value = "";
      document.getElementById("assurance").value = "";
      document.getElementById("duree").value = "";
    }

    chargerTypePret();
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