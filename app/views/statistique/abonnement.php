<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques d'Abonnement</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .pie-chart-container, .chart-container {
            height: 250px;
            position: relative;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
        .alert-indicator {
            border-left: 4px solid;
            padding-left: 10px;
        }
        .alert-danger {
            border-left-color: #dc3545;
        }
        .alert-success {
            border-left-color: #28a745;
        }
        .profit-positive {
            color: #28a745;
        }
        .profit-negative {
            color: #dc3545;
        }

        /* Ajustement responsive et équilibre de hauteur */
        .card-body.text-center h3 {
            font-size: 1.75rem;
            margin: 0.5rem 0;
        }

        /* Harmonisation des hauteurs de cartes */
        .card.shadow-sm {
            height: 100%;
        }

        /* Forcer les cartes à avoir la même hauteur dans la row des indicateurs */
        .row.mb-4 > div[class^="col-"] {
            display: flex;
            flex-direction: column;
        }

        /* Réduire les marges verticales inutiles dans les tableaux et alertes */
        .card-body .alert-indicator,
        .card-body .table {
            margin-bottom: 0.5rem;
        }

        /* Espacement plus naturel entre les badges sous le pie chart */
        .pie-chart-container + .mt-3 span {
            margin-bottom: 0.25rem;
        }

        /* Réduction padding graphique pour un rendu plus équilibré */
        .chart-container,
        .pie-chart-container {
            padding: 0.5rem;
        }


    </style>
</head>
<body>
    <div id="app">
        <?= Flight::menuAdmin() ?>
        <div id="main">
            <div class="page-heading">
                <h3>Statistique d'Abonnement</h3>
                <p class="text-muted">Données pour <?= date('F Y', mktime(0, 0, 0, $month, 1, $year)) ?></p>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0 fw-semibold">Vue d'ensemble</h4>
                                <div class="d-flex align-items-center">
                                    <select class="form-select me-2" id="monthSelect" style="width: 150px;">
                                        <?php for ($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>
                                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                    <select class="form-select me-2" id="yearSelect" style="width: 100px;">
                                        <?php for ($y = date('Y') - 2; $y <= date('Y'); $y++): ?>
                                            <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>><?= $y ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <button class="btn btn-primary" onclick="updateStats()">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Actualiser
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Cartes de résumé -->
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="card shadow-sm">
                                            <div class="card-body text-center">
                                                <h6>Total Clients</h6>
                                                <h3 id="totalClients"><?= number_format($totalClients, 0) ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card shadow-sm">
                                            <div class="card-body text-center">
                                                <h6>Réabonnements</h6>
                                                <h3 id="totalResubscriptions"><?= number_format($totalReabonnement, 0) ?></h3>
                                                <small class="text-muted"><?= $reabonnementPourcentage ?>% du total</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card shadow-sm">
                                            <div class="card-body text-center">
                                                <h6>Nouveaux clients</h6>
                                                <h3 id="totalNew"><?= number_format($totalNouveau, 0) ?></h3>
                                                <small class="text-muted"><?= $nouveauPourcentage ?>% du total</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card shadow-sm">
                                            <div class="card-body text-center">
                                                <h6>Revenus mensuels</h6>
                                                <h3 class="<?= $profit >= 0 ? 'text-success' : 'text-danger' ?>">
                                                    <?= number_format($revenue, 0, ',', ' ') ?> Ar
                                                </h3>
                                                <small class="<?= $profit >= 0 ? 'text-success' : 'text-danger' ?>">
                                                    Bénéfice: <?= number_format($profit, 0, ',', ' ') ?> Ar
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Graphiques -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6><i class="bi bi-pie-chart me-2"></i>Répartition</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="pie-chart-container">
                                                    <canvas id="subPieChart"></canvas>
                                                </div>
                                                <div class="mt-3 text-center">
                                                    <span class="badge bg-primary me-2">
                                                        Réabonnement: <?= $reabonnementPourcentage ?>%
                                                    </span>
                                                    <span class="badge bg-info">
                                                        Nouveau: <?= $nouveauPourcentage ?>%
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6><i class="bi bi-bar-chart me-2"></i>Évolution Mensuelle</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-container">
                                                    <canvas id="subBarChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alertes et indicateurs -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Alertes</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert-indicator mb-3 <?= strpos($occupancyAlert, 'OK') !== false ? 'alert-success' : 'alert-danger' ?>">
                                                    <strong>Taux d'occupation:</strong> <?= $occupancyRate ?>%<br>
                                                    <?= $occupancyAlert ?>
                                                </div>
                                                <div class="alert-indicator <?= strpos($unsubscribeAlert, 'OK') !== false ? 'alert-success' : 'alert-danger' ?>">
                                                    <strong>Taux de désabonnement:</strong> <?= $unsubscribeRate ?>%<br>
                                                    <?= $unsubscribeAlert ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6><i class="fas fa-users me-2"></i>Présence par activité</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Activité</th>
                                                                <th>Participants</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($attendanceData as $activity): ?>
                                                                <tr>
                                                                    <td><?= htmlspecialchars($activity['label']) ?></td>
                                                                    <td><?= $activity['participants'] ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>

    <script>
        // Données pour les graphiques
        const monthlyData = <?= json_encode($monthlyData ?? []) ?>;
        const months = monthlyData.map(item => item.month);
        const resubData = monthlyData.map(item => Math.round(item.inscriptions * item.renewalRate / 100));
        const newData = monthlyData.map(item => Math.round(item.inscriptions * (100 - item.renewalRate) / 100));

        // Graphique en secteurs
        const pieCtx = document.getElementById('subPieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Réabonnement', 'Nouveau'],
                datasets: [{
                    data: [<?= $totalReabonnement ?>, <?= $totalNouveau ?>],
                    backgroundColor: ['#667eea', '#4facfe'],
                    borderColor: '#ffffff',
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Graphique en barres
        const barCtx = document.getElementById('subBarChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Réabonnement',
                        data: resubData,
                        backgroundColor: '#667eea',
                        borderRadius: 4
                    },
                    {
                        label: 'Nouveau',
                        data: newData,
                        backgroundColor: '#4facfe',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        // Fonction pour actualiser les données
        function updateStats() {
            const year = document.getElementById('yearSelect').value;
            const month = document.getElementById('monthSelect').value;
            window.location.href = `abonnement?year=${year}&month=${month}`;
        }
    </script>
</body>
</html>