<?php

use App\Presentation\RestApi\Controllers\EventLogController;
use App\Presentation\RestApi\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/me', [UserController::class, 'me']);
Route::get('/events_log', [EventLogController::class, 'index']);
