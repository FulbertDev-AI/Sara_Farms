<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container animate-fade">
    <h2 style="color:var(--primary);margin-bottom:2rem;">Votre Panier</h2>
    <?php if(empty($items)): ?>
        <div class="glass-panel" style="padding:3rem;text-align:center;">
            <p>Votre panier est vide.</p>
            <a href="<?= BASE_URL ?>shop" class="btn" style="margin-top:1rem;">Continuer mes achats</a>
        </div>
    <?php else: ?>
        <div class="glass-panel" style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead><tr><th>Produit</th><th>Prix</th><th>Quantité</th><th>Sous-total</th><th></th></tr></thead>
                <tbody>
                    <?php foreach($items as $i): ?>
                    <tr style="border-bottom:1px solid rgba(0,0,0,0.05);">
                        <td style="padding:1rem;"><?= htmlspecialchars($i['nom']) ?></td>
                        <td><?= formatPrice($i['prix']) ?></td>
                        <td><input type="number" value="<?= $i['qty'] ?>" min="1" class="cart-qty-input glass-input" data-itemid="<?= $i['id'] ?>" style="width:70px;"></td>
                        <td><strong><?= formatPrice($i['subtotal']) ?></strong></td>
                        <td><a href="<?= BASE_URL ?>cart/remove/<?= $i['id'] ?>" class="btn btn-sm" style="background:var(--alert);">✕</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="display:flex;justify-content:flex-end;margin-top:2rem;">
            <div class="glass-panel" style="padding:1.5rem;min-width:250px;">
                <h3 style="margin-bottom:1rem;">Total</h3>
                <p style="font-size:1.5rem;font-weight:700;color:var(--secondary);"><?= formatPrice($total) ?></p>
                <form action="<?= BASE_URL ?>cart/checkout" method="POST" style="margin-top:1rem;">
                    <button type="submit" class="btn" style="width:100%;">Valider la commande</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>