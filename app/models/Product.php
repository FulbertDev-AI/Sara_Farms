<?php
require_once __DIR__ . '/../../core/Model.php';

class Product extends Model {
    public function getAll() {
        return $this->query("SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC")->fetchAll();
    }

    public function findById($id) {
        return $this->query("SELECT * FROM products WHERE id = ? LIMIT 1", [$id])->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO products (nom, description, prix, categorie, stock_disponible, image) VALUES (?, ?, ?, ?, ?, ?)";
        $this->query($sql, [$data['nom'], $data['desc'], $data['prix'], $data['cat'], $data['stock'], $data['image']]);
        return true;
    }

    public function update($id, $data) {
        $sql = "UPDATE products SET nom=?, description=?, prix=?, categorie=?, stock_disponible=?, image=? WHERE id=?";
        $this->query($sql, [$data['nom'], $data['desc'], $data['prix'], $data['cat'], $data['stock'], $data['image'], $id]);
        return true;
    }

    public function delete($id) {
        $this->query("UPDATE products SET is_active = 0 WHERE id = ?", [$id]);
        return true;
    }

    public function updateStock($id, $qty, $operation = 'decrement') {
        if ($operation === 'decrement') {
            $this->query("UPDATE products SET stock_disponible = stock_disponible - ? WHERE id = ? AND stock_disponible >= ?", [$qty, $id, $qty]);
        } else {
            $this->query("UPDATE products SET stock_disponible = stock_disponible + ? WHERE id = ?", [$qty, $id]);
        }
        return true;
    }
}
?>