<?php
// Partie 1 : chemin racine (peut être vide ou "/ws" selon l'organisation serveur)
$host = '/'; // ou '/ws' si vous avez un dossier "ws" public

// Partie 2 : chemin vers le projet complet
$project = 'ETU003295/projetS4/ws';

// Définition propre de BASE_URL
define('BASE_URL', $host . $project);
