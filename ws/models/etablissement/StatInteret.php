<?php
require_once __DIR__ . '/../../db.php';


class StatInteret
{
    /* ---- StatInteret.php ---- */
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
public static function getInteretParPeriode(int $mDebut, int $aDebut,
                                            int $mFin,  int $aFin): array
{
    $db = getDB();

    $dateStart = sprintf('%04d-%02d-01', $aDebut, $mDebut);
    $dateEnd   = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $aFin, $mFin)));

    $sql = "
      SELECT  YEAR(r.dateRemboursement)  AS annee,
              MONTH(r.dateRemboursement) AS mois,
              ROUND(
                  SUM(p.valeur * tp.taux / 100 / 12)
              , 2)                        AS interet
      FROM    remboursement r
      JOIN    pret       p  ON r.id_pret     = p.id
      JOIN    typePret   tp ON p.id_typePret = tp.id
      WHERE   r.dateRemboursement BETWEEN ? AND ?
      GROUP BY annee, mois
      ORDER BY annee, mois
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([$dateStart, $dateEnd]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* total global */
    $total = 0;
    foreach ($rows as $r) $total += $r['interet'];

    return [
        'mois'  => $rows,        // tableau [{annee, mois, interet}, …]
        'total' => round($total, 2)
    ];
}




}
