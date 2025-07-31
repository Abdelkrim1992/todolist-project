<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TodoListController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'show']);
Route::post('/login', [LoginController::class, 'signin']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::apiResource('todos', TodoListController::class);
});