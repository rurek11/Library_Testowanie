<?php

namespace App\Api;

use App\Models\Book;

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new \Exception("No data provided");
    }

    // Walidacja podstawowa pól
    if (
        !isset($data['title'], $data['author_id'], $data['year'], $data['genre_id']) ||
        empty(trim($data['title'])) ||
        !is_numeric($data['author_id']) || (int)$data['author_id'] <= 0 ||
        !is_numeric($data['year']) || (int)$data['year'] < 1000 || (int)$data['year'] > (int)date('Y') ||
        !is_numeric($data['genre_id']) || (int)$data['genre_id'] <= 0
    ) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid input data"]);
        return;
    }

    $title = trim($data['title']);
    $authorId = (int)$data['author_id'];
    $year = (int)$data['year'];
    $genreId = (int)$data['genre_id'];

    $result = Book::add($title, $authorId, $year, $genreId);

    if ($result) {
        http_response_code(201);
        echo json_encode(["message" => "Book added successfully"]);
    } else {
        throw new \Exception("Failed to add book");
    }
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error during adding book.",
        "details" => $th->getMessage()
    ]);
}
