<?php
require_once __DIR__ . '/../../db.php';

class CompteEntrprise
{
    public static function getAll()
    {
        $db = getDB();
        return $db->query("SELECT * FROM ")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM  WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
