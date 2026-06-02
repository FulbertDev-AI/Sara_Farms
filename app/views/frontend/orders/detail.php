<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container animate-fade">
    <div style="margin-bottom:2rem;">
        <a href="<?= BASE_URL ?>orders" style="color:var(--primary);text-decoration:none;">← Retour aux commandes</a>
    </div>

    <h2 style="color:var(--primary);margin-bottom:2rem;">Détail Commande #<?= $order['id'] ?></h2>

    <div style="display:grid;grid-template-columns:1fr 350px;gap:2rem;margin-bottom:2rem;">
        <!-- Détails de la commande -->
        <div>
            <div class="glass-panel" style="padding:1.5rem;margin-bottom:1.5rem;">
                <h3 style="margin-bottom:1rem;color:var(--primary);">Informations</h3>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div>
                        <p style="color:var(--text-secondary);font-size:0.9rem;">Date</p>
                        <p style="font-weight:600;"><?= formatDate($order['created_at']) ?></p>
                    </div>
                    <div>
                        <p style="color:var(--text-secondary);font-size:0.9rem;">Statut</p>
                        <p style="font-weight:600;">
                            <?php 
                            $statusLabels = [
                                'en_attente' => 'En attente',
                                'validee' => 'Validée',
                                'rejetee' => 'Rejetée'
                            ];
                            echo $statusLabels[$order['status']] ?? $order['status'];
                            ?>
                        </p>
                    </div>
                    <div>
                        <p style="color:var(--text-secondary);font-size:0.9rem;">Mode de paiement</p>
                        <p style="font-weight:600;">
                            <?php 
                            $paymentLabels = ['livraison' => 'À la livraison', 'mobile_money' => 'Mobile Money'];
                            echo $paymentLabels[$order['payment_method']] ?? $order['payment_method'];
                            ?>
                        </p>
                    </div>
                    <div>
                        <p style="color:var(--text-secondary);font-size:0.9rem;">Statut Paiement</p>
                        <p style="font-weight:600;">
                            <?php if($order['payment_method'] === 'mobile_money'): ?>
                                <?php if($order['payment_status'] === 'pending'): ?>
                                    <span style="color:#FF9800;">⏳ En attente</span>
                                <?php elseif($order['payment_status'] === 'completed'): ?>
                                    <span style="color:#4CAF50;">✓ Confirmé</span>
                                <?php else: ?>
                                    <span style="color:#FF6B6B;">✕ Échoué</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span>-</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Produits -->
            <div class="glass-panel" style="padding:1.5rem;">
                <h3 style="margin-bottom:1rem;color:var(--primary);">Produits</h3>
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:2px solid rgba(0,0,0,0.1);">
                            <th style="padding:0.5rem;text-align:left;">Produit</th>
                            <th style="padding:0.5rem;text-align:right;">Qté</th>
                            <th style="padding:0.5rem;text-align:right;">Prix U.</th>
                            <th style="padding:0.5rem;text-align:right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item): ?>
                        <tr style="border-bottom:1px solid rgba(0,0,0,0.05);">
                            <td style="padding:0.8rem;"><?= htmlspecialchars($item['product_name']) ?></td>
                            <td style="padding:0.8rem;text-align:right;"><?= $item['quantite'] ?></td>
                            <td style="padding:0.8rem;text-align:right;"><?= formatPrice($item['prix_unitaire']) ?></td>
                            <td style="padding:0.8rem;text-align:right;font-weight:600;"><?= formatPrice($item['prix_unitaire'] * $item['quantite']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paiement Mobile Money (si applicable) -->
        <div>
            <div class="glass-panel" style="padding:1.5rem;height:fit-content;">
                <h3 style="margin-bottom:1rem;color:var(--primary);">Total</h3>
                <p style="font-size:1.8rem;font-weight:700;color:var(--secondary);margin-bottom:1.5rem;">
                    <?= formatPrice($order['total_amount']) ?>
                </p>

                <?php if($order['payment_method'] === 'mobile_money'): ?>
                    <div style="background:rgba(255,193,7,0.1);border-left:4px solid #FFC107;padding:1rem;border-radius:4px;margin-bottom:1.5rem;">
                        <p style="font-weight:600;color:#FF9800;margin-bottom:0.5rem;">💳 Paiement Mobile Money</p>
                        <p style="font-size:0.9rem;color:var(--text-secondary);margin:0;">
                            Veuillez effectuer le virement et confirmer votre transaction ci-dessous.
                        </p>
                    </div>

                    <?php if($order['payment_status'] !== 'completed'): ?>
                        <form method="POST" action="<?= BASE_URL ?>orders/confirmMobileMoneyPayment/<?= $order['id'] ?>" style="margin-bottom:1rem;">
                            <div style="margin-bottom:1rem;">
                                <label style="display:block;font-weight:600;margin-bottom:0.5rem;">N° de transaction :</label>
                                <input type="text" name="mobile_money_reference" required placeholder="Ex: TX123456789" 
                                       class="glass-input" style="width:100%;padding:0.8rem;border-radius:6px;">
                            </div>
                            <button type="submit" class="btn" style="width:100%;background:#FFC107;color:#000;font-weight:600;">
                                Confirmer le paiement
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="background:rgba(76,175,80,0.1);border-left:4px solid #4CAF50;padding:1rem;border-radius:4px;">
                            <p style="font-weight:600;color:#4CAF50;margin-bottom:0.5rem;">✓ Paiement confirmé</p>
                            <p style="font-size:0.9rem;margin:0;">
                                N° de transaction : <strong><?= htmlspecialchars($order['mobile_money_reference']) ?></strong>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div style="background:rgba(33,150,243,0.1);border-left:4px solid #2196F3;padding:1rem;border-radius:4px;">
                        <p style="font-weight:600;color:#2196F3;margin-bottom:0.5rem;">🚚 Livraison</p>
                        <p style="font-size:0.9rem;margin:0;">
                            Vous payerez à la livraison de votre commande.
                        </p>
                    </div>
                <?php endif; ?>

                <?php if($order['status'] === 'en_attente' && $order['payment_method'] === 'livraison'): ?>
                    <form method="POST" action="<?= BASE_URL ?>orders/cancel/<?= $order['id'] ?>" style="margin-top:1.5rem;">
                        <button type="submit" class="btn btn-sm" style="width:100%;background:#FF6B6B;" 
                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande?');">
                            Annuler la commande
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
