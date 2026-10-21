<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\KodeArsipController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RolePermissionController;

// >>> Tambahan controller untuk Konfigurasi RBAC (buat file-nya kalau belum ada)
use App\Http\Controllers\Konfigurasi\MenuController;
use App\Http\Controllers\Konfigurasi\RoleController;
use App\Http\Controllers\Konfigurasi\PermissionController;
use App\Http\Controllers\Konfigurasi\AksesRoleController;
use App\Http\Controllers\Konfigurasi\AksesUserController;

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

    /* --- Kode Arsip --- */
    Route::resource('kodearsip', KodeArsipController::class);

    /* --- Arsip Global --- */
    Route::get('/arsip/nomor-registrasi/{id}', [ArsipController::class, 'getNomorRegistrasi']);
    Route::get('/arsip/{id}/edit', [ArsipController::class, 'edit'])->name('arsip.edit');
    Route::put('/arsip/{id}', [ArsipController::class, 'update'])->name('arsip.update');
    Route::get('/arsip-print', [ArsipController::class, 'print'])->name('arsip.print');
    Route::resource('arsip', ArsipController::class);

    /* --- Notifications --- */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read');

    /* --- SURAT MASUK --- */
    Route::get('/suratmasuk/print', [SuratMasukController::class, 'print'])->name('suratmasuk.print');
    Route::get('/suratmasuk/get-nomor-registrasi/{id}', [SuratMasukController::class, 'getNomorRegistrasi'])->name('suratmasuk.getNomorRegistrasi');
    Route::get('/suratmasuk/get-last-nomor', [SuratMasukController::class, 'getLastNomor'])->name('suratmasuk.get_last_nomor');
    Route::post('/ruangan/store-ajax', [SuratMasukController::class, 'storeRuanganAjax'])->name('ruangan.storeAjax');
   
    // Alur Disposisi Surat Masuk (Bisa diakses Admin & Pegawai, penanganan hak akses form/tombol diatur di Blade View)
    Route::get('/suratmasuk/{id}/disposisi', [SuratMasukController::class, 'disposisi'])->name('suratmasuk.disposisi');
    Route::post('/suratmasuk/{id}/disposisi', [SuratMasukController::class, 'kirimDisposisi'])->name('suratmasuk.kirimDisposisi');

    Route::post('/suratmasuk/{id}/verifikasi', [SuratMasukController::class, 'verifikasi'])->name('suratmasuk.verifikasi');
    Route::get('/suratmasuk/{id}/pilih-agenda', [SuratMasukController::class, 'pilihAgenda'])->name('suratmasuk.pilihAgenda');

    Route::resource('suratmasuk', SuratMasukController::class)->except(['destroy']);

    /* --- SURAT KELUAR --- */
    Route::get('/suratkeluar/print', [SuratKeluarController::class, 'print'])->name('suratkeluar.print');
    Route::get('/surat-keluar/{id}/disposisi', [SuratKeluarController::class, 'disposisi'])->name('suratkeluar.disposisi');
    Route::post('/surat-keluar/{id}/disposisi', [SuratKeluarController::class, 'storeDisposisi'])->name('suratkeluar.disposisi.store');
    Route::get('/suratkeluar/get-nomor-registrasi/{id}', [SuratKeluarController::class, 'getNomorRegistrasi'])->name('suratkeluar.getNomorRegistrasi');
    Route::resource('suratkeluar', SuratKeluarController::class);

    /* --- AGENDA --- */
    Route::get('/agenda/cek-booking', [AgendaController::class, 'cekBooking'])->name('agenda.cekBooking');
    Route::get('/agenda/create-from-surat/{id}', [AgendaController::class, 'createFromSurat'])->name('agenda.createFromSurat');
    Route::post('/agenda/store-from-surat/{id}', [AgendaController::class, 'storeFromSurat'])->name('agenda.storeFromSurat');
    Route::get('/agenda/print', [AgendaController::class, 'print'])->name('agenda.print');
    Route::get('/agenda/{agenda}/whatsapp', [AgendaController::class, 'whatsapp'])->name('agenda.whatsapp');
    Route::get('/agenda/{agenda}/hasil', [AgendaController::class, 'hasil'])->name('agenda.hasil');
    Route::post('/agenda/{agenda}/hasil', [AgendaController::class, 'simpanHasil'])->name('agenda.simpanHasil');
    Route::resource('agenda', AgendaController::class);

    /* --- LOGOUT --- */
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
    |--------------------------------------------------------------------------
    | Admin Only
    |--------------------------------------------------------------------------
    */
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('users', UserController::class);

    Route::resource('pejabat', PejabatController::class);

    Route::delete(
        '/suratmasuk/{id}',
        [SuratMasukController::class, 'destroy']
    )->name('suratmasuk.destroy');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN KEGIATAN
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/print', [LaporanController::class, 'print'])
        ->name('laporan.print');

    /*
    |--------------------------------------------------------------------------
    | ROLE PERMISSION (versi lama — toggle sederhana per menu)
    | Dibiarkan dulu supaya tidak putus; nantinya digantikan oleh
    | Konfigurasi > Akses Role di bawah setelah migrasi selesai.
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/role-menu', [RolePermissionController::class, 'index'])->name('role-permission.index');
    Route::post('/admin/role-menu/update', [RolePermissionController::class, 'update'])->name('role-permission.update');

    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI (RBAC granular: Menu, Role, Permission, Akses Role, Akses User)
    |--------------------------------------------------------------------------
    */

    Route::prefix('konfigurasi')->name('konfigurasi.')->group(function () {

        Route::resource('menu', MenuController::class);
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);

        Route::get('akses-role', [AksesRoleController::class, 'index'])->name('akses-role.index');
        Route::get('akses-role/matrix', [AksesRoleController::class, 'getMatrix'])->name('akses-role.matrix');
        Route::post('akses-role/toggle', [AksesRoleController::class, 'toggle'])->name('akses-role.toggle');
        Route::post('akses-role/copy', [AksesRoleController::class, 'copyFromRole'])->name('akses-role.copy');

        Route::get('akses-user', [AksesUserController::class, 'index'])->name('akses-user.index');
        Route::get('akses-user/matrix', [AksesUserController::class, 'getMatrix'])->name('akses-user.matrix');
        Route::post('akses-user/toggle', [AksesUserController::class, 'toggle'])->name('akses-user.toggle');
    });
});

require __DIR__.'/auth.php';