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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//Route::post('/get-token', [AuthController::class, 'getToken']);

Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);
Route::get('/genres', [GenreController::class, 'index']);




//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::patch('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);

    Route::put('/authors/{author}', [AuthorController::class, 'update']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/test', [AuthController::class, 'test']);
});

//Route::get('/authors', function () {
//    return Author::all();
//});


//Route::get('books/search/{author}', [BookController::class, 'search']);


Route::get('/genres', function () {
    return Genre::all();
});
