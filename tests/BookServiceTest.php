<?php

use PHPUnit\Framework\TestCase;
use App\Services\BookService;
use App\Models\Book;
use App\Validators\BookValidator;

class BookServiceTest extends TestCase
{
    private BookService $service;

    protected function setUp(): void
    {
        $this->service = new BookService();

        foreach (Book::getAll() as $book) {
            Book::delete($book['id']);
        }
    }

    public function testGetAllBooksReturnsSortedArray()
    {
        Book::add("Zeta", 1, 2020, 1);
        Book::add("Alpha", 1, 2021, 1);

        $books = $this->service->getAllBooks('title', 'asc');
        $this->assertIsArray($books);
        $this->assertGreaterThanOrEqual(2, count($books));
        $this->assertEquals('Alpha', $books[0]['title']);
    }

    public function testAddBookWithValidDataStoresInDatabase()
    {
        $title = 'Test Book ' . uniqid();
        $data = [
            'title' => $title,
            'author_id' => 1,
            'year' => 2024,
            'genre_id' => 1
        ];

        $result = $this->service->addBook($data);
        $this->assertTrue($result);

        $books = Book::getAll();
        $titles = array_column($books, 'title');
        $this->assertContains($title, $titles);
    }

    public function testAddBookWithInvalidDataFails()
    {
        $invalidData = [
            'title' => '',
            'author_id' => 'abc',
            'year' => 'future',
            'genre_id' => null
        ];

        $errors = BookValidator::validateCreate($invalidData);
        $this->assertNotEmpty($errors);
        $this->assertContains("Title is required.", $errors);
        $this->assertContains("Valid author ID is required.", $errors);
        $this->assertContains("Year must be between 1000 and current year.", $errors);
        $this->assertContains("Valid genre ID is required.", $errors);
    }

    public function testUpdateBookWithValidDataUpdatesEntry()
    {
        $title = 'Original ' . uniqid();
        Book::add($title, 1, 2023, 1);
        $book = $this->findBookByTitle($title);
        $this->assertNotNull($book);

        $data = [
            'id' => $book['id'],
            'title' => 'Updated Title',
            'author_id' => 1,
            'year' => 2023,
            'genre_id' => 1
        ];

        $result = $this->service->updateBook($data);
        $this->assertTrue($result);

        $updatedBook = $this->findBookById($book['id']);
        $this->assertEquals('Updated Title', $updatedBook['title']);
    }

    public function testUpdateBookWithInvalidIdFails()
    {
        $data = [
            'id' => 999999,
            'title' => 'Does not exist',
            'author_id' => 1,
            'year' => 2023,
            'genre_id' => 1
        ];

        $result = $this->service->updateBook($data);
        $this->assertFalse($result);
    }

    public function testDeleteBookSuccessfullyRemovesIt()
    {
        $title = 'To Be Deleted ' . uniqid();
        Book::add($title, 1, 2023, 1);
        $book = $this->findBookByTitle($title);
        $this->assertNotNull($book);

        $result = $this->service->deleteBook($book['id']);
        $this->assertTrue($result);

        $deletedBook = $this->findBookById($book['id']);
        $this->assertNull($deletedBook);
    }

    public function testDeleteBookWithInvalidIdReturnsFalse()
    {
        $result = $this->service->deleteBook(999999);
        $this->assertFalse($result);
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
