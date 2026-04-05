<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi');
Route::post('/transaksi/store', [TransactionController::class, 'store'])->name('transaksi.store');
Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori');
Route::post('/kategori/store', [CategoryController::class, 'store'])->name('kategori.store');
Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});