<?php
require_once 'vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\TaskController;
use Dotenv\Dotenv;
use App\Router;

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();
require_once __DIR__ . '/config/database.php';

Router::get('/', TaskController::class, 'show');
Router::post('/add', TaskController::class, 'add');
Router::get('/edit', TaskController::class, 'edit');
Router::post('/update', TaskController::class, 'update');
Router::post('/delete', TaskController::class, 'delete');

Router::get('/login', AuthController::class, 'show');
Router::post('/login', AuthController::class, 'login');
Router::get('/logout', AuthController::class, 'logout');