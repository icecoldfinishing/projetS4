<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Demande de Prêt</title>
</head>
<body>
  <h1>Demande de Prêt</h1>

  <form method="post" action="<?= BASE_URL ?>/pret/create">

    <div>
      <label for="valeur">Montant du prêt</label>
      <input type="number" name="valeur" id="valeur" placeholder="Entrez le montant" required>
    </div>

    <div>
      <label for="dateDebut">Date de début</label>
      <input type="date" name="dateDebut" id="dateDebut" required>
    </div>

    <div>
      <label for="duree">Durée (en mois)</label>
      <input type="number" name="duree" id="duree" placeholder="Durée en mois" required>
    </div>

    <div>
      <label for="id_typePret">Type de prêt</label>
      <select name="id_typePret" id="id_typePret" required>
        <?php foreach ($typesPret as $typePret): ?>
          <option value="<?= $typePret['id'] ?>"><?= htmlspecialchars($typePret['nom']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit">Faire la demande de prêt</button>
  </form>

  <p><a href="<?= BASE_URL ?>/client">Retour à l'accueil</a></p>
</body>
</html>