<?php

namespace App\Models;

use PDO;

class Task
{
    const LIMIT = 3;
    const ALLOWED_ORDER = ['id', 'username', 'email', 'task', 'status'];
    const ALLOWED_SORT = ['asc', 'desc'];


    public static function get(int $page, string $order, $sort): array|false
    {
        global $pdo;

        $limit = static::LIMIT;
        $offset = static::offset($page);
        $order = static::order($order);
        $sort = static::sort($sort);

        $sql = "
            SELECT id, username, email, task, status, changed
            FROM tasks
            ORDER BY $order $sort
            LIMIT :offset, :limit
        ";
        $query = $pdo->prepare($sql);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add(string $username, $email, $task): void
    {
        global $pdo;

        $sql = "INSERT INTO tasks (username, email, task) VALUES (?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([$username, $email, $task]);
    }

    public static function find($id): mixed
    {
        global $pdo;

        $sql = "SELECT * FROM tasks WHERE id=?";
        $query = $pdo->prepare($sql);
        $query->execute([$id]);
        return $query->fetch();
    }

    public static function update($id, string $task, bool $status, $changed): void
    {
        global $pdo;
        print_r((int)$status);
        print_r((int)$changed);
        $sql = "UPDATE tasks SET task=?, status=?, changed=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$task, (int)$status, (int)$changed, $id]);
    }

    public static function delete($id): void
    {
        global $pdo;

        $sql = "DELETE FROM tasks WHERE id=?";
        $query = $pdo->prepare($sql);
        $query->execute([$id]);
    }

    public static function maxPage(): int
    {
        global $pdo;

        $sql = "SELECT count(*) as 'count' FROM tasks";
        $query = $pdo->prepare($sql);
        $query->execute();

        return ceil($query->fetch()['count'] / Task::LIMIT);
    }

    protected static function offset(string $page): int
    {
        return --$page * Task::LIMIT;
    }

    protected static function order(string $order): string
    {
        if (!in_array($order, static::ALLOWED_ORDER)) {
            $order = 'id';
        }
        return $order;
    }

    protected static function sort(string $sort): string
    {
        if (!in_array($sort, static::ALLOWED_SORT)) {
            $sort = 'desc';
        }
        return $sort;
    }

}