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
            echo json_encode(['error' => 'Invalid API path']);
            return;
        }

        $resource = $segments[1] ?? null;
        $action = $segments[2] ?? null;

        $apiBasePath = __DIR__ . '/Api/';

        // Domyślne zachowanie jeśli brak akcji - GET books
        if ($method === 'GET' && $resource === 'books' && $action === null) {
            $filePath = $apiBasePath . 'books/get.php';
        } else if ($action !== null) {
            $filePath = $apiBasePath . "$resource/$action";
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'API endpoint not complete']);
            return;
        }

        if (file_exists($filePath)) {
            require_once $filePath;
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'API file not found']);
        }
    }
}
