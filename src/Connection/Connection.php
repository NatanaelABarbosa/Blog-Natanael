<?php

namespace Natanael\Blog\Connection;

use PDO;

class Connection
{
    public static function createConnection(): PDO
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/banco.sqlite');

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}