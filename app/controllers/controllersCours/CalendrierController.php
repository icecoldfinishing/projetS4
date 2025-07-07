<?php
namespace app\controllers\controllersCours;

use Flight;
use Exception;
use app\models\modelsCours\GestionCoursModel;

class CalendrierController {

    public static function afficherMois() {
        $mois = isset($_GET['mois']) ? intval($_GET['mois']) : date('n');
        $annee = isset($_GET['annee']) ? intval($_GET['annee']) : date('Y');

        $gestionCours = new GestionCoursModel(Flight::db());

        // Assigner les groupes pour le mois/année (aucun doublon possible)
        $gestionCours->assignerGroupesEleves($mois, $annee);

        $calendrier = [];

        for ($jour = 1; $jour <= 31; $jour++) {
            if (!checkdate($mois, $jour, $annee)) continue;

            $date = sprintf('%04d-%02d-%02d', $annee, $mois, $jour);
            $jourSemaine = date('w', strtotime($date)); // 0 = dimanche, 3 = mercredi, 6 = samedi

            // Si mercredi (3) ou samedi (6), planifier les cours du jour
            if ($jourSemaine == 3 || $jourSemaine == 6) {
                $gestionCours->planifierCoursDuJour($date);
            }

            // Récupérer les séances planifiées pour ce jour
            $seances = $gestionCours->getSeancesParJour($date);

            if (!empty($seances)) {
                $calendrier[$jour] = $seances;
            }
        }

        Flight::render("gestion/edt/calendrier/mois", [
            'mois' => $mois,
            'annee' => $annee,
            'calendrier' => $calendrier
        ]);
    }


    public static function detailsGroupe() {
        $date = $_GET['date'] ?? null;
        $groupe = $_GET['groupe'] ?? null;

        if (!$date || !$groupe) {
            Flight::halt(400, "Date et groupe requis");
        }

        $gestionCours = new GestionCoursModel(Flight::db());
        $eleves = $gestionCours->getElevesDuGroupeParDate($groupe, $date);

        Flight::render("gestion/edt/calendrier/details", [
            'date' => $date,
            'groupe' => $groupe,
            'eleves' => $eleves
        ]);
    }
}