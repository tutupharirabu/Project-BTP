<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\MeminjamRuanganController;
use App\Http\Controllers\MeminjamBarangController;
use App\Http\Controllers\AdminRuanganController;
// use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\UserDashboardController;
// use App\Http\Controllers\AdminDashboardController;

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

// Authenticate
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'authenticate']);

// Register penyewa
Route::get('/daftarPenyewa', [PenyewaController::class, 'create'])->name('daftarPenyewa');
Route::post('/daftarPenyewa/posts', [PenyewaController::class, 'store'])->name('posts.daftarPenyewa');

// Form peminjaman Ruangan
Route::get('/daftarMeminjamRuangan', [MeminjamRuanganController::class, 'create'])->name('daftarMeminjamRuangan');
Route::post('/daftarMeminjamRuangan/posts', [MeminjamRuanganController::class, 'store'])->name('posts.daftarMeminjamRuangan');

// Form peminjaman Barang
Route::get('/daftarMeminjamBarang', [MeminjamBarangController::class, 'create'])->name('daftarMeminjamBarang');
Route::post('/daftarMeminjamBarang/posts', [MeminjamBarangController::class, 'store'])->name('posts.daftarMeminjamBarang');

// Route::get('/register', [RegisterController::class, 'index']);
// Route::post('/register', [RegisterController::class, 'store']);

// crud ruangan
Route::get('/adminRuangan', [AdminRuanganController::class, 'index'])->name('admin.ruangan');
Route::get('/adminRuangan/tambahRuangan', [AdminRuanganController::class, 'create'])->name('admin.ruangan.tambahRuangan');
Route::post('/adminRuangan/posts', [AdminRuanganController::class, 'store'])->name('posts.adminRuangan');

Route::get('/adminDashboard', [AdminDashboardController::class, 'index']);

// Route::get('/userDashboard', [UserDashboardController::class, 'index']);
Route::post('/userDashboard', [UserDashboardController::class, 'store']);
