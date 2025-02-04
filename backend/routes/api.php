<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/tasks/addTask', [TaskController::class, 'addTask']);
Route::post('/tasks/viewTask', [TaskController::class, 'viewTask']);
Route::post('/tasks/changeTask', [TaskController::class, 'changeTask']);

Route::post('/tasks/completeTask', [TaskController::class, 'completeTask']);
Route::post('/tasks/removeTask', [TaskController::class, 'removeTask']);

