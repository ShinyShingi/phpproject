<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\VueBookController;

use App\Http\Controllers\BookApiController;

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

Route::get('books', [BookApiController::class, 'index']);
Route::post('books/{id}', [VueBookController::class,'updateBook']);

