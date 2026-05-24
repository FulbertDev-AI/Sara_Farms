<?php
require_once __DIR__ . '/../../core/Model.php';

class StockMovement extends Model {
    public function log($typeElement, $elementId, $typeMouvement, $qty, $cost, $desc) {
        $sql = "INSERT INTO stock_movements (type_element, element_id, type_mouvement, quantite, cout_unitaire, description) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $this->query($sql, [$typeElement, $elementId, $typeMouvement, $qty, $cost, $desc]);
    }

    public function getRecent($limit = 50) {
        return $this->query("SELECT * FROM stock_movements ORDER BY date_mouvement DESC LIMIT ?", [$limit])->fetchAll();
    }
}
?>