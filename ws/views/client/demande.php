<?php
session_start();
require_once __DIR__ . '/../../../ws/config/config.php';

// Vérifie si un utilisateur est connecté
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;


if (isset($_SESSION['success'])) {
  echo '<div style="color: green; font-weight: bold;">' . htmlspecialchars($_SESSION['success']) . '</div>';
  unset($_SESSION['success']); // Supprimer après affichage
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
          <?php if ($user): ?>
            <p>Bienvenue, <strong><?= htmlspecialchars($user['prenom']) ?> <?= htmlspecialchars($user['nom']) ?></strong> (ID: <?= $user['id'] ?>)</p>
          <?php else: ?>
            <p>Utilisateur non connecté. <a href="<?= BASE_URL ?>/login">Se connecter</a></p>
            <?php exit(); // Bloque l'accès si pas connecté 
            ?>
          <?php endif; ?>

          <form method="post" action="<?= BASE_URL ?>/pret/demande">

            <div>
              <label for="valeur">Montant du prêt</label>
              <input type="number" name="valeur" id="valeur" placeholder="Entrez le montant" required>
            </div>

            <div>
              <label for="dateDebut">Date de début</label>
              <input type="date" name="dateDebut" id="dateDebut" required>
            </div>

            <div>
              <label for="duree">Durée (en mois)</label>
              <input type="number" name="duree" id="duree" placeholder="Durée en mois" required>
            </div>

            <div>
              <label for="delai">Délai mensuel</label>
              <input type="number" name="delai" id="delai" placeholder="Délai de carence ou délai de traitement" required>
            </div>

            <div>
              <label for="id_typePret">Type de prêt</label>
              <select name="id_typePret" id="id_typePret" required>
                <?php foreach ($typesPret as $typePret): ?>
                  <option value="<?= $typePret['id'] ?>"><?= htmlspecialchars($typePret['nom']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <textarea name="commentaire" id="commentaire" placeholder="Ajoutez un commentaire..." rows="4" cols="50"></textarea>
            </div>
            <button type="submit">Faire la demande de prêt</button>
          </form>

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