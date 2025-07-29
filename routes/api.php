<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Category API Routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::get('/tree', [CategoryController::class, 'tree'])->name('api.categories.tree');
    Route::get('/search', [CategoryController::class, 'search'])->name('api.categories.search');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('api.categories.show');
    Route::get('/{category}/children', [CategoryController::class, 'children'])->name('api.categories.children');
});