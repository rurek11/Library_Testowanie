<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getAllBooks(string $sort = 'title', string $dir = 'asc'): array
    {
        return Book::getAllSorted($sort, $dir);
    }

    public function addBook(array $data): bool
    {
        return Book::add(
            trim($data['title']),
            (int)$data['author_id'],
            (int)$data['year'],
            (int)$data['genre_id']
        );
    }

    public function updateBook(array $data): bool
    {
        return Book::update(
            (int)$data['id'],
            trim($data['title']),
            (int)$data['author_id'],
            (int)$data['year'],
            (int)$data['genre_id']
        );
    }

    public function deleteBook(int $id): bool
    {
        return Book::delete($id);
    }
}
