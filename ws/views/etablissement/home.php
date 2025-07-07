<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Page Hello</title>
</head>
<body>
  <h1>Bonjour depuis la page Home</h1>
  <p><a href="<?php echo BASE_URL; ?>/typePretPage">Type pret</a></p>
  <p><a href="<?php echo BASE_URL; ?>/demandePret">Demande de Pret</a></p>
  <p><a href="<?php echo BASE_URL; ?>/stat">Statistiques d'interet</a></p>
  <p><a href="<?php echo BASE_URL; ?>/hello">⬅️ Retour à l'accueil</a></p>
  
</body>
</html>
