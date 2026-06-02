<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container fade-in">
    <h2 style="text-align:center; margin-bottom: 2rem; color: var(--primary);">Notre Boutique</h2>
    <div class="grid">
        <?php foreach ($products as $p): ?>
        <div class="card glass">
            <div style="height:180px; display:flex; align-items:center; justify-content:center; border-radius:12px; margin-bottom:1rem; overflow:hidden; background:#eaf0eb;">
                <?php
                $placeholder = BASE_URL . 'assets/images/placeholder.svg';
                $serverUploadPath = $_SERVER['DOCUMENT_ROOT'] . '/sara_farms/public/assets/images/uploads/' . ($p['image'] ?? '');
                $imgUrl = '';
                if (!empty($p['image']) && file_exists($serverUploadPath)) {
                    $imgUrl = BASE_URL . 'assets/images/uploads/' . $p['image'];
                } else {
                    $imgUrl = $placeholder;
                }
                ?>
                <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($p['nom'] ?? 'Produit') ?>" style="max-height:100%; max-width:100%; object-fit:cover;">
            </div>
            <h3><?= htmlspecialchars($p['nom'] ?? ($p['name'] ?? '')) ?></h3>
            <p><?= htmlspecialchars($p['description'] ?? ($p['desc'] ?? '')) ?></p>
            <div class="price"><?= number_format($p['prix'] ?? ($p['price'] ?? 0), 0, ',', ' ') ?> FCFA</div>
            
            <!-- Formulaire POST fiable (pas de JS complexe pour l'instant) -->
            <form method="POST" action="<?= BASE_URL ?>cart/add/<?= $p['id'] ?? '' ?>" style="margin-top:1rem;">
                <button type="submit" class="btn" style="width:100%;">Ajouter au panier</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>