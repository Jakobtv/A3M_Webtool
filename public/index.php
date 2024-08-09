<?php

# Einstieg in das All3Media-Webtool
# Geschrieben von Jakob Winkler

// Aktivierung von Fehlermeldungen
error_reporting(E_ALL);
ini_set("display_errors",1);

// Autoloader einbinden
require_once __DIR__ . '/../vendor/autoload.php';

// Dispatcher
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'App\controller\HomeController::index');
    $r->addRoute('POST', '/login', 'App\controller\LoginController::login');
});

// URL Cleanup
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri,'?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode("::", $handler, 2);
        call_user_func_array([new $class, $method], $vars);
        break;
    }
?>