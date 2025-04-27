<?php

namespace App\Api;

use App\Models\Author;

header('Content-Type: application/json');

try {
    $authors = Author::getAll();
    echo json_encode($authors, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error during getting authors.",
        "details" => $th->getMessage()
    ]);
}
