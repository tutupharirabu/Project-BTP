<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardPenyewaController;

use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Admin\Ruangan\AdminRuanganController;
use App\Http\Controllers\Admin\Ruangan\AdminEditRuanganController;
use App\Http\Controllers\Penyewa\Ruangan\PenyewaRuanganController;
use App\Http\Controllers\Admin\Ruangan\AdminTambahRuanganController;
use App\Http\Controllers\Penyewa\Peminjaman\PenyewaPeminjamanController;
use App\Http\Controllers\Penyewa\Ruangan\PenyewaDetailRuanganController;
use App\Http\Controllers\Admin\Ruangan\Okupansi\AdminOkupansiRuanganController;
use App\Http\Controllers\Admin\Peminjaman\StatusPengajuan\AdminStatusPengajuanController;
use App\Http\Controllers\Admin\Peminjaman\RiwayatPeminjaman\AdminRiwayatPeminjamanController;
use App\Http\Controllers\Penyewa\Peminjaman\StatusPengajuan\PenyewaStatusPengajuanController;

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

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboardPenyewa', [DashboardPenyewaController::class, 'index'])->name('penyewa.dashboard'); // Dashboard Penyewa
Route::get('/dashboardAdmin', [DashboardAdminController::class, 'index'])->name('admin.dashboard')->middleware('auth'); // Dashboard Admin

Route::get('/health', [HealthCheckController::class, 'check'])
    ->middleware(['health.ip', 'throttle:60,1']); // 60 requests per minute

// New Routing - Admin

/**
 *  Admin - Register
 */
Route::get('/registerAdmin', [RegisterController::class, 'index']);
Route::post('/registerAdmin', [RegisterController::class, 'store'])->name('register.postRegisterAdminOrPetugas');
Route::post('/registerAdmin/checkUnique', [RegisterController::class, 'checkUnique'])->name('register.checkUnique');
/**
 *  Done - Admin (Register)
 */

/**
 *  Admin - Login
 */
Route::get('/login', [LoginController::class, 'index'])->name('login.adminOrPetugas');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticateAdminOrPetugas');
Route::get('/logout', [LoginController::class, 'logout']);
/**
 *  Done - Admin (Login)
 */

Route::middleware(['auth', 'throttle:60,1'])->group(function () {
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

    /**
     *  Admin - Okupansi Ruangan
     */
    Route::get('/okupansiRuanganAdmin', [AdminOkupansiRuanganController::class, 'index'])->name('okupansi.tabelOkupansiRuangan');
    Route::get('/okupansiRuanganAdmin/downloadFileOkupansiRuangan', [AdminOkupansiRuanganController::class, 'downloadOkupansi'])->name('okupansi.downloadDataOkupansiRuangan');
    /**
     *  Done - Admin (Okupansi Ruangan)
     */

    /**
     *  Admin - Riwayat Ruangan
     */
    Route::get('/riwayatPeminjamanRuanganAdmin', [AdminRiwayatPeminjamanController::class, 'index']);
    Route::get('/riwayatPeminjamanRuanganAdmin/downloadRiwayatPeminjamanRuangan', [AdminRiwayatPeminjamanController::class, 'downloadCSV'])->name('riwayat.downloadRiwayatPeminjamanRuangan');
    /**
     *  Done - Admin (Riwayat Ruangan)
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
Route::get('/statusPengajuanPenyewa/cetakInvoice/{id}', [PenyewaStatusPengajuanController::class, 'generateInvoice'])->name('penyewa.cetakInvoicePengajuanPeminjaman');
/**
 *  Done - Penyewa (Lihat Status Pengajuan)
 */