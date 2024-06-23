<?php

use App\Http\Controllers\AdminTopupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatnerController;
use App\Http\Controllers\PocketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/user-data', [AuthController::class, 'defineUser'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/update-user/{id}', [UserController::class, 'updateUser']);

 //pocket
 Route::post('/create-pocket', [PocketController::class, 'store']);
 Route::get('/allpocket', [PocketController::class, 'index']);
 Route::get('/pocket/{id}', [PocketController::class, 'show']);
 Route::put('/update-pocket/{id}', [PocketController::class, 'update']);
 Route::delete('/delete-pocket/{id}', [PocketController::class, 'destroy']);

 //transaction
 Route::post('/create-transaction', [TransactionController::class, 'store']);
 Route::get('/alltransaction', [TransactionController::class, 'index']);
 Route::get('/transaction/{id}', [TransactionController::class, 'show']);
 Route::put('/update-transaction/{id}', [TransactionController::class, 'update']);
 Route::delete('/delete-transaction/{id}', [TransactionController::class, 'destroy']);



Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/alluser', [UserController::class, 'getAllUser']);
        Route::get('/user/{id}', [UserController::class, 'getUserById']);
        Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

        //Patner 
        Route::post('./create-patner', [PatnerController::class, 'createPatner']);
        Route::get('/allpatner', [PatnerController::class, 'getAllPatner']);
        Route::get('/patner/{id}', [PatnerController::class, 'getPatnerById']);
        Route::put('/update-patner/{id}', [PatnerController::class, 'updatePatner']);
        Route::delete('/delete-patner/{id}', [PatnerController::class, 'deletePatner']);

       
        //topup
        Route::post('/admin-topup',[AdminTopupController::class, 'store']);
        Route::get('/alltopup-history', [AdminTopupController::class, 'index']);

    }); 
});