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
  <a href="<?php echo BASE_URL; ?>/hello">⬅️ Retour à l'accueil</a><br>
  <a href="<?php echo BASE_URL; ?>/investisseur/AjoutFonds">💰 Ajouter des fonds</a>
</body>
</html>