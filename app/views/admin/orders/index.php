<?php require_once __DIR__ . '/../../layouts/admin-header.php'; ?>

<h2 style="color:var(--primary);margin-bottom:1.5rem;">🛒 Gestion des Commandes</h2>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Commande</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><strong>#<?= $order['id'] ?></strong></td>
                <td><?= htmlspecialchars($order['prenom'] . ' ' . $order['nom']) ?></td>
                <td><?= number_format($order['total_amount'], 0, ',', ' ') ?> FCFA</td>
                <td>
                    <span class="badge badge-<?= $order['status'] === 'validee' ? 'success' : ($order['status'] === 'rejetee' ? 'danger' : 'warning') ?>">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </td>
                <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                <td class="btn-group">
                    <a href="<?= BASE_URL ?>admin/orders/detail/<?= $order['id'] ?>" class="btn btn-sm btn-outline">Détail</a>
                    <?php if ($order['status'] === 'en_attente'): ?>
                        <form method="POST" action="<?= BASE_URL ?>admin/orders/validate/<?= $order['id'] ?>" style="display:inline;">
                            <button type="submit" class="btn btn-sm" style="background:var(--secondary);">✓ Valider</button>
                        </form>
                        <button class="btn btn-sm" style="background:var(--alert);" onclick="openRejectModal(<?= $order['id'] ?>)">✗ Rejeter</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Rejet -->
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <h3 style="margin-bottom:1rem;color:var(--alert);">Motif de rejet</h3>
        <form method="POST" id="rejectForm">
            <div class="form-group">
                <textarea name="motif" rows="3" required placeholder="Ex: Produit indisponible, rupture de stock..."></textarea>
            </div>
            <div style="display:flex;gap:1rem;justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="closeRejectModal()">Annuler</button>
                <button type="submit" class="btn" style="background:var(--alert);">Confirmer le rejet</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(orderId) {
    document.getElementById('rejectForm').action = '<?= BASE_URL ?>admin/orders/reject/' + orderId;
    document.getElementById('rejectModal').classList.add('active');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('active');
}
</script>

<?php require_once __DIR__ . '/../../layouts/admin-footer.php'; ?>