<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\DependenciesController;

// routes that require authentication
Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects/create', [ProjectController::class, 'create']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/releases/create', [ReleaseController::class, 'create']);
    Route::post('/releases', [ReleaseController::class, 'store']);
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::get('/releases/{id}/edit', [ReleaseController::class, 'edit']);
    Route::put('/releases/{id}', [ReleaseController::class, 'update']);
    Route::get('/dependencies/{id}/edit', [DependenciesController::class, 'edit']);
    Route::put('/dependencies/{id}', [DependenciesController::class, 'update']);
});

Route::get('/', [PageController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::get('/releases/{id}', [ReleaseController::class, 'show']);
Route::get('/search', [PageController::class, 'search']);