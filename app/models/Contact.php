<?php
require_once __DIR__ . '/../../core/Model.php';

class Contact extends Model {
    public function create($nom, $email, $sujet, $message) {
        $sql = "INSERT INTO contact_messages (nom, email, sujet, message) VALUES (?, ?, ?, ?)";
        $this->query($sql, [$nom, $email, $sujet, $message]);
        return true;
    }

    public function getAll() {
        return $this->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
    }

    public function markAsRead($id) {
        $this->query("UPDATE contact_messages SET lu = 1 WHERE id = ?", [$id]);
    }
}
?>