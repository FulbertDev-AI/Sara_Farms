<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>
<div class="glass-panel order-detail-panel" style="padding:2rem;">
    <div class="order-detail-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
        <h2>Commande #<?= $order['id'] ?></h2>
        <?= statusBadge($order['status']) ?>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:2rem;">
        <div>
            <h4>Client</h4>
            <p>
                <?= htmlspecialchars(
                    trim(
                        ($order['prenom'] ?? '') . ' ' . ($order['nom'] ?? '')
                    ) ?: 'Client inconnu'
                ) ?>
            </p>
            <p><?= formatDate($order['created_at']) ?></p>
        </div>
        <div>
            <h4>Total</h4>
            <p style="font-size:1.4rem;font-weight:700;color:var(--primary);"><?= formatPrice($order['total_amount']) ?></p>
        </div>
    </div>
    <h3 style="margin-bottom:1rem;">Articles</h3>
    <table style="width:100%;margin-bottom:2rem;">
        <thead><tr><th>Produit</th><th>Qté</th><th>Prix unit.</th><th>Total</th></tr></thead>
        <tbody>
            <?php foreach($items as $i): ?>
            <tr>
                <td data-label="Produit"><?= htmlspecialchars($i['product_name'] ?? 'Produit inconnu') ?></td>
                <td data-label="Qté"><?= isset($i['quantite']) ? $i['quantite'] : '—' ?></td>
                <td data-label="Prix unit."><?= formatPrice($i['prix_unitaire'] ?? 0) ?></td>
                <td data-label="Total"><?= formatPrice((isset($i['quantite']) ? $i['quantite'] : 0) * ($i['prix_unitaire'] ?? 0)) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if($order['status'] == 'en_attente'): ?>
    <div style="display:flex;gap:1rem;">
        <form method="POST" action="<?= BASE_URL ?>admin/orders/validate/<?= $order['id'] ?>">
            <button type="submit" class="btn">✓ Valider</button>
        </form>
        <button class="btn" style="background:var(--alert);" onclick="document.getElementById('rejectForm').style.display='block'">✗ Rejeter</button>
    </div>
    <form id="rejectForm" method="POST" action="<?= BASE_URL ?>admin/orders/reject/<?= $order['id'] ?>" style="display:none;margin-top:1rem;">
        <textarea name="motif" required placeholder="Motif du rejet..." style="width:100%;padding:1rem;border-radius:8px;border:1px solid #ccc;"></textarea>
        <button type="submit" class="btn" style="background:var(--alert);margin-top:0.5rem;">Confirmer le rejet</button>
    </form>
    <?php elseif($order['motif_rejet']): ?>
    <div style="background:rgba(217,119,54,0.1);padding:1rem;border-radius:8px;border:1px solid var(--alert);">
        <strong>Motif de rejet :</strong> <?= htmlspecialchars($order['motif_rejet']) ?>
    </div>
    <?php endif; ?>
</div>
<style>
@media (max-width: 768px) {
    .order-detail-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    .order-detail-panel {
        padding: 1rem;
    }
    .order-detail-panel table {
        width: 100%;
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    .order-detail-panel table thead,
    .order-detail-panel table tbody,
    .order-detail-panel table tr,
    .order-detail-panel table th,
    .order-detail-panel table td {
        display: block;
    }
    .order-detail-panel table tr { margin-bottom: 1rem; }
    .order-detail-panel table th { display: none; }
    .order-detail-panel table td {
        padding: 0.75rem 0;
        border: none;
        position: relative;
    }
    .order-detail-panel table td::before {
        content: attr(data-label);
        font-weight: 700;
        display: block;
        margin-bottom: 0.3rem;
    }
}
</style>
<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>