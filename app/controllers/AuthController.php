<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    
    // 1. Afficher le formulaire de connexion
    public function login() {
        // Si déjà connecté, rediriger vers la boutique
        if (isset($_SESSION['user_id'])) {
            $this->redirect('shop');
        }
        $this->view('frontend/auth/login', ['pageTitle' => 'Connexion']);
    }

    // 2. Traiter la soumission du formulaire de connexion (POST)
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Vérification du mot de passe hashé
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nom'];
                $_SESSION['role'] = $user['role'];
                
                // Redirection selon le rôle
                if ($user['role'] === 'admin') {
                    $this->redirect('/admin/dashboard/index.php');
                } else {
                    $this->redirect('shop');
                }
            } else {
                // Erreur : retour au formulaire avec message
                $this->view('frontend/auth/login', [
                    'pageTitle' => 'Connexion',
                    'error' => 'Email ou mot de passe incorrect.'
                ]);
            }
        } else {
            // Si accès direct en GET, rediriger vers le formulaire
            $this->redirect('auth/login');
        }
    }

    // 3. Afficher le formulaire d'inscription
    public function register() {
        $this->view('frontend/auth/register', ['pageTitle' => 'Inscription']);
    }

    // 4. Traiter la soumission du formulaire d'inscription (POST)
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $userModel = new User();
            
            // Vérifier si l'email existe déjà
            if ($userModel->findByEmail($data['email'])) {
                $this->view('frontend/auth/register', [
                    'pageTitle' => 'Inscription',
                    'error' => 'Cet email est déjà utilisé par un autre compte.'
                ]);
                return;
            }

            // Création du compte (Le modèle se charge du hashage du mot de passe)
            $success = $userModel->create(
                $data['nom'], 
                $data['prenom'], 
                $data['email'], 
                $data['password'], 
                $data['tel'] ?? ''
            );

            if ($success) {
                // Succès : Rediriger vers la page de connexion
                $this->redirect('auth/login');
            } else {
                // Erreur technique
                $this->view('frontend/auth/register', [
                    'pageTitle' => 'Inscription',
                    'error' => 'Une erreur est survenue lors de l\'inscription.'
                ]);
            }
        } else {
            // Si accès direct en GET, rediriger vers le formulaire
            $this->redirect('auth/register');
        }
    }

    // 5. Déconnexion
    public function logout() {
        session_destroy();
        $this->redirect('home');
    }
}
?>