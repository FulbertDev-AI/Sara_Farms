<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<section class="container fade-in">
    <h2 style="text-align:center; margin-bottom: 2rem; color: var(--primary);">Notre Boutique</h2>
    <div class="grid">
        <?php foreach ($products as $p): ?>
        <div class="card glass">
            <div style="height:180px; background:#e0e7e3; display:flex; align-items:center; justify-content:center; border-radius:12px; margin-bottom:1rem;">
                <span style="color:#888;">Image produit</span>
            </div>
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <p><?= htmlspecialchars($p['desc']) ?></p>
            <div class="price"><?= number_format($p['price'], 0, ',', ' ') ?> <?= DEFAULT_CURRENCY ?></div>
            <button class="btn" style="width:100%; margin-top:1rem;">Ajouter au panier</button>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>