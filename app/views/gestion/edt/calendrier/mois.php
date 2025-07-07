<?php 
function estMercrediOuSamedi($jour, $mois, $annee) {
    $date = DateTime::createFromFormat('Y-n-j', "$annee-$mois-$jour");
    $jourSemaine = $date->format('N'); // 1 = lundi, ..., 7 = dimanche
    return in_array($jourSemaine, [3, 6]); // mercredi (3) ou samedi (6)
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
</head>
<body>
    <div id="app">
        <?= Flight::menuAdmin() ?>
        <div id="main">
            <div class="main-content container-fluid">
                <div class="page-title mb-4">
                    <h3>Calendrier de <span class="text-primary"><?= $mois ?>/<?= $annee ?></span> <small>(Mercredi & Samedi)</small></h3>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <!-- Navigation boutons -->
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <a class="btn btn-outline-secondary" href="?mois=<?= $mois ?>&annee=<?= $annee - 1 ?>">
                            <i class="bi bi-chevron-double-left"></i> Année précédente
                        </a>
                        <a class="btn btn-outline-primary" href="?mois=<?= ($mois == 1 ? 12 : $mois - 1) ?>&annee=<?= ($mois == 1 ? $annee - 1 : $annee) ?>">
                            <i class="bi bi-chevron-left"></i> Mois précédent
                        </a>
                        <a class="btn btn-outline-primary" href="?mois=<?= ($mois == 12 ? 1 : $mois + 1) ?>&annee=<?= ($mois == 12 ? $annee + 1 : $annee) ?>">
                            Mois suivant <i class="bi bi-chevron-right"></i>
                        </a>
                        <a class="btn btn-outline-secondary" href="?mois=<?= $mois ?>&annee=<?= $annee + 1 ?>">
                            Année suivante <i class="bi bi-chevron-double-right"></i>
                        </a>
                    </div>

                    <!-- Sélecteur de mois et année -->
                    <form method="get" class="d-flex gap-2 align-items-center">
                        <select name="mois" class="form-select form-select-sm" style="width: auto;">
                            <?php
                            $moisNoms = [
                                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                            ];
                            foreach ($moisNoms as $num => $nom) {
                                echo "<option value=\"$num\" " . ($mois == $num ? 'selected' : '') . ">$nom</option>";
                            }
                            ?>
                        </select>

                        <input type="number" name="annee" class="form-control form-control-sm" style="width: 100px;" value="<?= $annee ?>" min="2000" max="2100">

                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-calendar-check"></i> Aller
                        </button>
                    </form>
                </div>

                <div class="row g-3">
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <?php if (checkdate($mois, $i, $annee) && estMercrediOuSamedi($i, $mois, $annee)): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-white border-bottom">
                                        <h6 class="mb-0 text-primary fw-bold"><?= $i ?>/<?= $mois ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($calendrier[$i])): ?>
                                            <?php foreach ($calendrier[$i] as $s): ?>
                                                <div class="mb-3 p-2 border-start border-primary bg-light rounded">
                                                    <div><strong><?= htmlspecialchars($s['heure_debut']) ?> - <?= htmlspecialchars($s['heure_fin']) ?></strong></div>
                                                    <div>Groupe : <?= htmlspecialchars($s['groupe']) ?></div>
                                                    <div><?= htmlspecialchars($s['cours']) ?></div>
                                                    <div>Prof : <?= htmlspecialchars($s['prof_nom']) ?> <?= htmlspecialchars($s['prof_prenom']) ?></div>
                                                    <a href="<?= Flight::base() ?>/calendrier/details?date=<?= "$annee-$mois-$i" ?>&groupe=<?= $s['groupe'] ?>" class="text-decoration-none text-info small">
                                                        <i class="bi bi-eye"></i> Détails
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Aucune séance</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
</body>
</html>
