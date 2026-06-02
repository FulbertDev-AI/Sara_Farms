<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';

// Nettoyer l'URL
$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$segments = explode('/', $url);

// Nettoyer les segments (enlever .php s'il y en a)
$segments = array_map(function($seg) {
    return str_replace('.php', '', $seg);
}, $segments);

$controllerName = ucfirst($segments[0]) . 'Controller';
$method = $segments[1] ?? 'index';
$params = array_slice($segments, 2);

// Gestion du namespace admin
if ($segments[0] === 'admin' && isset($segments[1])) {
    $adminSegment = $segments[1];
    switch ($adminSegment) {
        case 'products':
            $controllerName = 'ProductController';
            break;
        case 'orders':
            $controllerName = 'OrderManagementController';
            break;
        case 'dashboard':
            $controllerName = 'DashboardController';
            break;
        case 'stock':
            $controllerName = 'StockController';
            break;
        case 'finance':
            $controllerName = 'FinanceController';
            break;
        default:
            $controllerName = ucfirst($adminSegment) . 'Controller';
    }
    $method = $segments[2] ?? 'index';
    $params = array_slice($segments, 3);
    $controllerPath = __DIR__ . "/../app/controllers/admin/{$controllerName}.php";
} else {
    $controllerPath = __DIR__ . "/../app/controllers/{$controllerName}.php";
}

// Chargement et exécution
if (file_exists($controllerPath)) {
    require_once $controllerPath;
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            http_response_code(404); 
            die("❌ Méthode '<strong>{$method}</strong>' introuvable dans <strong>{$controllerName}</strong><br>");
        }
    } else {
        http_response_code(404); 
        die("❌ Classe '<strong>{$controllerName}</strong>' introuvable<br>");
    }
} else {
    http_response_code(404); 
    die("❌ Contrôleur introuvable : <strong>{$controllerPath}</strong><br>");
}
?>