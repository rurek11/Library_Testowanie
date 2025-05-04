<?php

namespace App\Api;

use App\Services\BookService;
use App\Validators\BookValidator;

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) throw new \Exception("No data provided");

    $errors = BookValidator::validateCreate($data);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid input data", "details" => $errors]);
        return;
    }

    $service = new BookService();
    $result = $service->addBook($data);

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