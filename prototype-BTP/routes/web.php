<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\DashboardPenyewaController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PenyewaDaftarRuangan;
use App\Http\Controllers\PenyewaDetailRuangan;
use App\Http\Controllers\MeminjamRuanganController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\AdminDetailRuangan;
use App\Http\Controllers\AdminStatusPengajuanController;
use App\Http\Controllers\AdminStatusRuanganController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\OkupansiController;
use App\Http\Controllers\StatusPenyewaController;

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

Route::get('/', [DashboardPenyewaController::class, 'index']);

// Authenticate
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('posts.login');
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp');
Route::get('/otp', [LoginController::class, 'otp'])->name('otp');
Route::post('/otp', [LoginController::class, 'authotp'])->name('posts.otp');
Route::get('/resend-otp', [LoginController::class, 'resendOtp'])->name('resend.otp');
Route::get('/logout', [LoginController::class, 'logout']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboardPenyewa', [DashboardPenyewaController::class, 'index'])->name('penyewa.dashboard'); // Dashboard Penyewa
Route::get('/dashboardAdmin', [DashboardAdminController::class, 'index'])->name('admin.dashboard')->middleware('auth'); // Dashboard Admin

// Register Penyewa
Route::post('/check-unique', [PenyewaController::class, 'checkUnique'])->name('check.unique');
Route::get('/daftarPenyewa', [PenyewaController::class, 'create'])->name('daftarPenyewa');
Route::post('/daftarPenyewa/posts', [PenyewaController::class, 'store'])->name('posts.daftarPenyewa');

// Peminjaman Ruangan
Route::get('/meminjamRuangan', [MeminjamRuanganController::class, 'create'])->name('penyewa.peminjamanRuangan');
Route::get('/meminjamRuangan/{id}', [MeminjamRuanganController::class, 'showPinjamRuangan'])->name('penyewa.peminjamanRuanganDariDetail');
Route::post('/meminjamRuangan/posts', [MeminjamRuanganController::class, 'store'])->name('posts.peminjamanRuangan');
Route::get('/get-ruangan-details',  [MeminjamRuanganController::class, 'getRuanganDetails']);

// Admin Lihat Status Ruangan
Route::get('/daftarRuanganAdmin', [AdminStatusRuanganController::class, 'index'])->name('admin.status')->middleware('auth');
Route::get('/detailRuanganAdmin', [AdminDetailRuangan::class, 'index'])->middleware('auth');

// Status Pengajuan
Route::get('/statusPengajuanAdmin', [AdminStatusPengajuanController::class, 'index'])->middleware('auth');
Route::post('/tambahRuanganAdmin/posts', [AdminStatusRuanganController::class, 'store'])->name('posts.ruangan')->middleware('auth');
Route::post('/check-room-name', [AdminStatusRuanganController::class, 'checkRoomName'])->name('check.room.name');
Route::post('/statusPengajuanAdmin/{id}', [AdminStatusPengajuanController::class, 'update'])->name('update.pengajuan')->middleware('auth');
Route::put('/finish/{id}', [AdminStatusPengajuanController::class, 'finish'])->name('selesaiPengajuan')->middleware('auth');

// Penyewa lihat status Ruangan
Route::get('/daftarRuanganPenyewa', [PenyewaDaftarRuangan::class, 'index'])->name('daftarRuanganPenyewa');
Route::get('/detailRuanganPenyewa/{id}', [PenyewaDetailRuangan::class, 'show'])->name('detailRuanganPenyewa');
Route::get('/get-sediaan-details',  [PenyewaDetailRuangan::class, 'getAvailableTimes']);

// Admin crud ruangan
Route::get('/tambahRuanganAdmin', [AdminStatusRuanganController::class, 'create'])->middleware('auth');
Route::get('/editRuanganAdmin/{id}/edit', [AdminStatusRuanganController::class, 'edit'])->middleware('auth');
Route::put('/editRuanganAdmin/{id}', [AdminStatusRuanganController::class, 'update'])->name('update.ruangan')->middleware('auth');
Route::get('/daftarRuanganAdmin/{id}', [AdminStatusRuanganController::class, 'destroy'])->middleware('auth'); //delete

// History
Route::get('/riwayatRuangan', [RiwayatController::class, 'index'])->name('riwayat.ruangan')->middleware('auth');
Route::get('/download-riwayat', [RiwayatController::class, 'downloadCSV'])->name('download.riwayat')->middleware('auth');

// okupansi
Route::get('/okupansiRuangan', [OkupansiController::class, 'index'])->name('admin.okupansi.index')->middleware('auth');
Route::get('/download/okupansi', [OkupansiController::class, 'downloadOkupansi'])->name('download.okupansi');

// status penyewa
Route::get('/statusPenyewa', [StatusPenyewaController::class, 'index']);
Route::get('/invoice/{id}', [StatusPenyewaController::class, 'generateInvoice'])->name('generateInvoice');
