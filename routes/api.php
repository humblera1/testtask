<?php

use App\Http\Controllers\BookController;
use App\Models\Author;

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

Route::get('/authors', function () {
    return Author::all();
});

Route::resource('books', BookController::class);


Route::get('/genres', function () {
    return Genre::all();
});
