<?php
require_once __DIR__ . '/../../../ws/db.php';

class Remboursement {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM remboursement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function generateRemboursements(int $pretId)
{
    $db = getDB();
    $sql = "
        SELECT p.valeur, p.duree, p.delai, p.dateDebut,
               tp.taux
        FROM   pret      p
        JOIN   typePret  tp ON p.id_typePret = tp.id
        WHERE  p.id = ?
    ";
    $row = $db->prepare($sql);
    $row->execute([$pretId]);
    $p = $row->fetch(PDO::FETCH_ASSOC);
    if (!$p) throw new RuntimeException("Prêt $pretId introuvable");

    $P = (float)$p['valeur'];                
    $n = (int)  $p['duree'];                
    $g = (int)  $p['delai'];                 
    $r = (float)$p['taux'] / 100 / 12;      
    $M = round($P * $r / (1 - pow(1 + $r, -$n)), 2);  

    $ins = $db->prepare(
        "INSERT INTO remboursement
               (id_pret, mensualite, valeur, dateRemboursement)
         VALUES (?, ?, ?, ?)"
    );

    $date = new DateTime($p['dateDebut']);
    $date->modify("+{$g} months");          

    for ($i = 1; $i <= $n; $i++) {           
        $ins->execute([
            $pretId,
            $i,                              
            $M,
            $date->format('Y-m-d')
        ]);
        $date->modify('+1 month');
    }
}


}
