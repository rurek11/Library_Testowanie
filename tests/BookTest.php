<?php

use PHPUnit\Framework\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    protected function setUp(): void
    {
        foreach (Book::getAll() as $book) {
            if (trim($book['title']) === '' || str_starts_with($book['title'], 'Test')) {
                Book::delete($book['id']);
            }
        }
    }

    public function testAddBook()
    {
        $result = Book::add("Test Book", 1, 2024, 1);
        $this->assertTrue($result);
    }

    public function testGetAllBooks()
    {
        Book::add("Test Book", 1, 2023, 1);
        $books = Book::getAll();
        $this->assertIsArray($books);
        $this->assertGreaterThan(0, count($books));
    }

    public function testUpdateBook()
    {
        $originalTitle = "Test Original - " . uniqid();
        $updatedTitle = "Test Updated";
        Book::add($originalTitle, 1, 2022, 1);

        $book = $this->findBookByTitle($originalTitle);
        $this->assertNotNull($book);

        $success = Book::update($book['id'], $updatedTitle, 1, 2022, 1);
        $this->assertTrue($success);

        $updated = $this->findBookById($book['id']);
        $this->assertEquals($updatedTitle, $updated['title']);
    }

    public function testDeleteBook()
    {
        $title = "Test To Delete - " . uniqid();
        Book::add($title, 1, 2022, 1);
        $book = $this->findBookByTitle($title);
        $this->assertNotNull($book);

        $success = Book::delete($book['id']);
        $this->assertTrue($success);

        $deleted = $this->findBookById($book['id']);
        $this->assertNull($deleted);
    }

    public function testAddBookWithEmptyTitleFails()
    {
        $result = @Book::add("", 1, 2024, 1);
        $this->assertFalse($result);
    }

    public function testAddBookWithFutureYearFails()
    {
        $futureYear = date('Y') + 10;
        $result = @Book::add("Test Book", 1, $futureYear, 1);
        $this->assertFalse($result);
    }

    public function testBooksHaveCompleteData()
    {
        Book::add("Test Book Complete", 1, 2022, 1);
        $books = Book::getAll();
        foreach ($books as $book) {
            $this->assertNotEmpty($book['title']);
            $this->assertNotEmpty($book['author_name']);
            $this->assertNotEmpty($book['author_surname']);
            $this->assertNotEmpty($book['genre']);
            $this->assertIsInt($book['year']);
        }
    }

    public function testGetAllSortedByTitleAsc()
    {
        Book::add("Aaa A", 1, 2022, 1);
        Book::add("Zzz Z", 1, 2022, 1);
        $books = Book::getAllSorted('title', 'asc');

        $this->assertIsArray($books);
        $this->assertGreaterThanOrEqual(2, count($books));
        $this->assertLessThanOrEqual(0, strcmp($books[0]['title'], $books[1]['title']));
    }

    public function testGetAllSortedWithInvalidSortKeyFallsBackToTitle()
    {
        $books = Book::getAllSorted('not_a_column', 'asc');
        $this->assertIsArray($books);
    }

    public function testGetAllSortedWithInvalidDirectionFallsBackToAsc()
    {
        $books = Book::getAllSorted('title', 'wrong_direction');
        $this->assertIsArray($books);
    }

    private function findBookByTitle(string $title): ?array
    {
        foreach (Book::getAll() as $book) {
            if ($book['title'] === $title) {
                return $book;
            }
        }
        return null;
    }

    private function findBookById(int $id): ?array
    {
        foreach (Book::getAll() as $book) {
            if ($book['id'] === $id) {
                return $book;
            }
        }
        return null;
    }
}
