<style>
    body { font-family: DejaVu Sans, sans-serif; }
    .container { padding: 20px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
</style>

<div class="container">
    <h2>FACTURE DE MATÉRIEL ENDOMMAGÉ</h2>
    <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($facture['date'])) ?></p>
    <p><strong>Destinataire :</strong> <?= htmlspecialchars($destinataire) ?></p>

    <table>
        <thead>
        <tr>
            <th>Numéro de série</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>État</th>
            <th>Montant</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $item['num_serie'] ?></td>
            <td><?= $type['label'] ?></td>
            <td><?= $suivi['description'] ?></td>
            <td><?= $suivi['etat'] ?></td>
            <td><?= number_format($montant, 2, ',', ' ') ?> Ar</td>
        </tr>
        </tbody>
    </table>

    <p style="text-align:right; margin-top: 30px;"><strong>Total :</strong> <?= number_format($montant, 2, ',', ' ') ?> Ar</p>
</div>
