<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\taskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', [taskController::class, 'index']);

Route::get('/tasks/{id}', [taskController::class, 'show']);

Route::post('/tasks', [taskController::class, 'store']);

Route::put('/tasks/{id}', [taskController::class, 'update']);

Route::patch('/tasks/{id}', [taskController::class, 'updatePartial']);

Route::delete('/tasks/{id}', [taskController::class, 'destroy']);