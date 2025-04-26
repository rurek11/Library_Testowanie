<?php

namespace App;

use App\Controllers\AdminHomepageController;
use App\Controllers\BooksController;

class Router
{
    public function handleRequest(array $request)
    {
        $page = $request['page'] ?? 'adminHomepage';

        switch ($page) {
            case 'adminHomepage':
                $controller = new AdminHomepageController();
                $controller->index();
                break;

            case 'books':
                $controller = new BooksController();
                $controller->index();
                break;

            case 'authors':
                // require_once __DIR__ . "/controllers/AuthorsController.php";
                // $controller = new AuthorsController();
                // $controller->index();
                // break;

            default:
                echo "404 - Nie znaleziono strony";
                break;
        }
    }

    public function handleApiRequest(string $method, string $uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));

        if ($segments[0] !== 'api') {
            http_response_code(404);
            echo json_encode(['error' => 'probably bad Api name']);
            return;
        }

        $resource = $segments[1] ?? null;
        $id = $segments[2] ?? null;

        if ($method == 'GET') {
            if ($resource == 'books') {
                if ($id === null) {
                    require_once __DIR__ . '/Api/books/get.php';
                }
            }
        }
    }
}
