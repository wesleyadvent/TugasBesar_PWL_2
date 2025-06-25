<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KeuanganPendaftaranController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\PendaftaranEventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SertifikatController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [EventController::class, 'index2'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/administrator/dashboard', [AdministratorController::class, 'dashboard'])->name('administrator.dashboard');

    Route::get('administrator/users', [UserController::class, 'index'])->name('administrator.users.index');
    Route::get('administrator/users/create', [UserController::class, 'create'])->name('administrator.users.create');
    Route::post('administrator/users', [UserController::class, 'store'])->name('administrator.users.store');         
    Route::get('administrator/users/{user}/edit', [UserController::class, 'edit'])->name('administrator.users.edit');
    Route::put('administrator/users/{user}', [UserController::class, 'update'])->name('administrator.users.update');
    Route::delete('administrator/users/{user}', [UserController::class, 'destroy'])->name('administrator.users.destroy');
    Route::patch('administrator/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('administrator.users.toggleStatus');
});
Route::middleware(['auth', 'role:keuangan'])->group(function () {
    Route::get('/keuangan', [KeuanganPendaftaranController::class, 'index'])->name('keuangan.dashboard');
    Route::post('/keuangan/proses/{id}', [KeuanganPendaftaranController::class, 'prosesPembayaran'])->name('keuangan.prosesPembayaran');
    Route::get('/keuangan/selesai', [KeuanganPendaftaranController::class, 'selesai'])->name('keuangan.selesai');
});

Route::middleware(['auth', 'role:panitia'])->group(function () {
    Route::get('/panitia/dashboard', [PanitiaController::class, 'dashboard'])->name('panitia.dashboard');

    Route::get('/panitia/events', [EventController::class, 'index'])->name('panitia.event.index');
    Route::get('/panitia/events/create', [EventController::class, 'create'])->name('panitia.event.create');
    Route::post('/panitia/events', [EventController::class, 'store'])->name('panitia.event.store');
    Route::get('/panitia/events/{event}/edit', [EventController::class, 'edit'])->name('panitia.event.edit');
    Route::put('/panitia/events/{event}', [EventController::class, 'update'])->name('panitia.event.update');
    Route::delete('/panitia/events/{event}', [EventController::class, 'destroy'])->name('panitia.event.destroy');
    Route::get('/panitia/events/{event}', [EventController::class, 'show'])->name('panitia.event.show'); 
    
    Route::get('/Re-Registration', function () {return view('panitia.daftar_ulang.index');})->name('panitia.daftar_ulang.index');

    Route::get('/panitia/sertifikat', [SertifikatController::class, 'index'])->name('panitia.sertifikat.index');
    Route::get('/panitia/sertifikat/{id}', [SertifikatController::class, 'show'])->name('panitia.sertifikat.show');
    Route::post('/panitia/sertifikat/upload/{kehadiranId}', [SertifikatController::class, 'upload'])->name('panitia.sertifikat.upload');
    Route::get('/panitia/keuangan', [KeuanganController::class, 'index'])->name('panitia.keuangan.index');
    Route::get('/panitia/keuangan/{id}', [KeuanganController::class, 'show'])->name('panitia.keuangan.show');

});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [PendaftaranEventController::class, 'index'])->name('member.dashboard');
    Route::get('/member/event-saya', [PendaftaranEventController::class, 'daftarSaya'])->name('member.eventSaya');
    Route::get('/member/event/{id}/form', [PendaftaranEventController::class, 'showForm'])->name('event.daftar');
    Route::post('/member/event/daftar', [PendaftaranEventController::class, 'store'])->name('event.store');
    Route::get('/member/qr/{id}', [PendaftaranEventController::class, 'showQR'])->name('member.qr');
});

Route::get('/sertifikat/download/{kehadiranId}', [SertifikatController::class, 'download'])->name('sertifikat.download');

require __DIR__.'/auth.php';
