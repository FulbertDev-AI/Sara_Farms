<?php require_once __DIR__ . '/../layouts/admin-header.php'; ?>

<!-- Alertes Stock -->
<?php if (!empty($alerts)): ?>
<div class="alerts-panel glass">
    <h4>⚠️ Alertes Stock</h4>
    <ul class="alerts-list">
        <?php foreach ($alerts as $alert): ?>
        <li><strong><?= htmlspecialchars($alert['nom']) ?></strong> : <?= $alert['stock_actuel'] ?>/<?= $alert['seuil_alerte'] ?> unités</li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <h4>Commandes (24h)</h4>
        <div class="value"><?= $stats['orders_count'] ?></div>
        <div class="trend up">↗ +<?= $stats['orders_count'] ?> aujourd'hui</div>
    </div>
    <div class="stat-card">
        <h4>Ventes (24h)</h4>
        <div class="value"><?= number_format($stats['orders_value'], 0, ',', ' ') ?> FCFA</div>
        <div class="trend up">↗ Chiffre d'affaires</div>
    </div>
    <div class="stat-card">
        <h4>Revenus du jour</h4>
        <div class="value"><?= number_format($stats['daily_revenue'], 0, ',', ' ') ?> FCFA</div>
        <div class="trend up">↗ Encaissé</div>
    </div>
    <div class="stat-card">
        <h4>Total Clients</h4>
        <div class="value"><?= $totalClients ?></div>
        <div class="trend">👥 Inscrits depuis le début</div>
    </div>
</div>

<!-- Graphiques -->
<div class="charts-grid">
    <div class="chart-card">
        <h3>Évolution des ventes (7 derniers jours)</h3>
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <h3>Répartition par catégorie</h3>
        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<!-- Dernières Commandes -->
<div class="table-card">
    <h3>📋 Dernières commandes</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentOrders as $order): ?>
            <tr>
                <td>#<?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['prenom'] . ' ' . $order['nom']) ?></td>
                <td><strong><?= number_format($order['total_amount'], 0, ',', ' ') ?> FCFA</strong></td>
                <td>
                    <span class="badge badge-<?= $order['status'] === 'validee' ? 'success' : ($order['status'] === 'rejetee' ? 'danger' : 'warning') ?>">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                <td class="btn-group">
                    <a href="<?= BASE_URL ?>admin/orders/detail/<?= $order['id'] ?>" class="btn btn-sm btn-outline">Voir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// Graphique des ventes
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        datasets: [{
            label: 'Ventes (FCFA)',
            data: [120000, 190000, 150000, 220000, 180000, 250000, <?= $stats['daily_revenue'] ?>],
            borderColor: '#2C5E43',
            backgroundColor: 'rgba(44, 94, 67, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { display: false } }
        }
    }
});

// Graphique catégories
const catCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(catCtx, {
    type: 'doughnut',
    data: {
        labels: ['Volailles', 'Céréales', 'Maraîchage', 'Élevage'],
        datasets: [{
            data: [35, 25, 25, 15],
            backgroundColor: ['#2C5E43', '#88B04B', '#D97736', '#5A7F67']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/admin-footer.php'; ?>