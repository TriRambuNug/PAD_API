<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/update-user/{id}', [UserController::class, 'updateUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/alluser', [UserController::class, 'getAllUser']);
        Route::get('/user/{id}', [UserController::class, 'getUserById']);
        Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
    }); 
});