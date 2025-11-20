<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use app\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/projects', [ProjectController::class, 'index']);

    Route::post('/projects', [ProjectController::class, 'store']);

    Route::get('/projects/{id}', [ProjectController::class, 'show']);

    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::patch('/projects/{id}', [ProjectController::class, 'update']);

    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/projects/{project}/tasks', [TaskController::class, 'index']);

    Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);

    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::patch('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

    Route::get('/tasks', [TaskController::class, 'filter']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks/{task}/comments', [CommentController::class, 'index']);
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'project.access'])->group(function () {
    Route::get('/projects/{project}/tasks', [TaskController::class, 'index']);
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
