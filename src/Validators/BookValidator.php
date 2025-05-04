<?php

namespace App\Validators;

class BookValidator
{
    public static function validateCreate(array $data): array
    {
        $errors = [];

        if (!isset($data['title']) || trim($data['title']) === '') {
            $errors[] = "Title is required.";
        }

        if (!isset($data['author_id']) || !is_numeric($data['author_id']) || (int)$data['author_id'] <= 0) {
            $errors[] = "Valid author ID is required.";
        }

        $year = $data['year'] ?? null;
        if (!is_numeric($year) || $year < 1000 || $year > (int)date('Y')) {
            $errors[] = "Year must be between 1000 and current year.";
        }

        if (!isset($data['genre_id']) || !is_numeric($data['genre_id']) || (int)$data['genre_id'] <= 0) {
            $errors[] = "Valid genre ID is required.";
        }

        return $errors;
    }

    public static function validateUpdate(array $data): array
    {
        $errors = [];

        if (!isset($data['id']) || !is_numeric($data['id']) || (int)$data['id'] <= 0) {
            $errors[] = "Valid book ID is required.";
        }

        $errors = array_merge($errors, self::validateCreate($data));

        return $errors;
    }

    public static function validateDelete(array $data): array
    {
        $errors = [];

        if (!isset($data['id']) || !is_numeric($data['id']) || (int)$data['id'] <= 0) {
            $errors[] = "Valid book ID is required.";
        }

        return $errors;
    }
}
