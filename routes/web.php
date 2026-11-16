<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\TransactionController;

// Route untuk melihat data barang (bisa dibungkus middleware auth jika sudah login)
Route::get('/admin/barang', [MasterController::class, 'indexBarang'])->name('admin.barang');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Master Data
Route::get('/admin/barang', [MasterController::class, 'indexBarang']);
Route::get('/admin/role', [MasterController::class, 'indexRole']);
Route::get('/admin/user', [MasterController::class, 'indexUser']);
Route::get('/admin/satuan', [MasterController::class, 'indexSatuan']);
Route::get('/admin/vendor', [MasterController::class, 'indexVendor']);
Route::get('/admin/margin', [MasterController::class, 'indexMargin']);

// Route Transaksi
Route::get('/admin/pengadaan', [TransactionController::class, 'indexPengadaan']);
Route::get('/admin/penerimaan', [TransactionController::class, 'indexPenerimaan']);
Route::get('/admin/penjualan', [TransactionController::class, 'indexPenjualan']);

require __DIR__.'/auth.php';
