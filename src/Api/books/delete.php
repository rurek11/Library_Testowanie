<?php

namespace App\Api;

use App\Models\Book;

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['id']) || !is_numeric($data['id']) || (int)$data['id'] <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid book id"]);
        return;
    }

    $id = (int)$data['id'];

    $result = Book::delete($id);

    if ($result) {
        http_response_code(200);
        echo json_encode(["message" => "Book deleted successfully"]);
    } else {
        http_response_code(400); // <<< Zmieniamy na 400, jeśli ID nie istnieje
        echo json_encode(["error" => "Book not found or already deleted"]);
    }
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error during deleting book.",
        "details" => $th->getMessage()
    ]);
}
