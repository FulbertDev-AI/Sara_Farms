<?php
declare(strict_types=1);

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->pdo->prepare('SELECT id, nom, prenom, email, mot_de_pass, telephone, role_id FROM utilisateurs WHERE email = :email');
        $statement->execute(['email' => strtolower(trim($email))]);
        $result = $statement->fetch();
        return $result === false ? null : $result;
    }

    public function getById(int $id): ?array
    {
        $statement = $this->pdo->prepare('SELECT id, nom, prenom, email, telephone, role_id FROM utilisateurs WHERE id = :id');
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();
        return $result === false ? null : $result;
    }

    public function createUser(string $nom, string $prenom, string $email, string $password, ?string $telephone, int $roleId): bool
    {
        $nom = sanitizeText($nom);
        $prenom = sanitizeText($prenom);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $statement = $this->pdo->prepare(
            'INSERT INTO utilisateurs (nom, prenom, email, mot_de_pass, telephone, role_id) VALUES (:nom, :prenom, :email, :mot_de_pass, :telephone, :role_id)'
        );

        return $statement->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => strtolower($email),
            'mot_de_pass' => $passwordHash,
            'telephone' => sanitizeText($telephone ?? ''),
            'role_id' => $roleId,
        ]);
    }

    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if ($user === null) {
            return null;
        }
        if (password_verify($password, $user['mot_de_pass'])) {
            return $user;
        }
        return null;
    }
}
