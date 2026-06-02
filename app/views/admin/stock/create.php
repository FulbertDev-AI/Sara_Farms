<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>

<div class="glass-panel" style="max-width:760px;margin:0 auto;padding:2rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <div>
            <h2 style="color:var(--primary);margin:0;">Ajouter un nouvel intrant</h2>
            <p style="color:#556b55;margin:0.5rem 0 0;">Enregistrez un nouveau matériel ou intrant pour la gestion de stock.</p>
        </div>
        <a href="<?= BASE_URL ?>admin/stock/index" class="btn btn-outline" style="padding:0.9rem 1.2rem;">Retour aux intrants</a>
    </div>

    <form method="POST" action="<?= BASE_URL ?>admin/stock/store" style="display:grid;gap:1.2rem;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div>
                <label>Nom de l'intrant</label>
                <input type="text" name="nom" required class="glass-input" style="width:100%;padding:0.85rem;border-radius:12px;border:1px solid #d8e4d3;">
            </div>
            <div>
                <label>Catégorie</label>
                <input type="text" name="categorie" class="glass-input" style="width:100%;padding:0.85rem;border-radius:12px;border:1px solid #d8e4d3;">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div>
                <label>Stock initial</label>
                <input type="number" name="stock" required min="0" class="glass-input" style="width:100%;padding:0.85rem;border-radius:12px;border:1px solid #d8e4d3;">
            </div>
            <div>
                <label>Seuil d'alerte</label>
                <input type="number" name="seuil" required min="0" value="10" class="glass-input" style="width:100%;padding:0.85rem;border-radius:12px;border:1px solid #d8e4d3;">
            </div>
        </div>

        <button type="submit" class="btn" style="width:160px;">Enregistrer</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>