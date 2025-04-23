<?php
require_once __DIR__ . '/../models/Book.php';

class BooksController
{
    public function index()
    {
        $books = Book::getAll();
        require __DIR__ . '/../views/books.php';
    }
}