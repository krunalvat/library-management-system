<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('books',BookController::class);
Route::get('book-data', [BookController::class, 'getData'])->name('books.data');
Route::get('book-borrowing', [BookController::class, 'borrowingBook'])->name('borrowing.book');
Route::post('store-borrow-data', [BookController::class, 'storeBorrowBookData'])->name('store.borrow.data');