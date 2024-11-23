<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\TaskController;

use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/auth/register', [UserController::class, 'register']);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('columns', ColumnController::class);
Route::post('/columns/order', [ColumnController::class, 'updateColumnOrder']);

Route::apiResource('tasks', TaskController::class);



Route::get('/hello', function () {
    return "hello world!";
});
