<?php

namespace app\models\salle;
use PDO;

class ClubModel
{
    private $db;
    private $table = 'club_groupe';

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY nom_responsable");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
