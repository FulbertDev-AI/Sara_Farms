<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Models/Stock.php';
require_once __DIR__ . '/../app/Models/Culture.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/StockController.php';
require_once __DIR__ . '/../app/Controllers/ProductionController.php';

session_start();

$pdo = getPDO();
$router = new Router();

function isAuthenticated(): bool
{
    return !empty($_SESSION['user']);
}

function currentUser(): array
{
    return $_SESSION['user'] ?? [];
}

function redirect(string $destination): void
{
    header('Location: ' . $destination);
    exit;
}

$router->add('home', function () use ($pdo) {
    include __DIR__ . '/../views/layouts/header.php';
    include __DIR__ . '/../views/public/home.php';
    include __DIR__ . '/../views/layouts/footer.php';
});

$router->add('catalogue', function () use ($pdo) {
    $statement = $pdo->prepare('SELECT * FROM produits_catalogue WHERE stock_disponible > 0 ORDER BY nom_produit ASC');
    $statement->execute();
    $produits = $statement->fetchAll();

    include __DIR__ . '/../views/layouts/header.php';
    include __DIR__ . '/../views/public/catalogue.php';
    include __DIR__ . '/../views/layouts/footer.php';
});

$router->add('login', function () use ($pdo) {
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = sanitizeText($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $auth = new AuthController($pdo);
        $result = $auth->authenticate($email, $password);
        if ($result['success']) {
            redirect('?route=' . $result['redirect']);
        }
        $message = $result['message'];
    }

    include __DIR__ . '/../views/layouts/header.php';
    include __DIR__ . '/../views/public/login.php';
    include __DIR__ . '/../views/layouts/footer.php';
});

$router->add('logout', function () {
    $auth = new AuthController(getPDO());
    $auth->logout();
    redirect('?route=home');
});

$router->add('dashboard', function () use ($pdo) {
    $auth = new AuthController($pdo);
    if (!$auth->isAuthenticated()) {
        redirect('?route=login');
    }

    $stockModel = new Stock($pdo);
    $productionController = new ProductionController($pdo);
    $alertIntrants = $stockModel->getAlertIntrants();
    $allIntrants = $stockModel->getAllIntrants();
    $activeCulturesCount = count($productionController->getActiveCultures());

    // Données simulées pour le graphique des ventes
    $salesLabels = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'];
    $salesValues = [1200, 1800, 1540, 1980, 1740, 2100];

    include __DIR__ . '/../views/layouts/header.php';
    include __DIR__ . '/../views/admin/dashboard.php';
    include __DIR__ . '/../views/layouts/footer.php';
});

$route = $_GET['route'] ?? '';
$router->dispatch($route);
