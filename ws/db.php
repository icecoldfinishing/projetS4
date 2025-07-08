<?php
function getDB() {
    $host = 'localhost';
    $dbname = 'db_s2_ETU003295';
    $username = 'ETU003295';
    $password = 'SZdZE899';

    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die(json_encode(['error' => $e->getMessage()]));
    }
}
