<?php

$allowedPages = ['admin_homepage', 'books', 'authors'];

$page = $_GET['page'] ?? 'admin_homepage';

if (!in_array($page, $allowedPages)) {
    echo "404 - Nie znaleziono strony";
    exit;
}

switch ($page) {
    case 'admin_homepage':
        include dirname(__DIR__) . "/src/views/admin_homepage.php";
        break;

    case 'books':
        require_once dirname(__DIR__) . "/src/controllers/BooksController.php";

        $controller = new BooksController();
        $controller->index();
        break;

    case 'authors':
        // require_once dirname(__DIR__) . "/src/controllers/AuthorsController.php";
        // $controller = new AuthorsController();
        // $controller->index();
        // break;

    default:
        echo "404 - Nie znaleziono strony";
        break;
}