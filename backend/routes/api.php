<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/tasks', [ItemController::class, 'createTask']);
Route::get('/tasks', [ItemController::class, 'viewTasks']);
Route::get('/tasks', [ItemController::class, 'changeTask']);
Route::get('/tasks', [ItemController::class, 'completeTask']);
Route::get('/tasks', [ItemController::class, 'removeTask']);

