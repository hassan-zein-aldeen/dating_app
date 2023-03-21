<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::group(["middleware" => "auth:api"], function () {
    Route::post('users', [UserController::class, 'getUsers']);
    Route::post('/block/{id}', [UserController::class, 'block']);
    Route::post('/unblock/{id}', [UserController::class, 'unblock']);
    Route::post('/like/{id}', [UserController::class, 'like']);
    Route::post('/unlike/{id}', [UserController::class, 'unlike']);
    Route::post('/filterUsers', [UserController::class, 'filter']);
    Route::post('/profile', [UserController::class, 'profile']);
});

