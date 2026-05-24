<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>
<div class="glass-panel" style="padding:2rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
        <h2>Commande #<?= $order['id'] ?></h2>
        <?= statusBadge($order['status']) ?>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:2rem;">
        <div>
            <h4>Client</h4>
            <p><?= htmlspecialchars($order['prenom'] . ' ' . $order['nom']) ?></p>
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
            <tr><td><?= htmlspecialchars($i['product_name']) ?></td><td><?= $i['quantite'] ?></td><td><?= formatPrice($i['prix_unitaire']) ?></td><td><?= formatPrice($i['quantite']*$i['prix_unitaire']) ?></td></tr>
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
<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>