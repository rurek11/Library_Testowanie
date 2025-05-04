<?php

use PHPUnit\Framework\TestCase;
use App\Models\Genre;
use App\Db\Database;

class GenreTest extends TestCase
{
    public function testGenreCountIncreasesWhenAdding()
    {
        $before = Genre::getAll();
        $beforeCount = count($before);

        $db = new Database();
        $conn = $db->getCon();
        $stmt = $conn->prepare("INSERT INTO genres (name) VALUES ('Tymczasowy Gatunek')");
        $stmt->execute();

        $after = Genre::getAll();
        $afterCount = count($after);

        $this->assertEquals($beforeCount + 1, $afterCount, "Liczba gatunków nie wzrosła po dodaniu");

        $conn->prepare("DELETE FROM genres WHERE name = 'Tymczasowy Gatunek'")->execute();
    }
}