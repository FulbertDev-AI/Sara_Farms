<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <h2 style="color:var(--primary);">📦 Gestion des Produits</h2>
    <a href="<?= BASE_URL ?>admin/products/create" class="btn">+ Ajouter un produit</a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><img src="<?= BASE_URL ?>assets/images/uploads/<?= $p['image'] ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;"></td>
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= htmlspecialchars($p['categorie'] ?? '-') ?></td>
                <td><strong><?= number_format($p['prix'], 0, ',', ' ') ?> FCFA</strong></td>
                <td>
                    <span class="badge badge-<?= $p['stock_disponible'] <= 10 ? 'warning' : 'success' ?>">
                        <?= $p['stock_disponible'] ?>
                    </span>
                </td>
                <td><span class="badge badge-success">Actif</span></td>
                <td class="btn-group">
                    <a href="<?= BASE_URL ?>admin/products/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline">✏️</a>
                    <a href="<?= BASE_URL ?>admin/products/delete/<?= $p['id'] ?>" class="btn btn-sm" style="background:var(--alert);" onclick="return confirm('Supprimer ce produit ?')">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>