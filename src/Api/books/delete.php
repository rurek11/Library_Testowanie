<?php

namespace App\Api;

use App\Services\BookService;
use App\Validators\BookValidator;

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) throw new \Exception("No data provided");

    $errors = BookValidator::validateDelete($data);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid input data", "details" => $errors]);
        return;
    }

    $id = (int)$data['id'];
    $service = new BookService();
    $result = $service->deleteBook($id);

    if ($result) {
        http_response_code(200);
        echo json_encode(["message" => "Book deleted successfully"]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Book not found or already deleted"]);
    }
} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error during deleting book.",
        "details" => $th->getMessage()
    ]);
}