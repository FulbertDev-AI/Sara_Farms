<?php
session_start();
require_once '../config/constants.php';
require_once '../config/database.php';

$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');
$segments = explode('/', $url);

$controllerName = ucfirst($segments[0]) . 'Controller';
$method = $segments[1] ?? 'index';
$params = array_slice($segments, 2);

$controllerPath = __DIR__ . "/../controllers/{$controllerName}.php";

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            http_response_code(404); echo "Methode introuvable.";
        }
    }
} else {
    http_response_code(404); echo "Page introuvable.";
}
?>