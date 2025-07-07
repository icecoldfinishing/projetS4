<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des séances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">Historique des séances</h2>

    <a href="/listeSeances" class="btn btn-secondary mb-3">← Retour aux séances</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Statut</th>
                <th>Date d'action</th>
                <th>Date de séance</th>
                <th>Heure</th>
                <th>Cours</th>
                <th>Professeur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historiques as $h) : ?>
                <tr>
                    <td><?= htmlspecialchars($h['id_historique']) ?></td>
                    <td><?= htmlspecialchars($h['statut']) ?></td>
                    <td><?= htmlspecialchars($h['date']) ?></td>
                    <td><?= htmlspecialchars($h['date_seance']) ?></td>
                    <td><?= htmlspecialchars($h['heure_debut']) ?> - <?= htmlspecialchars($h['heure_fin']) ?></td>
                    <td><?= htmlspecialchars($h['cours_label']) ?></td>
                    <td><?= htmlspecialchars($h['prof_nom']) ?> <?= htmlspecialchars($h['prof_prenom']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>