<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\FeedbackController;


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

Route::get('/', [BookController::class, 'index'])->name('index');

Auth::routes();


Route::prefix('/book')->name('book.')->group(function() {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/libary/{id}', [BookController::class, 'libary'])->name('libary');
    Route::patch('/addLibary/{id}', [BookController::class, 'addLibary'])->name('addLibary');
    Route::get('/bukusaya', [BookController::class, 'bukusaya'])->name('bukusaya');
    Route::get('/datatable', [BookController::class, 'datatable'])->name('datatable');
    
    Route::get('/create', [BookController::class, 'create'])->name('create');
    Route::post('/store', [BookController::class, 'store'])->name('store');


    Route::get('/edit/{id}', [BookController::class, 'edit'])->name('edit');
    Route::patch('/update/{id}', [BookController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [BookController::class, 'destroy'])->name('destroy');
    Route::post('/return/{id}', [BookController::class, 'return'])->name('return');
    Route::middleware('IsAdmin')->group(function () {  
        Route::get('/riwayat-Peminjaman', [BookController::class, 'riwayatPeminjaman'])->name('riwayatPeminjaman');
    });
    Route::post('/change-status/{id}', [BookController::class, 'StatusDipinjam'])->name('StatusDipinjam');

    Route::post('/borrows/{id}/restore', [BookController::class, 'restore'])->name('restore');
    Route::delete('/borrows/{id}/forcedelete', [BookController::class, 'forcedelete'])->name('forcedelete');
    Route::get('/history', [BookController::class, 'history'])->name('history');
});

Route::prefix('/bookrequest')->name('bookrequest.')->group(function() {
    Route::get('/create', [BookRequestController::class, 'create'])->name('create');
    Route::post('/store', [BookRequestController::class, 'store'])->name('store');
    Route::get('/', [BookRequestController::class, 'index'])->name('index')->middleware('IsAdmin');
    Route::patch('/update-status/{id}', [BookRequestController::class, 'updateStatus'])->name('updateStatus')->middleware('IsAdmin');
    Route::get('/show/{id}', [BookRequestController::class, 'show'])->name('show');
    Route::delete('/destroy/{id}', [BookRequestController::class, 'destroy'])->name('destroy')->middleware('IsAdmin');
});

Route::prefix('/feedback')->name('feedback.')->group(function() {
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('store');
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('index');
    Route::delete('/feedbacks/{id}', [FeedbackController::class, 'destroy'])->name('destroy');
});

Route::get('/permission', function() {
    return view('permission');
})->name('permission');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



