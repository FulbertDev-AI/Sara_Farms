<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>
<div class="glass-panel" style="max-width:700px;margin:0 auto;padding:2rem;">
    <h2 style="margin-bottom:1.5rem;"><?= isset($product) ? 'Modifier' : 'Ajouter' ?> un produit</h2>
    <form method="POST" action="<?= BASE_URL ?>admin/products/<?= isset($product) ? 'update/'.$product['id'] : 'store' ?>" enctype="multipart/form-data">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1rem;">
            <div><label>Nom</label><input name="nom" required value="<?= $product['nom'] ?? '' ?>" class="glass-input" style="width:100%;"></div>
            <div><label>Prix (FCFA)</label><input name="prix" type="number" step="0.01" required value="<?= $product['prix'] ?? '' ?>" class="glass-input" style="width:100%;"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1rem;">
            <div><label>Catégorie</label><input name="categorie" value="<?= $product['categorie'] ?? '' ?>" class="glass-input" style="width:100%;"></div>
            <div><label>Stock initial</label><input name="stock" type="number" required value="<?= $product['stock_disponible'] ?? 0 ?>" class="glass-input" style="width:100%;"></div>
        </div>
        <div style="margin-bottom:1rem;">
            <label>Description</label>
            <textarea name="description" rows="4" class="glass-input" style="width:100%;"><?= $product['description'] ?? '' ?></textarea>
        </div>
        <div style="margin-bottom:1.5rem;">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" class="glass-input">
            <?php if(isset($product['image'])): ?><img src="<?= BASE_URL ?>assets/images/uploads/<?= $product['image'] ?>" style="width:100px;margin-top:0.5rem;border-radius:8px;"><?php endif; ?>
        </div>
        <button type="submit" class="btn">Enregistrer</button>
    </form>
</div>
<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>