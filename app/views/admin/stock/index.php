<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <h2 style="color:var(--primary);">🌱 Gestion des Intrants</h2>
    <a href="<?= BASE_URL ?>admin/stock/create" class="btn">+ Nouvel intrant</a>
</div>

<?php if (!empty($materials)): ?>
<div class="grid">
    <?php foreach ($materials as $m): ?>
    <div class="card glass" style="position:relative;">
        <?php if ($m['stock_actuel'] <= $m['seuil_alerte']): ?>
        <span class="badge badge-warning" style="position:absolute;top:1rem;right:1rem;">⚠️ Stock bas</span>
        <?php endif; ?>
        <h3 style="color:var(--primary);"><?= htmlspecialchars($m['nom']) ?></h3>
        <p style="color:#666;"><?= htmlspecialchars($m['categorie'] ?? 'Non catégorisé') ?></p>
        <div style="margin:1rem 0;">
            <strong>Stock actuel :</strong> <?= $m['stock_actuel'] ?> unités<br>
            <strong>Seuil d'alerte :</strong> <?= $m['seuil_alerte'] ?> unités
        </div>
        <div style="background:#eee;height:8px;border-radius:4px;overflow:hidden;">
            <div style="width:<?= min(100, ($m['stock_actuel'] / max(1, $m['seuil_alerte'])) * 100) ?>%;height:100%;background:<?= $m['stock_actuel'] <= $m['seuil_alerte'] ? 'var(--alert)' : 'var(--secondary)' ?>;"></div>
        </div>
        <form method="POST" action="<?= BASE_URL ?>admin/stock/addStock/<?= $m['id'] ?>" style="margin-top:1rem;display:flex;gap:0.5rem;">
            <input type="number" name="quantite" placeholder="Qté" min="1" required style="padding:8px;border-radius:6px;border:1px solid #ccc;flex:1;">
            <input type="number" name="cout_unitaire" placeholder="Prix unitaire" step="0.01" required style="padding:8px;border-radius:6px;border:1px solid #ccc;flex:1;">
            <button type="submit" class="btn btn-sm">Ajouter</button>
        </form>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p style="text-align:center;padding:2rem;">Aucun intrant enregistré.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>