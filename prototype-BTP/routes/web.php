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

// Dashboard penyewa
Route::get('/dashboardPenyewa', [DashboardPenyewaController::class, 'create'])->name('penyewa.dashboard')->middleware('auth');
// Route::post('/userDashboard', [UserDashboardController::class, 'store']);

//Peminjaman
// Peminjaman Ruangan
Route::get('/meminjamRuangan', [MeminjamRuanganController::class, 'create'])->name('penyewa.peminjamanRuangan')->middleware('auth');
Route::post('/meminjamRuangan/posts', [MeminjamRuanganController::class, 'store'])->name('posts.peminjamanRuangan')->middleware('auth');
Route::get('/get-ruangan-details',  [MeminjamRuanganController::class, 'getRuanganDetails'])->middleware('auth');


// Peminjaman Barang
Route::get('/meminjamBarang', [MeminjamBarangController::class, 'index'])->name('penyewa.peminjamanBarang')->middleware('auth');

// // Pengajuan admin
// Route::get('/pengajuan', [AdminPengajuanController::class, 'create'])->name('admin.pengajuan');
// Route::post('/pengajuan/{id}', [AdminPengajuanController::class, 'update'])->name('update.pengajuan');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Pengajuan admin
Route::get('/pengajuan', [AdminPengajuanController::class, 'create'])->name('admin.pengajuan')->middleware('auth');
Route::post('/pengajuan/{id}', [AdminPengajuanController::class, 'update'])->name('update.pengajuan')->middleware('auth');

// Admin lihat status Ruangan
Route::get('/statusRuanganAdmin', [AdminStatusRuanganController::class, 'index'])->name('admin.status')->middleware('auth');
Route::get('/detailRuanganAdmin', [AdminDetailRuangan::class, 'index'])->middleware('auth');

// Status Pengajuan
Route::get('/statusPengajuanAdmin', [AdminStatusPengajuanController::class, 'index'])->middleware('auth');

// Admin Menambah ruangan
// Route::get('/tambahRuanganAdmin', [AdminTambahRuangan::class, 'index']);

// Penyewa lihat status Ruangan
Route::get('/statusRuanganPenyewa', [PenyewaStatusRuanganController::class, 'index'])->name('statusRuangan')->middleware('auth');
Route::get('/daftarRuanganPenyewa', [PenyewaDaftarRuangan::class, 'index'])->middleware('auth');
Route::get('/detailRuanganPenyewa', [PenyewaDetailRuangan::class, 'index'])->middleware('auth');

//Admin crud ruangan
Route::get('/tambahRuanganAdmin', [AdminStatusRuanganController::class, 'create'])->middleware('auth');
Route::post('/tambahRuanganAdmin/posts', [AdminStatusRuanganController::class, 'store'])->name('posts.ruangan')->middleware('auth');
Route::post('/upload',[AdminStatusRuanganController::class,'dropzone'])->name('dropzone.store')->middleware('auth');
Route::get('/editRuanganAdmin/{id}/edit', [AdminStatusRuanganController::class, 'edit'])->middleware('auth');
Route::put('/editRuanganAdmin/{id}', [AdminStatusRuanganController::class, 'update'])->name('update.ruangan')->middleware('auth');
Route::get('/daftarRuanganAdmin/{id}', [AdminStatusRuanganController::class, 'destroy'])->middleware('auth'); //delete
