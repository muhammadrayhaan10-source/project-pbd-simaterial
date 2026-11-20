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

// Route untuk menampilkan form tambah barang dan menyimpan data barang baru
Route::get('/admin/barang/create', [MasterController::class, 'createBarang']);
Route::post('/admin/barang', [MasterController::class, 'storeBarang']);

// Route untuk satuan
Route::get('/admin/satuan', [MasterController::class, 'indexSatuan']);
Route::get('/admin/satuan/create', [MasterController::class, 'createSatuan']);
Route::post('/admin/satuan', [MasterController::class, 'storeSatuan']);

// Route Master Data
Route::get('/admin/barang', [MasterController::class, 'indexBarang']);
Route::get('/admin/role', [MasterController::class, 'indexRole']);
Route::get('/admin/user', [MasterController::class, 'indexUser']);
Route::get('/admin/satuan', [MasterController::class, 'indexSatuan']);
Route::get('/admin/vendor', [MasterController::class, 'indexVendor']);
Route::get('/admin/margin', [MasterController::class, 'indexMargin']);
Route::delete('/admin/satuan/{id}', [MasterController::class, 'destroySatuan']);
Route::delete('/admin/barang/{id}', [MasterController::class, 'destroyBarang']);
Route::get('/admin/margin/create', [MasterController::class, 'createMargin']);
Route::post('/admin/margin', [MasterController::class, 'storeMargin']);
Route::delete('/admin/margin/{id}', [MasterController::class, 'destroyMargin']);
Route::get('/admin/user/create', [MasterController::class, 'createUser']);
Route::post('/admin/user', [MasterController::class, 'storeUser']);
Route::delete('/admin/user/{id}', [MasterController::class, 'destroyUser']);

// Route Transaksi
Route::get('/admin/pengadaan', [TransactionController::class, 'indexPengadaan']);
Route::get('/admin/penerimaan', [TransactionController::class, 'indexPenerimaan']);
Route::get('/admin/penjualan', [TransactionController::class, 'indexPenjualan']);

Route::get('/admin/vendor/create', [MasterController::class, 'createVendor']);
Route::post('/admin/vendor', [MasterController::class, 'storeVendor']);
Route::delete('/admin/vendor/{id}', [MasterController::class, 'destroyVendor']);

require __DIR__.'/auth.php';
