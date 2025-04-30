<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request_uri = $_SERVER['REQUEST_URI'];
var_dump($request_uri); // Exibe o REQUEST_URI bruto

$path = parse_url($request_uri, PHP_URL_PATH);
var_dump($path); // Exibe após parse_url

$path = trim($path, '/');
var_dump($path); // Exibe após primeiro trim

// Remover 'index.php' se presente
$path = preg_replace('#^index\.php/#', '', $path);
$path = trim($path, '/');
var_dump($path); // Exibe após remover index.php

$prefix = 'manager_links_track/app';
if (strpos($path, $prefix) === 0) {
    $path = substr($path, strlen($prefix));
    $path = trim($path, '/');
}

var_dump($prefix); // Exibe o prefixo
var_dump($path); // Deve exibir: string(8) "register"

$routes = require __DIR__ . '/routes.php';
var_dump($routes); // Confirma as rotas

var_dump(array_key_exists($path, $routes)); // Deve exibir: bool(true)
// Remova o exit após testar
// exit;

$path = preg_replace('#index\.php/#', '', $path);
$path = trim($path, '/');
var_dump($path); // Deve exibir: register


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