<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;




Route::post('/reg', [UserController::class, 'reg']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/rooms', [RoomController::class, 'list']);
    Route::get('/students', [StudentController::class, 'list']);

    Route::middleware(['CheckRole:admin'])->group(function () {
        Route::post('/rooms', [RoomController::class, 'add']);
        Route::delete('/rooms/{id}', [RoomController::class, 'delete']);
        Route::post('/students', [StudentController::class, 'add']);
        Route::post('/students/{id}/settle', [StudentController::class, 'settle']);
    });

});

