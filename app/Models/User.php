<?php

namespace App\Models;

use PDO;

class User
{
    public static function findByLogin(string $login)
    {
        global $pdo;

        $sql = "
            SELECT login, password, is_admin
            FROM users
            WHERE login = :login
        ";
        $query = $pdo->prepare($sql);
        $query->bindParam(':login', $login);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

}