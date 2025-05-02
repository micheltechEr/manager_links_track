<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request_uri = $_SERVER['REQUEST_URI'];

$path = parse_url($request_uri, PHP_URL_PATH);

$path = trim($path, '/');

// Remover 'index.php' se presente
$path = preg_replace('#^index\.php/#', '', $path);
$path = trim($path, '/');

$prefix = 'manager_links_track/app';
if (strpos($path, $prefix) === 0) {
    $path = substr($path, strlen($prefix));
    $path = trim($path, '/');
}

$routes = require __DIR__ . '/routes.php';

$path = preg_replace('#index\.php/#', '', $path);
$path = trim($path, '/');


if (array_key_exists($path, $routes)) {
    // Isso aqui divide o Controller@metodo
    [$controllerName, $method] = explode('@', $routes[$path]);

    $controllerFile = __DIR__ . "/controller/{$controllerName}.php";
    if (!file_exists($controllerFile)) {
        http_response_code(500);
        echo "Erro: Arquivo do controlador '$controllerFile' não encontrado";
        exit;
    }
    require_once $controllerFile;

    if (!class_exists($controllerName)) {
        http_response_code(500);
        echo "Erro: Classe '$controllerName' não encontrada";
        exit;
    }

    $controller = new $controllerName();
    if (!method_exists($controller, $method)) {
        http_response_code(500);
        echo "Erro: Método '$method' não encontrado em '$controllerName'";
        exit;
    }
    $controller->$method();
} else {
    http_response_code(404);
    echo "Página não encontrada";
}