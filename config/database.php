<?php
try {
    $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage() . '<br/>');
}