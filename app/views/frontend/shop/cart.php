<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container animate-fade">
    <h2 style="color:var(--primary);margin-bottom:2rem;">Votre Panier</h2>
    <?php if(empty($items)): ?>
        <div class="glass-panel" style="padding:3rem;text-align:center;">
            <p>Votre panier est vide.</p>
            <a href="<?= BASE_URL ?>shop" class="btn" style="margin-top:1rem;">Continuer mes achats</a>
        </div>
    <?php else: ?>
        <div class="cart-grid" style="display:grid;grid-template-columns:1fr 350px;gap:2rem;margin-bottom:2rem;">
            <!-- Tableau produits -->
            <div class="glass-panel cart-items-panel" style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead><tr><th>Produit</th><th>Prix</th><th>Quantité</th><th>Sous-total</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach($items as $i): ?>
                        <tr style="border-bottom:1px solid rgba(0,0,0,0.05);">
                            <td style="padding:1rem;"><?= htmlspecialchars($i['nom']) ?></td>
                            <td><?= formatPrice($i['prix']) ?></td>
                            <td>
                                <input type="number" value="<?= $i['qty'] ?>" min="1" class="cart-qty-input glass-input" data-itemid="<?= $i['id'] ?>" data-price="<?= $i['prix'] ?>" style="width:70px;">
                            </td>
                            <td><strong class="item-subtotal" data-price="<?= $i['prix'] ?>" data-qty="<?= $i['qty'] ?>"><?= formatPrice($i['subtotal']) ?></strong></td>
                            <td><a href="<?= BASE_URL ?>cart/remove/<?= $i['id'] ?>" class="btn btn-sm" style="background:var(--alert);">✕</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Résumé et paiement -->
            <div class="glass-panel cart-summary" style="padding:1.5rem;height:fit-content;">
                <h3 style="margin-bottom:1rem;">Résumé</h3>
                <div style="margin-bottom:1.5rem;border-bottom:1px solid rgba(0,0,0,0.1);padding-bottom:1rem;">
                    <p class="cart-total-value" style="font-size:1.5rem;font-weight:700;color:var(--secondary);margin-bottom:1rem;">Total: <?= formatPrice($total) ?></p>
                </div>

                <form action="<?= BASE_URL ?>cart/checkout" method="POST" style="margin-top:1rem;">
                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block;font-weight:600;margin-bottom:0.8rem;">Mode de paiement :</label>
                        
                        <!-- Option Livraison -->
                        <label style="display:flex;align-items:center;margin-bottom:1rem;cursor:pointer;padding:0.8rem;border-radius:8px;background:rgba(255,255,255,0.5);transition:all 0.3s;">
                            <input type="radio" name="payment_method" value="livraison" checked style="margin-right:0.8rem;cursor:pointer;">
                            <div>
                                <strong>À la livraison</strong>
                                <p style="font-size:0.9rem;color:var(--text-secondary);margin:0;">Payez lors de la réception</p>
                            </div>
                        </label>

                        <!-- Option Mobile Money -->
                        <label style="display:flex;align-items:center;margin-bottom:0;cursor:pointer;padding:0.8rem;border-radius:8px;background:rgba(255,255,255,0.5);transition:all 0.3s;">
                            <input type="radio" name="payment_method" value="mobile_money" style="margin-right:0.8rem;cursor:pointer;">
                            <div>
                                <strong>Mobile Money</strong>
                                <p style="font-size:0.9rem;color:var(--text-secondary);margin:0;">Orange Money, MTN Money, etc.</p>
                            </div>
                        </label>
                    </div>

                    <button type="submit" class="btn" style="width:100%;">Valider la commande</button>
                </form>

                <a href="<?= BASE_URL ?>shop" style="display:block;text-align:center;margin-top:1rem;color:var(--text-secondary);text-decoration:none;">← Continuer les achats</a>
            </div>
        </div>
    <?php endif; ?>
</section>

<style>
label[style*="display:flex"] input[type="radio"]:checked + div {
    font-weight:700;
    color:var(--primary);
}

@media (max-width: 768px) {
    .cart-grid {
        grid-template-columns: 1fr !important;
    }
    .cart-items-panel,
    .cart-summary {
        width: 100%;
    }
    .cart-summary {
        order: 2;
    }
    .cart-items-panel {
        order: 1;
    }
    table {
        width: 100%;
        min-width: auto;
    }
    table thead tr th,
    table tbody tr td {
        padding: 0.75rem;
    }
}
</style>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>