<?php
require_once __DIR__ . '/../../db.php';

class CompteEntreprise
{
    public static function getLastValeur()
    {
        $db = getDB();
        $stmt = $db->query("SELECT SUM(valeur)as valeur FROM compteentreprise ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['valeur'] : 0;
    }

    public function ajouterFonds($montant, $date)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO compteentreprise (valeur, date) VALUES (?, ?)");
        return $stmt->execute([$montant, $date]);
    }

    public function updateSolde($montant, $date)
    {
        $db = getDB();
        $newValeur =  -$montant;
        $stmt = $db->prepare("INSERT INTO compteentreprise (valeur,date) VALUES (?,?)");
        return $stmt->execute([$newValeur, $date]);
    }
    public static function getSoldeParMois(int $mDebut, int $aDebut, int $mFin, int $aFin): array
    {
        $db = getDB();

        $dateStart = sprintf('%04d-%02d-01', $aDebut, $mDebut);
        $dateEnd   = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $aFin, $mFin)));

        // 1) Get the cumulative sum before the start date
        $stmt1 = $db->prepare("SELECT COALESCE(SUM(valeur), 0) AS initial_solde FROM compteEntreprise WHERE date < :start");
        $stmt1->execute([':start' => $dateStart]);
        $initialSolde = (float)$stmt1->fetchColumn();

        // 2) Get cumulative sums per month in the period
        $sql = "
        SELECT 
            EXTRACT(MONTH FROM date) AS mois,
            EXTRACT(YEAR FROM date) AS annee,
            SUM(valeur) AS valeur_mois
        FROM compteEntreprise
        WHERE date BETWEEN :start AND :end
        GROUP BY EXTRACT(YEAR FROM date), EXTRACT(MONTH FROM date)
        ORDER BY annee, mois
    ";

        $stmt2 = $db->prepare($sql);
        $stmt2->execute([
            ':start' => $dateStart,
            ':end'   => $dateEnd,
        ]);

        $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        $cumulative = $initialSolde; // start with the initial balance

        foreach ($rows as $row) {
            $mois = (int)$row['mois'];
            $annee = (int)$row['annee'];
            $valeurMois = (float)$row['valeur_mois'];

            $cumulative += $valeurMois; // add this month's valeur to cumulative

            $result[] = [
                'mois' => $mois,
                'annee' => $annee,
                'solde' => round($cumulative, 2) // cumulative solde including previous months + initial
            ];
        }

        return [
            'mois' => $result,
            'total' => round($cumulative, 2)
        ];
    }
}
