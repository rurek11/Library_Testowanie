<?php

namespace App\Models;

use App\Db\Database;

class Genre
{
    public static function getAll()
    {
        $db = new Database();
        $conn = $db->getCon();

        $query = "
            SELECT id, name
            FROM genres
        ";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        // return [
        //     ['id' => 1, 'name' => 'Fantasy'],
        //     ['id' => 2, 'name' => 'Science Fiction'],
        //     ['id' => 3, 'name' => 'Horror'],
        // ];

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}