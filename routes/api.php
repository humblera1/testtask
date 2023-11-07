<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Resources\BookCollection;
use App\Models\Author;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(BookController::class)->group(function () {
    Route::get('/books', 'index');
    Route::get('/books/{book}', 'show');
});

Route::controller(AuthorController::class)->group(function () {
    Route::get('/authors', 'index');
    Route::get('/authors/{author}', 'show');
});

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::controller(BookController::class)->group(function () {
        Route::post('/books', 'store');
        Route::put('/books/{book}', 'update');
        Route::patch('/books/{book}', 'update');
        Route::delete('/books/{book}', 'destroy');
    });

    Route::controller(AuthorController::class)->group(function () {
        Route::put('/authors/{author}', 'update');
        Route::patch('/authors/{author}', 'update');
        Route::delete('/authors/{author}', 'destroy');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::get('/me', 'me');
        Route::post('/logout', 'logout');
        Route::post('/change-password', 'changePassword');
    });
});
