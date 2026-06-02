<?php
require_once __DIR__ . '/../../core/Model.php';

class RawMaterial extends Model {
    public function getAll() {
        return $this->query("SELECT * FROM raw_materials ORDER BY nom ASC")->fetchAll();
    }

    public function findById($id) {
        return $this->query("SELECT * FROM raw_materials WHERE id = ? LIMIT 1", [$id])->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO raw_materials (nom, categorie, stock_actuel, seuil_alerte) VALUES (?, ?, ?, ?)";
        $this->query($sql, [$data['nom'], $data['categorie'] ?? null, $data['stock'], $data['seuil']]);
        return true;
    }

    public function updateStock($id, $qty, $operation = 'decrement') {
        if ($operation === 'decrement') {
            $this->query("UPDATE raw_materials SET stock_actuel = stock_actuel - ? WHERE id = ? AND stock_actuel >= ?", [$qty, $id, $qty]);
        } else {
            $this->query("UPDATE raw_materials SET stock_actuel = stock_actuel + ? WHERE id = ?", [$qty, $id]);
        }
    }

    public function getLowStockAlerts() {
        return $this->query("SELECT * FROM raw_materials WHERE stock_actuel <= seuil_alerte")->fetchAll();
    }
}
?>