<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/daftarPenyewa', [PenyewaController::class, 'create'])->name('daftarPenyewa');
Route::post('/daftarPenyewa/posts', [PenyewaController::class, 'store'])->name('posts.daftarPenyewa');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/adminDashboard', [AdminDashboardController::class, 'index']);

Route::get('/userDashboard', [UserDashboardController::class, 'index']);
Route::post('/userDashboard', [UserDashboardController::class, 'store']);

