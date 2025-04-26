<?php

namespace App\Controllers;

class BooksController
{
    public function index()
    {
        require __DIR__ . '/../views/books.php';
    }
}
