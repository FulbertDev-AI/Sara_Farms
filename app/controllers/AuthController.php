<?php
require_once __DIR__ . '/../../core/Controller.php';
class AuthController extends Controller {
    public function login() {
        $this->view('frontend/auth/login', ['pageTitle' => 'Connexion', 'active' => '']);
    }
    public function register() {
        $this->view('frontend/auth/register', ['pageTitle' => 'Inscription', 'active' => '']);
    }
    public function logout() {
        session_destroy();
        $this->redirect('home');
    }
}
?>