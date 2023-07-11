<?php

namespace App\Controllers;

use App\Models\User;
use App\Router;
use App\Support\Session;

class AuthController
{
    public function show()
    {
        if (Session::get('is_auth')) {
            Router::redirect('/');
        }
        $error = Session::getOnce('error');

        include_once __DIR__ . '/../Views/Login/index.php';
    }

    public function login()
    {
        $user = User::findByLogin($_POST['login']);

        if ($user && md5($_POST['password']) === $user['password']) {
            Session::set('is_auth', true);
            if ($user['is_admin']) {
                Session::set('is_admin', true);
            }
            Router::redirect('/');
        }

        Session::set('error', true);
        Router::redirect('/login');

    }

    public function logout()
    {
        Session::destroy();
        Router::redirect('/');
    }
}