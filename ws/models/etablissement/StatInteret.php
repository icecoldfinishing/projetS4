<?php
require_once __DIR__ . '/../../db.php';


class StatInteret
{
public static function getByMonth($data)
{
    $db  = getDB();
    $sql = "
        SELECT *
        FROM   remboursement
        WHERE  dateRemboursement BETWEEN
               STR_TO_DATE(CONCAT(?, '-', ?, '-01'), '%Y-%m-%d')
           AND LAST_DAY(STR_TO_DATE(CONCAT(?, '-', ?, '-01'), '%Y-%m-%d'))
        ORDER  BY dateRemboursement, id_pret
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $data->annee,
        $data->moi,
        $data->annee,
        $data->moi
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public static function getInteretParPeriode(int $mDebut, int $aDebut, int $mFin, int $aFin): array
{
    $db = getDB();

    $dateStart = sprintf('%04d-%02d-01', $aDebut, $mDebut);
    $dateEnd   = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $aFin, $mFin)));

    $sql = "
        SELECT r.dateRemboursement, r.valeur AS remboursement_valeur,
               p.valeur AS capital, p.duree
        FROM remboursement r
        JOIN pret p ON r.id_pret = p.id
        WHERE r.dateRemboursement BETWEEN ? AND ?
        ORDER BY r.dateRemboursement
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([$dateStart, $dateEnd]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $interetsByMonth = [];
    $total = 0;

    foreach ($rows as $row) {
        $date = new DateTime($row['dateRemboursement']);
        $annee = (int)$date->format('Y');
        $mois = (int)$date->format('m');

        $remboursement = (float)$row['remboursement_valeur'];
        $capital = (float)$row['capital'];
        $duree = (int)$row['duree'];

        if ($duree <= 0) continue;

        $principalMensuel = $capital / $duree;
        $interetMensuel = $remboursement - $principalMensuel;

        $key = sprintf('%04d-%02d', $annee, $mois);
        if (!isset($interetsByMonth[$key])) {
            $interetsByMonth[$key] = 0;
        }

        $interetsByMonth[$key] += $interetMensuel;
        $total += $interetMensuel;
    }

    $resultRows = [];
    foreach ($interetsByMonth as $key => $interet) {
        list($annee, $mois) = explode('-', $key);
        $resultRows[] = [
            'annee' => (int)$annee,
            'mois' => (int)$mois,
            'interet' => round($interet, 2),
        ];
    }

    usort($resultRows, function ($a, $b) {
        return $a['annee'] === $b['annee']
            ? $a['mois'] <=> $b['mois']
            : $a['annee'] <=> $b['annee'];
    });

    return [
        'mois' => $resultRows,
        'total' => round($total, 2)
    ];
}

}









