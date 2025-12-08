<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\RecipientImportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// =======================
Route::get('/', function () {
    return redirect()->route('login');
});

// =======================
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // =======================
    // QR PRINT (sesuai pola)
    // =======================

    // Print QR 1 penerima
    Route::get('/recipients/{recipient}/qr-print',
        [RecipientController::class, 'printQrCode'])
        ->name('recipients.qr-print');

    // Print QR semua penerima (mengikuti pola yang sama)
    Route::get('/recipients/all/qr-print',
        [RecipientController::class, 'printQrAll'])
        ->name('recipients.qr-print-all');

    // CRUD utama
    Route::resource('recipients', RecipientController::class);

    // QR Code generator
    Route::get('/recipients/{recipient}/qr-code', [RecipientController::class, 'generateQrCode'])
        ->name('recipients.qr-code');

    // Scanner & verifikasi
    Route::get('/scan', [RecipientController::class, 'scanQr'])->name('recipients.scan');
    Route::post('/recipients/verify-qr', [RecipientController::class, 'verifyQr'])->name('recipients.verify-qr');

    // Distribusi
    Route::post('/recipients/{recipient}/distribute', [RecipientController::class, 'distribute'])
        ->name('recipients.distribute');

    // Bukti Kwitansi
    Route::get('/recipients/{recipient}/receipt', [RecipientController::class, 'generateReceipt'])
        ->name('recipients.receipt');

    // Tanda Tangan
    Route::get('/recipients/{recipient}/signature', [RecipientController::class, 'generateSignatureForm'])
        ->name('recipients.signature');

    // Report
    Route::get('/report', [RecipientController::class, 'generateReport'])->name('recipients.report');

    // Import Excel
    Route::get('/recipient/import', [RecipientImportController::class, 'form']);
    Route::post('/recipient/import', [RecipientImportController::class, 'import'])->name('recipients.import');

    // Registrasi QR
    Route::post('/verify-qr-registration', [RecipientController::class, 'verifyQrRegistration']);
    Route::post('/mark-registered', [RecipientController::class, 'markRegistered']);

    Route::get('/registration', function () {
        return view('registration');
    })->name('registration');

    Route::post('/registration/verify', [RegistrationController::class, 'verifyRegistrationQr'])
        ->name('registration.verify');

    Route::post('/registration/confirm', [RegistrationController::class, 'confirmRegistration'])
        ->name('registration.confirm');
});

// ===========================
// Export PDF status penyaluran
Route::get('/recipients/{recipient}/export-distribution',
    [RecipientController::class, 'exportDistribution'])
    ->name('recipients.export-distribution');
// =======================

// USER PANEL
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('userdashboard');
    Route::get('/list', [UserController::class, 'list'])->name('list');
});

// Static Pages
Route::get('/tentang-kami', fn() => view('pages.tentang-kami'))->name('tentang');
Route::get('/program', fn() => view('pages.program'))->name('program');
Route::get('/zakat', fn() => view('pages.zakat'))->name('zakat');
Route::get('/wakaf', fn() => view('pages.wakaf'))->name('wakaf');
Route::get('/kontak', fn() => view('pages.kontak'))->name('kontak');

// Logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
