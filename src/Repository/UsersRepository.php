<?php

namespace Natanael\Blog\Repository;

use Natanael\Blog\Entity\Post;
use PDO;
use PDOException;

class UsersRepository 
{
    public function __construct(private PDO $pdo) {}

    public function searchUser(string $email): array | false
    {
        $sqlQr = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sqlQr);

        $stmt->bindValue(1, $email);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function updatePassword(string $email, string $password) 
    {
        $stmt = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
        $stmt->bindValue(2, $email);
        $stmt->execute();
    }
}