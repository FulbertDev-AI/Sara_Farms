<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<section class="container animate-fade">
    <h2 style="color:var(--primary);margin-bottom:2rem;">Mes Commandes</h2>
    
    <?php if(empty($orders)): ?>
        <div class="glass-panel" style="padding:3rem;text-align:center;">
            <p>Vous n'avez pas encore passé de commande.</p>
            <a href="<?= BASE_URL ?>shop" class="btn" style="margin-top:1rem;">Découvrir nos produits</a>
        </div>
    <?php else: ?>
        <div class="glass-panel" style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:rgba(0,0,0,0.02);">
                        <th style="padding:1rem;text-align:left;border-bottom:2px solid var(--primary);">N° Commande</th>
                        <th style="padding:1rem;text-align:left;border-bottom:2px solid var(--primary);">Date</th>
                        <th style="padding:1rem;text-align:left;border-bottom:2px solid var(--primary);">Total</th>
                        <th style="padding:1rem;text-align:left;border-bottom:2px solid var(--primary);">Statut</th>
                        <th style="padding:1rem;text-align:left;border-bottom:2px solid var(--primary);">Paiement</th>
                        <th style="padding:1rem;text-align:left;border-bottom:2px solid var(--primary);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                    <tr style="border-bottom:1px solid rgba(0,0,0,0.05);">
                        <td style="padding:1rem;font-weight:600;">#<?= $order['id'] ?></td>
                        <td style="padding:1rem;"><?= formatDate($order['created_at']) ?></td>
                        <td style="padding:1rem;font-weight:600;color:var(--secondary);"><?= formatPrice($order['total_amount']) ?></td>
                        <td style="padding:1rem;">
                            <?php 
                            $statusClasses = [
                                'en_attente' => ['bg' => '#FFA500', 'text' => 'En attente'],
                                'validee' => ['bg' => '#4CAF50', 'text' => 'Validée'],
                                'rejetee' => ['bg' => '#FF6B6B', 'text' => 'Rejetée']
                            ];
                            $status = $statusClasses[$order['status']] ?? ['bg' => '#999', 'text' => $order['status']];
                            ?>
                            <span style="background:<?= $status['bg'] ?>;color:white;padding:0.4rem 0.8rem;border-radius:4px;font-size:0.9rem;">
                                <?= $status['text'] ?>
                            </span>
                        </td>
                        <td style="padding:1rem;">
                            <?php 
                            $paymentLabels = ['livraison' => 'À la livraison', 'mobile_money' => 'Mobile Money'];
                            $paymentMethod = $paymentLabels[$order['payment_method']] ?? $order['payment_method'];
                            echo $paymentMethod;
                            ?>
                            <?php if($order['payment_method'] === 'mobile_money'): ?>
                                <div style="font-size:0.85rem;color:var(--text-secondary);">
                                    <?php if($order['payment_status'] === 'pending'): ?>
                                        <span style="color:#FF9800;">⏳ En attente</span>
                                    <?php elseif($order['payment_status'] === 'completed'): ?>
                                        <span style="color:#4CAF50;">✓ Confirmé</span>
                                    <?php else: ?>
                                        <span style="color:#FF6B6B;">✕ Échoué</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="padding:1rem;">
                            <a href="<?= BASE_URL ?>orders/detail/<?= $order['id'] ?>" class="btn btn-sm" style="background:var(--primary);">Voir détail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
