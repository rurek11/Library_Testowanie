<?php

namespace App\Models;

use App\Db\Database;

class Book
{
    public static function getAll()
    {
        $db = new Database();
        $conn = $db->getCon();

        $query = "
            SELECT 
                books.id,
                books.title,
                books.year,
                books.author_id,    
                books.genre_id,       
                genres.name AS genre, 
                authors.name AS author_name,
                authors.surname AS author_surname
            FROM books
            JOIN authors ON books.author_id = authors.id
            JOIN genres ON books.genre_id = genres.id
        ";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function add(string $title, int $authorId, int $year, int $genreId)
    {
        $db = new Database();
        $conn = $db->getCon();

        $query = "
            INSERT INTO books (title, author_id, year, genre_id)
            VALUES (:title, :author_id, :year, :genre_id)
        ";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author_id', $authorId);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':genre_id', $genreId);

        return $stmt->execute();
    }

    public static function update(int $id, string $title, int $authorId, int $year, int $genreId)
    {
        $db = new Database();
        $conn = $db->getCon();

        $query = "
            UPDATE books
            SET title = :title, author_id = :author_id, year = :year, genre_id = :genre_id
            WHERE id = :id
        ";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author_id', $authorId);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':genre_id', $genreId);

        return $stmt->execute();
    }

    public static function delete(int $id)
    {
        $db = new Database();
        $conn = $db->getCon();

        $query = "DELETE FROM books WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() > 0; // <<< sprawdzamy, czy coś faktycznie zostało usunięte
    }
}
