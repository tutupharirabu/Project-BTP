<?php

use App\Http\Controllers\AdminDetailRuangan;
use App\Http\Controllers\AdminStatusPengajuanController;
use App\Http\Controllers\AdminTambahRuangan;
use App\Http\Controllers\PenyewaDetailRuangan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenyewaController;
// use App\Http\Controllers\AdminBarangController;
// use App\Http\Controllers\AdminRuanganController;
// use App\Http\Controllers\AdminPengajuanController;
// use App\Http\Controllers\MeminjamBarangController;
// use App\Http\Controllers\MeminjamRuanganController;
use App\Http\Controllers\DashboardPenyewaController;
use App\Http\Controllers\PeminjamanController;
// use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\UserDashboardController;
// use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminStatusRuanganController;
use App\Http\Controllers\PenyewaStatusRuanganController;
use App\Http\Controllers\PenyewaDaftarRuangan;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminPengajuanController;
use App\Http\Controllers\MeminjamBarangController;
use App\Http\Controllers\MeminjamRuanganController;

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
Route::post('/login', [LoginController::class, 'authenticate'])->name('posts.login');
Route::get('/logout', [LoginController::class, 'logout']);

// Register penyewa
Route::get('/daftarPenyewa', [PenyewaController::class, 'create'])->name('daftarPenyewa');
Route::post('/daftarPenyewa/posts', [PenyewaController::class, 'store'])->name('posts.daftarPenyewa');

// // CRUD ruangan
// Route::get('/adminRuangan', [AdminRuanganController::class, 'index'])->name('admin.ruangan');
// Route::get('/adminRuangan/tambahRuangan', [AdminRuanganController::class, 'create'])->name('admin.ruangan.tambahRuangan');
// Route::post('/adminRuangan/posts', [AdminRuanganController::class, 'store'])->name('posts.adminRuangan');
// Route::get('/adminRuangan/{id}/detail', [AdminRuanganController::class, 'show'])->name('detail.adminRuangan');
// Route::get('/adminRuangan/{id}/edit', [AdminRuanganController::class, 'edit'])->name('edit.adminRuangan');
// Route::put('/adminRuangan/{id}', [AdminRuanganController::class, 'update'])->name('update.adminRuangan');
// Route::delete('/adminRuangan/delete/{id}', [AdminRuanganController::class, 'destroy'])->name('destroy.AdminRuangan');

// // CRUD barang

// Route::get('/adminBarang', [AdminBarangController::class, 'index'])->name('admin.barang');
// Route::get('/adminBarang/tambahBarang', [AdminBarangController::class, 'create'])->name('admin.barang.tambahBarang');
// Route::post('/adminBarang/posts', [AdminBarangController::class, 'store'])->name('posts.adminBarang');
// Route::get('/adminBarang/{id}/detail', [AdminBarangController::class, 'show'])->name('detail.adminBarang');
// Route::get('/adminBarang/{id}/edit', [AdminBarangController::class, 'edit'])->name('edit.adminBarang');
// Route::put('/adminBarang/{id}', [AdminBarangController::class, 'update'])->name('update.adminBarang');
// Route::delete('/adminBarang/delete/{id}', [AdminBarangController::class, 'destroy'])->name('destroy.AdminBarang');

// Dashboard penyewa

Route::get('/dashboardPenyewa', [DashboardPenyewaController::class, 'create'])->name('penyewa.dashboard');
// Route::post('/userDashboard', [UserDashboardController::class, 'store']);

//Peminjaman

Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('penyewa.peminjaman');
Route::get('/meminjamRuangan', [MeminjamRuanganController::class, 'index'])->name('penyewa.peminjamanRuangan');
Route::get('/meminjamBarang', [MeminjamBarangController::class, 'index'])->name('penyewa.peminjamanBarang');

// // Pengajuan admin

// Route::get('/pengajuan', [AdminPengajuanController::class, 'create'])->name('admin.pengajuan');
// Route::post('/pengajuan/{id}', [AdminPengajuanController::class, 'update'])->name('update.pengajuan');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Pengajuan admin
Route::get('/pengajuan', [AdminPengajuanController::class, 'create'])->name('admin.pengajuan');
Route::post('/pengajuan/{id}', [AdminPengajuanController::class, 'update'])->name('update.pengajuan');

// Admin lihat status Ruangan
Route::get('/statusRuanganAdmin', [AdminStatusRuanganController::class, 'index'])->name('admin.status');
Route::get('/detailRuanganAdmin', [AdminDetailRuangan::class, 'index']);
Route::get('/statusPengajuanAdmin', [AdminStatusPengajuanController::class, 'index']);

// Penyewa lihat status Ruangan
Route::get('/statusRuanganPenyewa', [PenyewaStatusRuanganController::class, 'index']);
Route::get('/daftarRuanganPenyewa', [PenyewaDaftarRuangan::class, 'index']);
Route::get('/detailRuanganPenyewa', [PenyewaDetailRuangan::class, 'index']);

//Admin crud ruangan
Route::get('/tambahRuanganAdmin', [AdminStatusRuanganController::class, 'create']); //create
Route::get('/editRuanganAdmin', [AdminStatusRuanganController::class, 'edit']); //create
Route::get('/daftarRuanganAdmin/{id}', [AdminStatusRuanganController::class, 'destroy']); //delete
