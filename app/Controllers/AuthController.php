<?php
declare(strict_types=1);

class AuthController
{
    private PDO $pdo;
    private User $userModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }

    public function authenticate(string $email, string $password): array
    {
        if ($email === '' || $password === '') {
            return ['success' => false, 'message' => 'Veuillez saisir votre adresse e-mail et votre mot de passe.', 'redirect' => 'login'];
        }

        $user = $this->userModel->verifyPassword($email, $password);

        if ($user === null) {
            return ['success' => false, 'message' => 'Identifiants incorrects. Vérifiez votre e-mail et votre mot de passe.', 'redirect' => 'login'];
        }

        $role = $this->getRoleLabel((int)$user['role_id']);
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $role,
        ];

        if ($role === 'admin') {
            return ['success' => true, 'message' => 'Connexion réussie.', 'redirect' => 'dashboard'];
        }

        return ['success' => true, 'message' => 'Connexion réussie.', 'redirect' => 'home'];
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public function isAuthenticated(): bool
    {
        return !empty($_SESSION['user']);
    }

    public function getCurrentUser(): array
    {
        return $_SESSION['user'] ?? [];
    }

    private function getRoleLabel(int $roleId): string
    {
        $statement = $this->pdo->prepare('SELECT nom_role FROM roles WHERE id = :id');
        $statement->execute(['id' => $roleId]);
        $result = $statement->fetchColumn();
        return $result === false ? 'client' : $result;
    }
}
