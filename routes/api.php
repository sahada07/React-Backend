<?php


use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReviewController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::apiResource('users', CartController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::get('/allbooks', [BookController::class, 'index']);
Route::post('/carts/remove', [CartController::class, 'removeFromCart'])->middleware('auth:sanctum');
Route::apiResource('books', BookController::class);
Route::get('/books', [BookController::class, 'getBooksByGenre']);


//Route::middleware('auth:sanctum')->group(function () {
    Route::get('/carts', [CartController::class, 'index']);
    Route::post('/carts/add', [CartController::class, 'addToCart']);
    // other routes...
//});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Protect the routes with sanctum
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('users', UserController::class);
    Route::apiResource('carts', CartController::class);
    
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('reviews', ReviewController::class);
});