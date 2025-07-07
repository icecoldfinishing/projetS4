<h2>Historique des Gardes</h2>
<a href="<?= Flight::base() ?>/historique-garde/create" class="btn btn-primary mb-3">Nouvel enregistrement</a>
<table class="table table-bordered">
    <thead>
    <tr><th>Superviseur</th><th>Date</th><th>Heure</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($historiques as $h): ?>
        <tr>
            <td><?= htmlspecialchars($h['nom'] . ' ' . $h['prenom']) ?></td>
            <td><?= $h['date'] ?></td>
            <td><?= $h['heure'] ?></td>
            <td>
                <a href="<?= Flight::base() ?>/historique-garde/edit/<?= $h['id_historique'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="<?= Flight::base() ?>/historique-garde/delete/<?= $h['id_historique'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>