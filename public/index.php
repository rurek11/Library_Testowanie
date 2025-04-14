<?php

$allowedPages = ['admin_homepage', 'books', 'authors'];

$page = $_GET['page'] ?? 'admin_homepage';

if (!in_array($page, $allowedPages)) {
    echo "404 - Nie znaleziono strony";
    exit;
}

$viewPath = dirname(__DIR__) . "/src/views/{$page}.php";

if (file_exists($viewPath)) {
    include $viewPath;
} else {
    echo "404 - Plik nie istnieje";
}
