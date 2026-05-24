<?php
require_once __DIR__ . '/../../core/Model.php';
class Stock extends Model {
    public function getMovements($type = null, $limit = 50) {
        $sql = "SELECT * FROM stock_movements ORDER BY date_mouvement DESC LIMIT ?";
        return $type ? $this->query($sql, [$type, $limit])->fetchAll() : $this->query($sql, [$limit])->fetchAll();
    }
    public function adjust($typeElement, $elementId, $type, $qty, $cost, $desc) {
        $this->query(
            "INSERT INTO stock_movements (type_element, element_id, type_mouvement, quantite, cout_unitaire, description) VALUES (?, ?, ?, ?, ?, ?)",
            [$typeElement, $elementId, $type, $qty, $cost, $desc]
        );
    }
    public function getLowStock($threshold = null) {
        $sql = "SELECT * FROM raw_materials WHERE stock_actuel <= seuil_alerte";
        return $threshold ? $this->query($sql . " AND stock_actuel <= ?", [$threshold])->fetchAll() 
                          : $this->query($sql)->fetchAll();
    }
}
?>