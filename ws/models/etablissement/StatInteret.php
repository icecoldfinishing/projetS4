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
        SELECT r.dateRemboursement, r.mensualite,
               p.valeur AS principal, p.duree, p.delai, p.assurance AS assurance_mode,
               tp.taux, tp.assurance AS taux_assurance,
               p.dateDebut
        FROM remboursement r
        JOIN pret p ON r.id_pret = p.id
        JOIN typePret tp ON p.id_typePret = tp.id
        WHERE r.dateRemboursement BETWEEN ? AND ?
        ORDER BY r.dateRemboursement
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([$dateStart, $dateEnd]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $interetsByMonth = [];
    $total = 0;

    foreach ($rows as $r) {
        $dateRemboursement = new DateTime($r['dateRemboursement']);
        $annee = (int)$dateRemboursement->format('Y');
        $mois = (int)$dateRemboursement->format('m');

        $P = (float)$r['principal'];
        $n = (int)$r['duree'];
        $rTaux = (float)$r['taux'] / 100 / 12; // taux mensuel
        $assuranceMode = (int)$r['assurance_mode']; // 1 = unique, 2 = mensuelle
        $tauxAssurance = (float)$r['taux_assurance']; // en %
        $mensualite = (float)$r['mensualite'];

        $dateDebut = new DateTime($r['dateDebut']);
        $diffMonths = ($annee - (int)$dateDebut->format('Y')) * 12 + ($mois - (int)$dateDebut->format('m')) + 1;

        if ($diffMonths < 1 || $diffMonths > $n) {
            continue;
        }

        // Intérêt fixe basé sur capital de base
        $interetMensuel = round($P * $rTaux, 2);

        // Assurance
        $assuranceMensuelle = 0;
        if ($assuranceMode === 1) {
            // Assurance payée une fois, au premier mois seulement
            if ($diffMonths === 1) {
                $assuranceMensuelle = round($P * $tauxAssurance / 100, 2);
            }
        } elseif ($assuranceMode === 2) {
            $assuranceMensuelle = round($P * $tauxAssurance / 100 / $n, 2);
        }

        $interetMensuel += $assuranceMensuelle;

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

    usort($resultRows, function($a, $b) {
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
