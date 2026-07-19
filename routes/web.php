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
| AUTH USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',
        [DashboardController::class,'index']
    )->name('dashboard');



    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile',
        [ProfileController::class,'edit']
    )->name('profile.edit');


    Route::patch('/profile',
        [ProfileController::class,'update']
    )->name('profile.update');



    /*
    |--------------------------------------------------------------------------
    | Arsip
    |--------------------------------------------------------------------------
    */

    Route::resource('arsip',
        ArsipController::class
    );



    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications',
        [NotificationController::class,'index']
    )->name('notifications.index');


    Route::post('/notifications/read/{id}',
        [NotificationController::class,'read']
    )->name('notifications.read');




    /*
    |--------------------------------------------------------------------------
    | SURAT MASUK
    |--------------------------------------------------------------------------
    */


    // PRINT
    Route::get('/suratmasuk/print',
        [SuratMasukController::class,'print']
    )->name('suratmasuk.print');



    // DISPOSISI

    Route::get('/suratmasuk/{id}/disposisi',
        [SuratMasukController::class,'disposisi']
    )->name('suratmasuk.disposisi');


    Route::post('/suratmasuk/{id}/disposisi',
        [SuratMasukController::class,'kirimDisposisi']
    )->name('suratmasuk.kirimDisposisi');



    // VERIFIKASI

    Route::post('/suratmasuk/{id}/verifikasi',
        [SuratMasukController::class,'verifikasi']
    )->name('suratmasuk.verifikasi');



    /*
    |--------------------------------------------------------------------------
    | RESOURCE SURAT MASUK
    |--------------------------------------------------------------------------
    */

    Route::resource('suratmasuk',
        SuratMasukController::class
    );
    





    /*
    |--------------------------------------------------------------------------
    | SURAT KELUAR
    |--------------------------------------------------------------------------
    */


    Route::get('/suratkeluar/print',
        [SuratKeluarController::class,'print']
    )->name('suratkeluar.print');


    Route::resource('suratkeluar',
        SuratKeluarController::class
    );





    /*
    |--------------------------------------------------------------------------
    | AGENDA
    |--------------------------------------------------------------------------
    */


    Route::get('/cek-booking',
        [AgendaController::class,'cekBooking']
    )->name('agenda.cekBooking');


    Route::get('/agenda/create/{id}',
        [AgendaController::class,'create']
    )->name('agenda.create');


    Route::post('/agenda/store/{id}',
        [AgendaController::class,'store']
    )->name('agenda.store');


    Route::get('/agenda/{agenda}/whatsapp',
    [AgendaController::class,'whatsapp']
)->name('agenda.whatsapp');


Route::get('/agenda/{agenda}/hasil',
    [AgendaController::class,'hasil']
)->name('agenda.hasil');

Route::post(
    '/agenda/{agenda}/hasil',
    [AgendaController::class,'simpanHasil']
)->name('agenda.simpanHasil');

Route::get('/agenda/print',
    [AgendaController::class,'print']
)->name('agenda.print');

    Route::resource('agenda',
        AgendaController::class
    )->except([
        'create',
        'store'
    ]);




    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout',
        [AuthenticatedSessionController::class,'destroy']
    )->name('logout');

});





/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    'role:admin'
])->group(function(){


    Route::resource('users',
        UserController::class
    );


    Route::resource('pejabat',
        PejabatController::class
    );


    Route::resource('laporan', LaporanController::class)
    ->except(['show']);


    Route::get('/laporan/print',
        [LaporanController::class,'print']
    )->name('laporan.print');


});



require __DIR__.'/auth.php';