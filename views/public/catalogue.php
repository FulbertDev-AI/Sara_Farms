<section class="card">
    <div class="breadcrumb">Catalogue • Produits disponibles</div>
    <h2>Produits de la ferme</h2>
    <?php if (empty($produits)): ?>
        <p>Aucun produit disponible pour le moment.</p>
    <?php else: ?>
        <table class="table-simple">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['nom_produit']) ?></td>
                        <td><?= htmlspecialchars($produit['description']) ?></td>
                        <td><?= number_format((float)$produit['prix_unitaire'], 2, ',', ' ') ?> <?= htmlspecialchars($produit['unite_vente']) ?></td>
                        <td><?= intval($produit['stock_disponible']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
