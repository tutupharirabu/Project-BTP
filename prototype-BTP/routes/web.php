<?php

use App\Http\Controllers\Penyewa\Peminjaman\StatusPengajuan\PenyewaStatusPengajuanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\OkupansiController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\StatusPenyewaController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardPenyewaController;

use App\Http\Controllers\HealthcheckController;
use App\Http\Controllers\Admin\Ruangan\AdminRuanganController;
use App\Http\Controllers\Admin\Ruangan\AdminEditRuanganController;
use App\Http\Controllers\Penyewa\Ruangan\PenyewaRuanganController;
use App\Http\Controllers\Admin\Ruangan\AdminTambahRuanganController;
use App\Http\Controllers\Penyewa\Peminjaman\PenyewaPeminjamanController;
use App\Http\Controllers\Penyewa\Ruangan\PenyewaDetailRuanganController;
use App\Http\Controllers\Admin\Peminjaman\StatusPengajuan\AdminStatusPengajuanController;

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
Route::get('/logout', [LoginController::class, 'logout']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboardPenyewa', [DashboardPenyewaController::class, 'index'])->name('penyewa.dashboard'); // Dashboard Penyewa
Route::get('/dashboardAdmin', [DashboardAdminController::class, 'index'])->name('admin.dashboard')->middleware('auth'); // Dashboard Admin

// Register Penyewa
Route::post('/check-unique', [PenyewaController::class, 'checkUnique'])->name('check.unique');
Route::get('/daftarPenyewa', [PenyewaController::class, 'create'])->name('daftarPenyewa');
Route::post('/daftarPenyewa/posts', [PenyewaController::class, 'store'])->name('posts.daftarPenyewa');

// History
Route::get('/riwayatRuangan', [RiwayatController::class, 'index'])->name('riwayat.ruangan')->middleware('auth');
Route::get('/download-riwayat', [RiwayatController::class, 'downloadCSV'])->name('download.riwayat')->middleware('auth');

// okupansi
Route::get('/okupansiRuangan', [OkupansiController::class, 'index'])->name('admin.okupansi.index')->middleware('auth');
Route::get('/download/okupansi', [OkupansiController::class, 'downloadOkupansi'])->name('download.okupansi');

Route::get('/health', [HealthCheckController::class, 'check'])
    ->middleware(['health.ip', 'throttle:60,1']); // 60 requests per minute

// New Routing - Admin
Route::middleware('auth')->group(function () {
    /**
     *  Admin - CRUD Ruangan
     */
    Route::get('/daftarRuanganAdmin', [AdminRuanganController::class, 'index'])->name('ruangan.listRuangan');
    Route::post('/checkRuanganName', [AdminRuanganController::class, 'checkRuanganName'])->name('ruangan.cekNama');

    // Tambah Ruangan (Admin - CRUD Ruangan)
    Route::get('/tambahRuanganAdmin', [AdminTambahRuanganController::class, 'index'])->name('ruangan.tambahRuangan');
    Route::post('/tambahRuanganAdmin', [AdminTambahRuanganController::class, 'store'])->name('ruangan.simpanDataRuangan');

    // Edit Ruangan
    Route::get('/editRuanganAdmin/{id}', [AdminEditRuanganController::class, 'edit'])->name('ruangan.editRuangan');
    Route::put('/editRuanganAdmin/{id}', [AdminEditRuanganController::class, 'update'])->name('ruangan.updateDataRuangan');

    // Hapus Ruangan
    Route::get('/daftarRuanganAdmin/{id}', [AdminRuanganController::class, 'destroy'])->name('ruangan.hapusDataRuangan');
    /**
     *  Done - Admin (CRUD Ruangan)
     */

    /**
     *  Admin - Status Pengajuan Peminjaman
     */
    Route::get('/statusPengajuanAdmin', [AdminStatusPengajuanController::class, 'index']);
    Route::post('/statusPengajuanAdmin/{id}', [AdminStatusPengajuanController::class, 'update'])->name('statusPengajuan.updateStatusPengajuan');
    Route::put('/finishPeminjaman/{id}', [AdminStatusPengajuanController::class, 'finish'])->name('statusPengajuan.selesaiPeminjaman');
    /**
     *  Done - Admin (Status Pengajuan Peminjaman)
     */
});

// New Routing - Penyewa

/**
 *  Penyewa - Daftar Ruangan & Detail Ruangan
 */
Route::get('/daftarRuanganPenyewa', [PenyewaRuanganController::class, 'index'])->name('penyewa.listRuangan');
Route::get('/detailRuanganPenyewa/{id}', [PenyewaDetailRuanganController::class, 'show'])->name('penyewa.detailRuangan');
Route::get('/getAvailableTimes', [PenyewaDetailRuanganController::class, 'getAvailableTimes']);
/**
 *  Done - Penyewa (Daftar Ruangan & Detail Ruangan)
 */

/**
 *  Penyewa - Form Peminjaman
 */
Route::get('/meminjamRuangan/{id?}', [PenyewaPeminjamanController::class, 'index'])->name('penyewa.formPeminjaman');
Route::post('/meminjamRuangan', [PenyewaPeminjamanController::class, 'store'])->name('penyewa.postFormPeminjaman');
Route::get('/getRuanganDetails', [PenyewaPeminjamanController::class, 'getDetailRuangan']);
/**
 *  Done - Penyewa (Form Peminjaman)
 */

/**
 *  Penyewa - Lihat Status Pengajuan
 */
Route::get('/statusPengajuanPenyewa', [PenyewaStatusPengajuanController::class, 'index']);
Route::get('/cetakInvoice/{id}', [PenyewaStatusPengajuanController::class, 'generateInvoice'])->name('penyewa.cetakInvoicePengajuanPeminjaman');
/**
 *  Done - Penyewa (Lihat Status Pengajuan)
 */