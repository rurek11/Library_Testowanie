<?php
require_once __DIR__ . '/../db/Database.php';

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
            books.genre,
            authors.name AS author_name,
            authors.surname AS author_surname
            FROM books
            JOIN authors ON books.author_id = authors.id
        ";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}