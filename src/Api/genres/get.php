<?php

namespace App\Api;

use App\Models\Genre;

header('Content-Type: application/json');

try {
    $genres = Genre::getAll();
    echo json_encode($genres, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error during getting genres.",
        "details" => $th->getMessage()
    ]);
}
