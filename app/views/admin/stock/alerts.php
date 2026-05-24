<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>
<h2 style="margin-bottom:1.5rem;">⚠️ Alertes Stock Bas</h2>
<div class="glass-panel" style="padding:1.5rem;">
    <?php if(empty($alerts)): ?>
        <p style="text-align:center;padding:2rem;">Aucune alerte. Tous les stocks sont au-dessus des seuils.</p>
    <?php else: ?>
        <table style="width:100%;">
            <thead><tr><th>Intrant</th><th>Stock Actuel</th><th>Seuil</th><th>Statut</th><th>Action</th></tr></thead>
            <tbody>
                <?php foreach($alerts as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['nom']) ?></td>
                    <td style="color:var(--alert);font-weight:700;"><?= $a['stock_actuel'] ?></td>
                    <td><?= $a['seuil_alerte'] ?></td>
                    <td><span class="badge badge-warning">Critique</span></td>
                    <td><a href="<?= BASE_URL ?>admin/stock/intrants" class="btn btn-sm">Réapprovisionner</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>