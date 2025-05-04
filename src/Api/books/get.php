<?php

namespace App\Api;

use App\Services\BookService;

header('Content-Type: application/json');

$sort = $_GET['sort'] ?? 'title';
$dir = $_GET['dir'] ?? 'asc';

try {
    $service = new BookService();
    $books = $service->getAllBooks($sort, $dir);

    echo json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error during getting data.",
        "details" => $th->getMessage()
    ]);
}