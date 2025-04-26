<?php

namespace App\Api;

use App\Models\Book;
// require_once dirname(__dir__, 2) . '/models/Book.php';

header('Content-Type: application/json');

try {
    $books = Book::getAll();
    echo json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error during getting data.",
        "details" => $th->getMessage()
    ]);
}
