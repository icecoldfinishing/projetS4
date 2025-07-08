<?php
require_once __DIR__ . '/../../../ws/db.php';

class Remboursement {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM remboursement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function generateRemboursements(int $pretId): float
{
    $db = getDB();

    $sql = "
        SELECT p.valeur, p.duree, p.delai, p.dateDebut,
               p.assurance, tp.taux, tp.assurance AS taux_assurance
        FROM   pret p
        JOIN   typePret tp ON p.id_typePret = tp.id
        WHERE  p.id = ?
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$pretId]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$p) throw new RuntimeException("Prêt $pretId introuvable");

    $P = (float)$p['valeur'];
    $n = (int)$p['duree'];
    $g = (int)$p['delai'];
    $r = (float)$p['taux'] / 100 / 12;
    $assuranceMode = (int)$p['assurance'];
    $tauxAssurance = (float)$p['taux_assurance'];

    $M = round($P * $r / (1 - pow(1 + $r, -$n)), 2);

    $assuranceMontant = 0;
    if ($assuranceMode === 1) {
        $assuranceMontant = round($P * $tauxAssurance / 100, 2);
    }

    $ins = $db->prepare("
        INSERT INTO remboursement (id_pret, mensualite, valeur, dateRemboursement)
        VALUES (?, ?, ?, ?)
    ");

    $date = new DateTime($p['dateDebut']);
    $date->modify("+{$g} months");

    $total = 0;

    for ($i = 1; $i <= $n; $i++) {
        $value = $M;
        if ($i === 1 && $assuranceMontant > 0) {
            $value += $assuranceMontant;
        }

        $ins->execute([
            $pretId,
            $i,
            $value,
            $date->format('Y-m-d')
        ]);

        $total += $value;
        $date->modify('+1 month');
    }

    return round($total, 2);
}




}
