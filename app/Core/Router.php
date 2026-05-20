<?php
declare(strict_types=1);

class Router
{
    private array $routes = [];

    public function add(string $path, callable $callback): void
    {
        $this->routes[trim($path, '/')] = $callback;
    }

    public function dispatch(string $path): void
    {
        $route = trim($path, '/');
        if ($route === '') {
            $route = 'home';
        }

        if (array_key_exists($route, $this->routes)) {
            $callback = $this->routes[$route];
            $callback();
        } else {
            http_response_code(404);
            include __DIR__ . '/../../views/layouts/header.php';
            echo '<main class="page-content"><section class="card"><h2>Page introuvable</h2><p>La route demandée est introuvable.</p></section></main>';
            include __DIR__ . '/../../views/layouts/footer.php';
        }
    }
}
