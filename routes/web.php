<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Master Data
Route::get('/admin/barang', [MasterController::class, 'indexBarang'])->name('admin.barang');
Route::get('/admin/barang/create', [MasterController::class, 'createBarang']);
Route::post('/admin/barang', [MasterController::class, 'storeBarang']);
Route::delete('/admin/barang/{id}', [MasterController::class, 'destroyBarang']);

Route::get('/admin/role', [MasterController::class, 'indexRole']);
Route::get('/admin/user', [MasterController::class, 'indexUser']);
Route::get('/admin/user/create', [MasterController::class, 'createUser']);
Route::post('/admin/user', [MasterController::class, 'storeUser']);
Route::delete('/admin/user/{id}', [MasterController::class, 'destroyUser']);

Route::get('/admin/satuan', [MasterController::class, 'indexSatuan']);
Route::get('/admin/satuan/create', [MasterController::class, 'createSatuan']);
Route::post('/admin/satuan', [MasterController::class, 'storeSatuan']);
Route::delete('/admin/satuan/{id}', [MasterController::class, 'destroySatuan']);

Route::get('/admin/vendor', [MasterController::class, 'indexVendor']);
Route::get('/admin/vendor/create', [MasterController::class, 'createVendor']);
Route::post('/admin/vendor', [MasterController::class, 'storeVendor']);
Route::delete('/admin/vendor/{id}', [MasterController::class, 'destroyVendor']);

Route::get('/admin/margin', [MasterController::class, 'indexMargin']);
Route::get('/admin/margin/create', [MasterController::class, 'createMargin']);
Route::post('/admin/margin', [MasterController::class, 'storeMargin']);
Route::delete('/admin/margin/{id}', [MasterController::class, 'destroyMargin']);

// Edit & Update Master Barang
Route::get('/admin/barang/{id}/edit', [MasterController::class, 'editBarang']);
Route::put('/admin/barang/{id}', [MasterController::class, 'updateBarang']);

// Edit & Update Master User
Route::get('/admin/user/{id}/edit', [MasterController::class, 'editUser']);
Route::put('/admin/user/{id}', [MasterController::class, 'updateUser']);

// Edit & Update Master Satuan
Route::get('/admin/satuan/{id}/edit', [MasterController::class, 'editSatuan']);
Route::put('/admin/satuan/{id}', [MasterController::class, 'updateSatuan']);

// Edit & Update Master Vendor
Route::get('/admin/vendor/{id}/edit', [MasterController::class, 'editVendor']);
Route::put('/admin/vendor/{id}', [MasterController::class, 'updateVendor']);

// Edit & Update Master Margin Penjualan
Route::get('/admin/margin/{id}/edit', [MasterController::class, 'editMargin']);
Route::put('/admin/margin/{id}', [MasterController::class, 'updateMargin']);

// Route Transaksi
Route::get('/admin/pengadaan', [TransactionController::class, 'indexPengadaan']);
Route::get('/admin/pengadaan/create', [TransactionController::class, 'createPengadaan']);
Route::post('/admin/pengadaan', [TransactionController::class, 'storePengadaan']);
Route::delete('/admin/pengadaan/{id}', [TransactionController::class, 'destroyPengadaan']);

Route::get('/admin/penerimaan', [TransactionController::class, 'indexPenerimaan']);
Route::get('/admin/penerimaan/create', [TransactionController::class, 'createPenerimaan']);
Route::post('/admin/penerimaan', [TransactionController::class, 'storePenerimaan']);

Route::get('/admin/penjualan', [TransactionController::class, 'indexPenjualan']);
Route::get('/admin/penjualan/create', [TransactionController::class, 'createPenjualan']);
Route::post('/admin/penjualan', [TransactionController::class, 'storePenjualan']);

require __DIR__.'/auth.php';

// Login & Logout Kustom (diletakkan setelah auth.php agar tidak tertimpa)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
