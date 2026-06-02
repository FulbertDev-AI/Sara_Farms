<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>
<div class="glass-panel" style="max-width:700px;margin:0 auto;padding:2rem;">
    <h2 style="margin-bottom:1.5rem;">Modifier un produit</h2>
    <?php if($product): ?>
    <form method="POST" action="<?= BASE_URL ?>admin/products/update/<?= $product['id'] ?>" enctype="multipart/form-data">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1rem;">
            <div><label>Nom</label><input name="nom" required value="<?= htmlspecialchars($product['nom']) ?>" class="glass-input" style="width:100%;"></div>
            <div><label>Prix (FCFA)</label><input name="prix" type="number" step="0.01" required value="<?= $product['prix'] ?>" class="glass-input" style="width:100%;"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1rem;">
            <div><label>Catégorie</label><input name="categorie" value="<?= htmlspecialchars($product['categorie']) ?>" class="glass-input" style="width:100%;"></div>
            <div><label>Stock disponible</label><input name="stock" type="number" required value="<?= $product['stock_disponible'] ?>" class="glass-input" style="width:100%;"></div>
        </div>
        <div style="margin-bottom:1rem;">
            <label>Description</label>
            <textarea name="description" rows="4" class="glass-input" style="width:100%;"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div style="margin-bottom:1.5rem;">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" class="glass-input">
            <?php if($product['image']): ?>
                <div style="margin-top:0.5rem;">
                    <img src="<?= BASE_URL ?>assets/images/uploads/<?= htmlspecialchars($product['image']) ?>" style="width:100px;border-radius:8px;">
                    <p style="font-size:0.9rem;color:var(--text-secondary);margin-top:0.5rem;">Image actuelle</p>
                </div>
            <?php endif; ?>
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn">Enregistrer les modifications</button>
            <a href="<?= BASE_URL ?>admin/products/index" class="btn" style="background:var(--text-secondary);">Annuler</a>
        </div>
    </form>
    <?php else: ?>
        <div style="text-align:center;padding:2rem;">
            <p style="color:var(--alert);">Produit non trouvé.</p>
            <a href="<?= BASE_URL ?>admin/products/index" class="btn" style="margin-top:1rem;">Retour à la liste</a>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>
