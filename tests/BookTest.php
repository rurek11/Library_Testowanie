<?php

use PHPUnit\Framework\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    public function testAddBook()
    {
        $result = Book::add("Test Book", 1, 2024, 1);
        $this->assertTrue($result);
    }

    public function testGetAllBooks()
    {
        $books = Book::getAll();
        $this->assertIsArray($books);
    }

    public function testUpdateBook()
    {
        Book::add("Book To Update", 1, 2022, 1);
        $books = Book::getAll();
        $lastBook = end($books);

        $result = Book::update($lastBook['id'], "Updated Title", 1, 2023, 1);
        $this->assertTrue($result);
    }

    public function testDeleteBook()
    {
        Book::add("Book To Delete", 1, 2022, 1);
        $books = Book::getAll();
        $lastBook = end($books);

        $result = Book::delete($lastBook['id']);
        $this->assertTrue($result);
    }
}
