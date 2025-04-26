<?php

namespace App\Controllers;

class AdminHomepageController
{
    public function index()
    {
        require __DIR__ . '/../views/adminHomepage.php';
    }
}
