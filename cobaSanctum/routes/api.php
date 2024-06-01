<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

ROute::post('/register', [AuthController::class, 'register']);
ROute::post('/login', [AuthController::class, 'login']);
ROute::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
ROute::post('/user', [AuthController::class, 'me'])->middleware('auth:sanctum');