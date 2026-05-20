<section class="breadcrumb">Administration • Tableau de bord</section>
<section class="dashboard-grid">
    <article class="kpi-card">
        <div>
            <strong><?= number_format(array_sum($salesValues), 0, ',', ' ') ?> FCFA</strong>
            <small>Ventes totales sur la période</small>
        </div>
    </article>
    <article class="kpi-card alert">
        <div>
            <strong><?= count($alertIntrants) ?></strong>
            <small>Alertes de stocks bas</small>
        </div>
    </article>
    <article class="kpi-card">
        <div>
            <strong><?= intval($activeCulturesCount ?? 0) ?></strong>
            <small>Parcelles actives</small>
        </div>
    </article>
</section>

<section class="dashboard-panel">
    <div class="chart-wrapper" style="min-height: 360px;">
        <div class="alert-row">
            <h3>Évolution des ventes</h3>
            <span class="alert-indicator"><span class="alert-pill"></span> Objectif mensuel</span>
        </div>
        <canvas id="dashboardChart" style="width: 100%; height: 320px;"></canvas>
    </div>

    <div class="table-wrapper">
        <h3>Intrants en rupture ou stock bas</h3>
        <?php if (empty($alertIntrants)): ?>
            <p>Aucun intrant critique pour le moment. Les stocks sont stables.</p>
        <?php else: ?>
            <table class="table-simple">
                <thead>
                    <tr>
                        <th>Intrant</th>
                        <th>Catégorie</th>
                        <th>Quantité</th>
                        <th>Seuil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alertIntrants as $stock): ?>
                        <tr>
                            <td><?= htmlspecialchars($stock['nom']) ?></td>
                            <td><?= htmlspecialchars($stock['categorie']) ?></td>
                            <td><?= number_format((float)$stock['quantite_disponible'], 2, ',', ' ') ?> <?= htmlspecialchars($stock['unite_mesure']) ?></td>
                            <td><?= number_format((float)$stock['seuil_alerte'], 2, ',', ' ') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>

<script>
    window.dashboardSalesLabels = <?= json_encode($salesLabels, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    window.dashboardSalesValues = <?= json_encode($salesValues, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
</script>
