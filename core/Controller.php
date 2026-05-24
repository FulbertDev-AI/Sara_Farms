<?php
class Controller {
    protected $db;

    public function __construct() {
        // Initialisation de la connexion BDD
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Charger une vue
     */
    protected function view($viewPath, $data = []) {
        extract($data);
        $fullPath = __DIR__ . "/../app/views/{$viewPath}.php";
        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            die("Vue introuvable : {$viewPath}");
        }
    }

    /**
     * Redirection
     */
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    /**
     * Vérifier si l'utilisateur est connecté
     */
    protected function authRequired() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
    }

    /**
     * Vérifier si l'utilisateur est admin
     * ⚠️ Doit être "protected" pour être accessible par les enfants
     */
    protected function adminRequired() {
        // D'abord vérifier qu'il est connecté
        $this->authRequired();
        
        // Ensuite vérifier le rôle
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('home');
        }
    }

    /**
     * Récupérer les données JSON
     */
    protected function getJSON() {
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * Retourner une réponse JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}