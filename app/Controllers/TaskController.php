<?php

namespace App\Controllers;

use App\Models\Task;
use App\Router;
use App\Support\Session;
use App\Support\Validation;

class TaskController
{
    public function show()
    {
        $page = $_GET['page'] ?? 1;
        $order = $_GET['order'] ?? 'id';
        $sort = $_GET['sort'] ?? 'desc';
        $tasks = Task::get($page, $order, $sort);
        $maxPage = Task::maxPage();
        $is_auth = Session::get('is_auth');
        $is_admin = Session::get('is_admin');
        $success = Session::getOnce('success');

        include_once __DIR__ . '/../Views/Tasks/index.php';
    }

    public function add()
    {
        Task::add($_POST['username'], $_POST['email'], $_POST['task']);
        Session::set('success', true);
        Router::redirect('/');
    }

    public function edit()
    {
        Validation::admin();

        $task = Task::find($_GET['id']);

        include_once __DIR__ . '/../Views/Tasks/update.php';
    }

    public function update()
    {
        Validation::admin();

        $status = !!$_POST['status'];
        $task = Task::find($_POST['id']);
        $changed = Validation::changed($_POST['task'], $task['task']) || $task['changed'];

        Task::update($_POST['id'], $_POST['task'], $status, $changed);
        Router::redirect('/');
    }


    public function delete()
    {
        Validation::admin();
        Task::delete($_POST['id']);
        Router::redirect('/');
    }


}