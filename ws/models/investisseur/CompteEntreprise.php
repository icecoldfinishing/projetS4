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

    public function ajouterFonds($montant, $date) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO compteentreprise (valeur, date) VALUES (?, ?)");
        return $stmt->execute([$montant, $date]);
    }

    public function updateSolde($montant, $date) {
        $db = getDB();
        $newValeur =  - $montant;
        $stmt = $db->prepare("INSERT INTO compteentreprise (valeur,date) VALUES (?,?)");
        return $stmt->execute([$newValeur,$date]);
    }
    public static function getSoldeParMois(int $mDebut, int $aDebut, int $mFin, int $aFin): array
{
    $db = getDB();

    $dateStart = sprintf('%04d-%02d-01', $aDebut, $mDebut);
    $dateEnd   = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $aFin, $mFin)));

    $sql = "
        SELECT 
  EXTRACT(MONTH FROM date) AS mois,
  EXTRACT(YEAR FROM date) AS annee,
  SUM(valeur) OVER (
    ORDER BY EXTRACT(YEAR FROM date), EXTRACT(MONTH FROM date)
    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
  ) AS solde
FROM compteEntreprise
WHERE date BETWEEN :start AND :end
GROUP BY EXTRACT(YEAR FROM date), EXTRACT(MONTH FROM date)
ORDER BY annee, mois
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':start' => $dateStart,
        ':end'   => $dateEnd
    ]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    $total = 0;

    foreach ($rows as $row) {
        $mois = (int)$row['mois'];
        $annee = (int)$row['annee'];
        $solde = (float)$row['solde'];

        $result[] = [
            'mois' => $mois,
            'annee' => $annee,
            'solde' => round($solde, 2)
        ];

        $total = $solde; // last one will be the final cumulative total
    }

    return [
        'mois' => $result,
        'total' => round($total, 2)
    ];
}

}
