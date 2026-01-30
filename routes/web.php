<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TandaTanganController;
use App\Http\Controllers\BackupLettersController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    // Surat Masuk Routes
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::post('surat-masuk/{suratMasuk}/submit', [SuratMasukController::class, 'submit'])->name('surat-masuk.submit');
    Route::post('surat-masuk/{suratMasuk}/archive', [SuratMasukController::class, 'archive'])->name('surat-masuk.archive');
    Route::post('surat-masuk/delete-all', [SuratMasukController::class, 'deleteAll'])->name('surat-masuk.delete-all');

    // Tanda Tangan Routes (Signature Management for Kepala Sekolah)
    Route::get('tanda-tangan', [TandaTanganController::class, 'index'])->name('tanda-tangan.index');
    Route::get('tanda-tangan/create', [TandaTanganController::class, 'create'])->name('tanda-tangan.create');
    Route::post('tanda-tangan', [TandaTanganController::class, 'store'])->name('tanda-tangan.store');
    Route::get('tanda-tangan/{tandaTangan}', [TandaTanganController::class, 'show'])->name('tanda-tangan.show');
    Route::delete('tanda-tangan/{tandaTangan}', [TandaTanganController::class, 'destroy'])->name('tanda-tangan.destroy');

    // Disposisi Routes
    Route::get('surat-masuk/{suratMasuk}/disposisi/create', [DisposisiController::class, 'create'])->name('disposisi.create');
    Route::post('surat-masuk/{suratMasuk}/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
    Route::get('disposisi/{disposisi}', [DisposisiController::class, 'show'])->name('disposisi.show');
    Route::get('disposisi/{disposisi}/edit', [DisposisiController::class, 'edit'])->name('disposisi.edit');
    Route::put('disposisi/{disposisi}', [DisposisiController::class, 'update'])->name('disposisi.update');
    Route::post('disposisi/{disposisi}/receive', [DisposisiController::class, 'receive'])->name('disposisi.receive');
    Route::get('surat-masuk/{suratMasuk}/lampiran-disposisi/download', [SuratMasukController::class, 'downloadLampiranDisposisi'])->name('surat-masuk.download-lampiran-disposisi');

    // Surat Keluar Routes
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::get('surat-keluar-saya', [SuratKeluarController::class, 'myLetters'])->name('surat-keluar.my-letters');
    Route::post('surat-keluar/{suratKeluar}/publish', [SuratKeluarController::class, 'publish'])->name('surat-keluar.publish');
    Route::post('surat-keluar/{suratKeluar}/archive', [SuratKeluarController::class, 'archive'])->name('surat-keluar.archive');
    Route::post('surat-keluar/delete-all', [SuratKeluarController::class, 'deleteAll'])->name('surat-keluar.delete-all');

    // Arsip Routes
    Route::get('arsip/surat-masuk', [ArsipController::class, 'suratMasuk'])->name('arsip.surat-masuk');
    Route::get('arsip/surat-keluar', [ArsipController::class, 'suratKeluar'])->name('arsip.surat-keluar');

    // Laporan Routes
    Route::get('laporan/surat-masuk', [LaporanController::class, 'suratMasuk'])->name('laporan.surat-masuk');
    Route::get('laporan/surat-masuk/export-pdf', [LaporanController::class, 'exportPdfSuratMasuk'])->name('laporan.surat-masuk.export-pdf');
    Route::get('laporan/surat-keluar', [LaporanController::class, 'suratKeluar'])->name('laporan.surat-keluar');
    Route::get('laporan/surat-keluar/export-pdf', [LaporanController::class, 'exportPdfSuratKeluar'])->name('laporan.surat-keluar.export-pdf');

    // Admin Routes
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // User Management
        Route::get('users', [AdminController::class, 'userIndex'])->name('admin.users.index');
        Route::get('users/create', [AdminController::class, 'userCreate'])->name('admin.users.create');
        Route::post('users', [AdminController::class, 'userStore'])->name('admin.users.store');
        Route::get('users/{user}/edit', [AdminController::class, 'userEdit'])->name('admin.users.edit');
        Route::put('users/{user}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
        Route::delete('users/{user}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');

        // Backup Routes
        Route::get('backup', [AdminController::class, 'backup'])->name('admin.backup');
        Route::post('backup/database', [AdminController::class, 'backupDatabase'])->name('admin.backup.database');
        Route::get('backup/list', [AdminController::class, 'backupList'])->name('admin.backup.list');
        Route::get('backup/{filename}/download', [AdminController::class, 'downloadBackup'])->name('admin.backup.download');
        Route::post('backup/{filename}/restore', [AdminController::class, 'restoreBackup'])->name('admin.backup.restore');
        Route::delete('backup/{filename}', [AdminController::class, 'deleteBackup'])->name('admin.backup.delete');

        // Backup Letters Routes
        Route::get('backup-letters', [BackupLettersController::class, 'index'])->name('admin.backup-letters.index');
        Route::get('backup-letters/create', [BackupLettersController::class, 'create'])->name('admin.backup-letters.create');
        Route::post('backup-letters', [BackupLettersController::class, 'store'])->name('admin.backup-letters.store');
        Route::get('backup-letters/{backupLetters}', [BackupLettersController::class, 'show'])->name('admin.backup-letters.show');
        Route::get('backup-letters/{backupLetters}/download', [BackupLettersController::class, 'download'])->name('admin.backup-letters.download');
        Route::get('backup-letters/{backupLetters}/restore', [BackupLettersController::class, 'restore'])->name('admin.backup-letters.restore');
        Route::post('backup-letters/{backupLetters}/restore', [BackupLettersController::class, 'restoreStore'])->name('admin.backup-letters.restore-store');
        Route::delete('backup-letters/{backupLetters}', [BackupLettersController::class, 'delete'])->name('admin.backup-letters.delete');
    });
});

