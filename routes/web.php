<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiDetailController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
| Di sini Anda dapat mendaftarkan route web untuk aplikasi Anda.
| Semua route ini dimuat oleh RouteServiceProvider dan semuanya
| akan diberikan ke grup middleware "web".
|
*/

// Route untuk LoginController
Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

// Route dengan middleware 'auth' untuk memastikan hanya pengguna yang sudah login yang bisa mengakses
Route::middleware('auth')->group(function () {

    // Route untuk Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk Transaksi
    Route::prefix('/transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('edit/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit');
        Route::put('update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::delete('delete/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });

    // Route untuk TransaksiDetail
    Route::prefix('/transaksidetail')->group(function () {
        Route::get('/', [TransaksiDetailController::class, 'index'])->name('transaksidetail.index');
        Route::get('/{id_transaksi}', [TransaksiDetailController::class, 'detail'])->name('transaksidetail.detail');
        Route::get('edit/{id}', [TransaksiDetailController::class, 'edit'])->name('transaksidetail.edit');
        Route::put('update/{id}', [TransaksiDetailController::class, 'update'])->name('transaksidetail.update');
        Route::delete('delete/{id}', [TransaksiDetailController::class, 'destroy'])->name('transaksidetail.destroy');
    });
});

