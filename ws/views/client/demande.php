<?php
session_start();
require_once __DIR__ . '/../../../ws/config/config.php';

// Vérifie si un utilisateur est connecté
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Demande de Prêt</title>
</head>

<body>
  <h1>Demande de Prêt</h1>

  <?php if ($user): ?>
    <p>Bienvenue, <strong><?= htmlspecialchars($user['prenom']) ?> <?= htmlspecialchars($user['nom']) ?></strong> (ID: <?= $user['id'] ?>)</p>
  <?php else: ?>
    <p>Utilisateur non connecté. <a href="<?= BASE_URL ?>/login">Se connecter</a></p>
    <?php exit(); // Bloque l'accès si pas connecté 
    ?>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>/pret/demande">

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
      <label for="delai">Délai mensuel</label>
      <input type="number" name="delai" id="delai" placeholder="Délai de carence ou délai de traitement" required>
    </div>

    <div>
      <label for="id_typePret">Type de prêt</label>
      <select name="id_typePret" id="id_typePret" required>
        <?php foreach ($typesPret as $typePret): ?>
          <option value="<?= $typePret['id'] ?>"><?= htmlspecialchars($typePret['nom']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <textarea name="commentaire" id="commentaire" placeholder="Ajoutez un commentaire..." rows="4" cols="50"></textarea>
    </div>

    <button type="submit">Faire la demande de prêt</button>
  </form>



  <p><a href="<?= BASE_URL ?>/client">Retour à l'accueil</a></p>
</body>

</html>