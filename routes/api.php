<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\JobTypeController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CareerController;
use App\Http\Controllers\Api\StaticPageController;
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

// City API Routes
Route::prefix('cities')->group(function () {
    Route::get('/', [CityController::class, 'index'])->name('api.cities.index');
    Route::get('/search', [CityController::class, 'search'])->name('api.cities.search');
    Route::get('/{city:slug}', [CityController::class, 'show'])->name('api.cities.show');
});

// Job Type API Routes
Route::prefix('job-types')->group(function () {
    Route::get('/', [JobTypeController::class, 'index'])->name('api.job-types.index');
    Route::get('/search', [JobTypeController::class, 'search'])->name('api.job-types.search');
    Route::get('/{jobType:slug}', [JobTypeController::class, 'show'])->name('api.job-types.show');
});

// Tag API Routes
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('api.tags.index');
    Route::get('/popular', [TagController::class, 'popular'])->name('api.tags.popular');
    Route::get('/search', [TagController::class, 'search'])->name('api.tags.search');
    Route::get('/{tag:slug}', [TagController::class, 'show'])->name('api.tags.show');
});

// Post API Routes
Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('/featured', [PostController::class, 'featured'])->name('api.posts.featured');
    Route::get('/popular', [PostController::class, 'popular'])->name('api.posts.popular');
    Route::get('/search', [PostController::class, 'search'])->name('api.posts.search');
    Route::get('/{post:slug}', [PostController::class, 'show'])->name('api.posts.show');
    Route::get('/{post:slug}/related', [PostController::class, 'related'])->name('api.posts.related');
});

// Career API Routes
Route::prefix('careers')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('api.careers.index');
    Route::get('/featured', [CareerController::class, 'featured'])->name('api.careers.featured');
    Route::get('/popular', [CareerController::class, 'popular'])->name('api.careers.popular');
    Route::get('/search', [CareerController::class, 'search'])->name('api.careers.search');
    Route::get('/company/{company}', [CareerController::class, 'byCompany'])->name('api.careers.by-company');
    Route::get('/{career:slug}', [CareerController::class, 'show'])->name('api.careers.show');
    Route::get('/{career:slug}/related', [CareerController::class, 'related'])->name('api.careers.related');
});

// Static Page SEO API Routes
Route::prefix('pages')->group(function () {
    Route::get('/{slug}/seo', [StaticPageController::class, 'getSeoData'])->name('api.pages.seo');
});