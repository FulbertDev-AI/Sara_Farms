<?php
require_once __DIR__ . '/../../core/Model.php';
class OrderItem extends Model {
    public function getByOrderId($orderId) {
        return $this->query("
            SELECT oi.*, p.nom as product_name, p.image 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = ?", [$orderId]
        )->fetchAll();
    }
    public function create($orderId, $productId, $qty, $price) {
        return $this->query(
            "INSERT INTO order_items (order_id, product_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)",
            [$orderId, $productId, $qty, $price]
        );
    }
}
?>