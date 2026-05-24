<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container animate-fade">
    <div class="glass-panel" style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;padding:2rem;">
        <div style="background:#f0f4f0;border-radius:12px;height:300px;display:flex;align-items:center;justify-content:center;">
            <img src="<?= BASE_URL ?>assets/images/uploads/<?= $product['image'] ?>" alt="<?= $product['nom'] ?>" style="max-height:90%;border-radius:8px;">
        </div>
        <div>
            <h1 style="color:var(--primary);margin-bottom:0.5rem;"><?= htmlspecialchars($product['nom']) ?></h1>
            <p style="font-size:1.8rem;font-weight:700;color:var(--secondary);margin-bottom:1rem;"><?= formatPrice($product['prix']) ?></p>
            <p style="margin-bottom:1.5rem;line-height:1.6;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            <div style="margin-bottom:1.5rem;">
                <strong>Stock :</strong> <span style="color:<?= $product['stock_disponible'] > 0 ? 'var(--secondary)' : 'var(--alert)' ?>;">
                    <?= $product['stock_disponible'] > 0 ? $product['stock_disponible'] . ' disponibles' : 'Rupture de stock' ?>
                </span>
            </div>
            <?php if($product['stock_disponible'] > 0): ?>
            <form action="<?= BASE_URL ?>cart/add/<?= $product['id'] ?>" method="POST" style="display:flex;gap:1rem;">
                <input type="number" name="qty" value="1" min="1" max="<?= $product['stock_disponible'] ?>" class="glass-input" style="width:80px;">
                <button type="submit" class="btn">Ajouter au panier</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>