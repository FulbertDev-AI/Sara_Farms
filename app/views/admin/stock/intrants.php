<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>
<h2 style="margin-bottom:1.5rem;">📦 Gestion des Intrants</h2>
<div class="glass-panel" style="padding:1.5rem;">
    <form method="POST" action="<?= BASE_URL ?>admin/stock/add" style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:1rem;align-items:end;">
        <div><label>Intrant</label><select name="material_id" class="glass-input" style="width:100%;">
            <?php foreach($materials as $m): ?><option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nom']) ?> (Stock: <?= $m['stock_actuel'] ?>)</option><?php endforeach; ?>
        </select></div>
        <div><label>Quantité</label><input name="qty" type="number" required class="glass-input" style="width:100%;"></div>
        <div><label>Coût unitaire</label><input name="cost" type="number" step="0.01" required class="glass-input" style="width:100%;"></div>
        <button type="submit" class="btn">Ajouter</button>
    </form>
</div>
<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>