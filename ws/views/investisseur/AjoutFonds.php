<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout de fonds</title>
</head>
<body>
    <h1>💰 Ajouter des fonds au compte entreprise</h1>

    <?php if (isset($success) && $success !== null): ?>
        <p style="color: <?php echo $success ? 'green' : 'red'; ?>;">
            <?php echo $success ? '✅ Fonds ajoutés avec succès.' : '❌ Échec de l’ajout des fonds.'; ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>/investisseur/AjoutFonds">
        <label for="valeur">Montant à ajouter :</label>
        <input type="number" name="valeur" id="valeur" required>
        <button type="submit">Ajouter</button>
    </form>
    <br>
</body>
</html>