<?php

use App\Http\Controllers\BookController;
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

Route::get('/books', [BookController::class, 'index']);
Route::prefix('/book')->group( function() {
    Route::post('/store', [BookController::class,'store']);
    Route::put('/{id}', [BookController::class, 'update']);
    Route::delete('/{id}', [BookController::class, 'destroy']);
});
Route::get('create', [BookController::class, 'create']);
Route::get('edit', [BookController::class, 'edit']);
Route::post('store-data', [BookController::class,'store']);
Route::post('/updateBook/{id}', [BookController::class, 'update']);
Route::delete('/updateBook/{id}', [BookController::class,'destroy']);
