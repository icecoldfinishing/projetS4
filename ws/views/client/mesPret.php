<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Demandes de Prêt</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
      vertical-align: middle;
    }
    th {
      background-color: #eee;
    }
  </style>
</head>
<body>
  <h1>Demandes de Prêt</h1>

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
          <th>Délai mensuel</th>
          <th>Type de prêt</th>
          <th>Commentaire</th>
          <th>Statut</th>
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
            <td><?= htmlspecialchars($pret['delai']) ?></td>
            <td><?= htmlspecialchars($pret['id_typePret']) ?></td>
            <td><?= nl2br(htmlspecialchars($pret['commentaire'])) ?></td>
            <td><?= htmlspecialchars($pret['id_statut']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Aucune demande de prêt trouvée.</p>
  <?php endif; ?>
</body>
</html>
