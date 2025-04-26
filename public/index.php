<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;

$router = new Router();

if (str_starts_with($_SERVER['REQUEST_URI'], '/api/')) {
    $router->handleApiRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} else {
    $router->handleRequest($_GET);
}