<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::apiResource('posts', PostController::class)->only(['index', 'show'])->parameters(['posts' => 'post:slug']);
    Route::apiResource('pages', PageController::class)->only(['index', 'show'])->parameters(['pages' => 'page:slug']);
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show'])->parameters(['categories' => 'category:slug']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
