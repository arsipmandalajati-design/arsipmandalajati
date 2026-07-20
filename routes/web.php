<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| AUTH USER (SEMUA USER YANG LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /* --- Dashboard --- */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* --- Profile --- */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /* --- Arsip Global --- */
    Route::resource('arsip', ArsipController::class);

    /* --- Notifications --- */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read');

    /* --- SURAT MASUK --- */
    // Catatan: Rute kustom HARUS di atas Route::resource agar tidak terbaca sebagai {suratmasuk} ID
    Route::get('/suratmasuk/print', [SuratMasukController::class, 'print'])->name('suratmasuk.print');
    Route::get('/suratmasuk/get-nomor-registrasi/{kode_arsip_id}', [SuratMasukController::class, 'getNomorRegistrasi'])->name('suratmasuk.getNomor');

    // Alur Disposisi & Agenda
    Route::get('/suratmasuk/{id}/disposisi', [SuratMasukController::class, 'disposisi'])->name('suratmasuk.disposisi');
    Route::post('/suratmasuk/{id}/disposisi', [SuratMasukController::class, 'kirimDisposisi'])->name('suratmasuk.kirimDisposisi');
    Route::post('/suratmasuk/{id}/verifikasi', [SuratMasukController::class, 'verifikasi'])->name('suratmasuk.verifikasi');
    Route::get('/suratmasuk/{id}/pilih-agenda', [SuratMasukController::class, 'pilihAgenda'])->name('suratmasuk.pilihAgenda');

    Route::resource('suratmasuk', SuratMasukController::class);

    /* --- SURAT KELUAR --- */
    Route::get('/suratkeluar/print', [SuratKeluarController::class, 'print'])->name('suratkeluar.print');
    Route::resource('suratkeluar', SuratKeluarController::class);

    /* --- AGENDA --- */
    // Fitur Cek Ruangan via AJAX (Digunakan oleh komponen jQuery cekBooking)
    Route::get('/agenda/cek-booking', [AgendaController::class, 'cekBooking'])->name('agenda.cekBooking');
    
    // Pembuatan agenda khusus yang ditarik dari disposisi surat masuk
    Route::get('/agenda/create-from-surat/{id}', [AgendaController::class, 'createFromSurat'])->name('agenda.createFromSurat');
    Route::post('/agenda/store-from-surat/{id}', [AgendaController::class, 'storeFromSurat'])->name('agenda.storeFromSurat');
    
    // Fitur Tambahan Agenda
    Route::get('/agenda/print', [AgendaController::class, 'print'])->name('agenda.print');
    Route::get('/agenda/{agenda}/whatsapp', [AgendaController::class, 'whatsapp'])->name('agenda.whatsapp');
    Route::get('/agenda/{agenda}/hasil', [AgendaController::class, 'hasil'])->name('agenda.hasil');
    Route::post('/agenda/{agenda}/hasil', [AgendaController::class, 'simpanHasil'])->name('agenda.simpanHasil');
    
    // Resource penuh agar tombol tambah agenda mandiri/biasa tetap berfungsi normal
    Route::resource('agenda', AgendaController::class);

    /* --- LOGOUT --- */
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY (KHUSUS HAK AKSES ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::resource('users', UserController::class);
    Route::resource('pejabat', PejabatController::class);
    
    Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
    Route::resource('laporan', LaporanController::class)->except(['show']);
});

require __DIR__.'/auth.php';