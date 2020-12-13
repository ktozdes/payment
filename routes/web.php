<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/payment/{payment:token}', [PaymentController::class, 'edit'])->name('payment.front.edit');
Route::post('/payment/{payment:token}', [PaymentController::class, 'update'])->name('payment.front.update');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('/create', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('/store', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('/edit/{payment}', [PaymentController::class, 'edit'])->name('payment.edit');
        Route::post('/update/{payment}', [PaymentController::class, 'update'])->name('payment.update');
        Route::get('/destroy/{payment}', [PaymentController::class, 'destroy'])->name('payment.destroy');
    });
});


