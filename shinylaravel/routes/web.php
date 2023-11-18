<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\VueBookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [BookController::class, 'index']);
Route::get("books", [VueBookController::class, 'index']);


Route::get('create', [BookController::class, 'create']);
Route::get('edit', [BookController::class, 'edit']);
Route::post('store-data', [BookController::class,'store']);
Route::post('/updateStatus/{id}', [BookController::class, 'updateStatus']);
Route::delete('/updateBook/{id}', [BookController::class,'destroy']);

Route::get('/getBook/{id}', [VueBookController::class,'getBook']);
Route::post('/updateBook/{id}', [BookController::class,'updateBook']);


