<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require_once __DIR__ . '/../vendor/autoload.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$request = $_SERVER['REQUEST_METHOD'];

$routes = require_once __DIR__ . '/../config/routes.php';
$key = "$request|$pathInfo";

$diContainer = require_once __DIR__ . '/../config/dependencies.php';

session_start();
session_regenerate_id();

$isLoginSession = $pathInfo === "/login";

if (!$isLoginSession && !array_key_exists('logado', $_SESSION)) {
    header('Location: /login');
    return;
}

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];

    $controller = $diContainer->get($controllerClass);
}

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);

$request = $creator->fromGlobals();

$response = $controller->handle($request);

http_response_code($response->getStatusCode());
foreach($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();