<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Demandes de Prêt pas encore refusées</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
      vertical-align: middle;
    }

    th {
      background-color: #eee;
    }

    form {
      margin: 0;
    }

    button {
      margin: 0 2px;
      padding: 5px 10px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
    }

    button.valider {
      background-color: #4CAF50;
      color: white;
    }

    button.refuser {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>

<body>
  <h1>Demandes de Prêt </h1>

  <?php if (isset($errorMessage) && $errorMessage !== null): ?>
    <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
  <?php endif; ?>

  <?php if (isset($successMessage) && $successMessage !== null): ?>
    <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
  <?php endif; ?>

  <p><a href="<?= BASE_URL ?>/hello">⬅️ Retour à l'accueil</a></p>

  <?php if (!empty($prets)): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Utilisateur</th>
          <th>Montant</th>
          <th>Date début</th>
          <th>Durée (mois)</th>
          <th>Délai mensuel</th> <!-- Nouvelle colonne -->
          <th>Type de prêt</th>
          <th>Commentaire</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($prets as $pret): ?>
          <tr>
            <td><?= htmlspecialchars($pret['id']) ?></td>
            <td><?= htmlspecialchars($pret['id_user']) ?></td>
            <td><?= htmlspecialchars($pret['valeur']) ?> €</td>
            <td><?= htmlspecialchars($pret['dateDebut']) ?></td>
            <td><?= htmlspecialchars($pret['duree']) ?></td>
            <td><?= htmlspecialchars($pret['delai']) ?></td> <!-- Nouvelle cellule -->
            <td><?= htmlspecialchars($pret['id_typePret']) ?></td>
            <td><?= nl2br(htmlspecialchars($pret['commentaire'])) ?></td>
            <td><?= htmlspecialchars($pret['id_statut']) ?></td>
            <td>
              <form method="post" action="<?= BASE_URL ?>/pret/decision">
                <input type="hidden" name="id" value="<?= htmlspecialchars($pret['id']) ?>">
                <button type="submit" name="action" value="valider" class="valider">Valider</button>
                <button type="submit" name="action" value="refuser" class="refuser">Refuser</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  <?php else: ?>
    <p>Aucune demande de prêt trouvée.</p>
  <?php endif; ?>
</body>

</html>