<?php

use App\Http\Controllers\BookController;
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
Route::prefix('/book')->group( function() {
    //Route::post('/store', [BookController::class,'store']);
    //Route::put('/updateBook/{id}', [BookController::class, 'update']);
    //Route::delete('/{id}', [BookController::class, 'destroy']);
});
Route::get('create', [BookController::class, 'create']);
Route::get('edit', [BookController::class, 'edit']);
Route::post('store-data', [BookController::class,'store']);
Route::post('/updateStatus/{id}', [BookController::class, 'updateStatus']);
Route::delete('/updateBook/{id}', [BookController::class,'destroy']);

Route::get('/getBook/{id}', [BookController::class,'getBook']);
Route::post('/updateBook/{id}', [BookController::class,'updateBook']);



//Route::match(['put', 'delete', 'post'], 'store-data', [BookController::class, 'store']);

// Route::get('/check-storage', function() {
//     if (Storage::disk('public')->put('test.txt', 'Write something')) {
//         return 'The storage is writable!';
//     } else {
//         return 'The storage is not writable!';
//     }
// });

