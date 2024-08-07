<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/register', [AuthController::class, 'index']);
// Route::post('/user/register', [AuthController::class, 'store'])->name('store');

Route::post('/rolelogin', [AuthController::class, 'roleLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/login', function() {
    return Auth::check() ? redirect('/dashboard') : view('auth.login');
})->middleware('guest')->name('login');

Route::group(['middleware' => ['auth', 'cekrole:kasir']], function() {
    Route::get('kasir/dashboard', [DashboardController::class, 'index']);

    Route::get('/kasir/kasir', [KasirController::class, 'index']);
    Route::post('/kasir/kasir/store', [KasirController::class, 'store']);
    Route::post('/kasir/kasir/bayar/{kodeTransaksi}', [KasirController::class, 'pembayaran']);
    Route::get('/kasir/kasir/{id}', [KasirController::class, 'destroy']);
    Route::get('/kasir/kasir/hapus/semua', [KasirController::class, 'hapusSemua']);
    Route::put('/kasir/kasir/{id}/{barang_id}/edit', [KasirController::class, 'update']);

    Route::get('/kasir/laporan/{kodeTransaksi}/print', [TransaksiController::class, 'print']);

    Route::get('/kasir/laporan', [TransaksiController::class, 'index']);
    Route::get('/kasir/laporan/{kodeTransaksi}', [TransaksiController::class, 'show']);

});

Route::group(['middleware' => ['auth', 'cekrole:admin']], function() {
    Route::get('admin/dashboard', [DashboardController::class, 'index']);

    Route::get('admin/produk', [ProdukController::class, 'index']);
    Route::post('admin/produk/store', [ProdukController::class, 'store']);
    Route::get('admin/produk/{id}/edit', [ProdukController::class, 'edit']);
    Route::put('admin/produk/{id}', [ProdukController::class, 'update']);
    Route::get('admin/produk/{id}', [ProdukController::class, 'destroy']);

    Route::get('/admin/laporan', [TransaksiController::class, 'index']);
    Route::get('/admin/laporan/cari', [TransaksiController::class, 'cari']);
    
    Route::get('/admin/laporan/{dari}/{sampai}/print', [TransaksiController::class, 'totalPrint']);
    Route::get('/admin/laporan/{kodeTransaksi}/print', [TransaksiController::class, 'print']);
    Route::get('/admin/laporan/{kodeTransaksi}', [TransaksiController::class, 'show']);

    Route::get('/admin/user', [UserController::class, 'index']);
    Route::post('/admin/user/store', [UserController::class, 'store']);
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/admin/user/{id}', [UserController::class, 'update']);
    Route::get('/admin/user/{id}', [UserController::class, 'destroy']);
});