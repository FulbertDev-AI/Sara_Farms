<?php
require_once __DIR__ . '/../../core/Model.php';

class User extends Model {
    public function findByEmail($email) {
        return $this->query("SELECT * FROM users WHERE email = ? LIMIT 1", [$email])->fetch();
    }

    public function findById($id) {
        return $this->query("SELECT * FROM users WHERE id = ? LIMIT 1", [$id])->fetch();
    }

    // Dans app/models/User.php
public function create($nom, $prenom, $email, $password, $tel = '') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    try {
        $this->query(
            "INSERT INTO users (nom, prenom, email, password, telephone) VALUES (?, ?, ?, ?, ?)",
            [$nom, $prenom, $email, $hash, $tel]
        );
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

    public function countTotalClients() {
        return $this->query("SELECT COUNT(*) as total FROM users WHERE role = 'client'")->fetch()['total'];
    }
}
?>