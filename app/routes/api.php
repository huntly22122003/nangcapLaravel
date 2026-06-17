<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;

// Public routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/{id}/products', [CategoryController::class, 'getProducts']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/new', [ProductController::class, 'getNewProducts']);
Route::get('/products/featured', [ProductController::class, 'getFeaturedProducts']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/recent', [PostController::class, 'getRecent']);
Route::get('/posts/{id}', [PostController::class, 'show']);

Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);

Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{id}', [GalleryController::class, 'show']);

Route::get('/banners', [BannerController::class, 'index']);

Route::get('/menus', [MenuController::class, 'index']);

Route::post('/contacts', [ContactController::class, 'store']);
Route::post('/registrations', [RegistrationController::class, 'store']);

// Cart routes
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::put('/cart/update', [CartController::class, 'update']);
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove']);
Route::post('/cart/checkout', [CartController::class, 'checkout']);

// Order routes
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);