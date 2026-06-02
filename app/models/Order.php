<?php
require_once __DIR__ . '/../../core/Model.php';

class Order extends Model {
    public function create($userId, $total, $paymentMethod = 'livraison') {
        $this->query("INSERT INTO orders (user_id, total_amount, payment_method) VALUES (?, ?, ?)", [$userId, $total, $paymentMethod]);
        return $this->db->lastInsertId();
    }

    public function addItem($orderId, $productId, $qty, $price) {
        $this->query("INSERT INTO order_items (order_id, product_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)", [$orderId, $productId, $qty, $price]);
    }

    public function getUserOrders($userId) {
        return $this->query("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC", [$userId])->fetchAll();
    }

    public function getAllOrders() {
        return $this->query("
            SELECT o.*, u.nom, u.prenom 
            FROM orders o 
            JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC
        ")->fetchAll();
    }

    public function findById($id) {
        return $this->query(
            "SELECT o.*, u.nom, u.prenom FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ? LIMIT 1",
            [$id]
        )->fetch();
    }

    public function getItemsByOrderId($orderId) {
        return $this->query(
            "SELECT oi.*, p.nom AS product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?",
            [$orderId]
        )->fetchAll();
    }

    public function updateStatus($id, $status, $motif = null) {
        $sql = "UPDATE orders SET status = ?, motif_rejet = ? WHERE id = ?";
        $this->query($sql, [$status, $motif, $id]);
    }

    public function getOrdersLast24h() {
        return $this->query("
            SELECT COUNT(*) as count, COALESCE(SUM(total_amount), 0) as total 
            FROM orders 
            WHERE created_at >= NOW() - INTERVAL 24 HOUR
        ")->fetch();
    }
}
?>