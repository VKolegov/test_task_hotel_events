<?php

use App\Presentation\RestApi\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $r = new \App\Infrastructure\Database\UsersRepository();
    $u = $r->getById(1);

    return json_encode($u);
    return view('welcome');
});

Route::get('/me', [UserController::class, 'me']);
