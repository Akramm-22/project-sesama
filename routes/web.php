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

    Route::get('/recipients/print-all', [RecipientController::class, 'printAllQrCodes'])->name('recipients.printAll');
    Route::resource('recipients', RecipientController::class);

    Route::get('/recipients/{recipient}/qr-code', [RecipientController::class, 'generateQrCode'])->name('recipients.qr-code');
    Route::get('/recipients/{recipient}/qr-print', [RecipientController::class, 'printQrCode'])->name('recipients.qr-print');
    
    Route::get('/scan', [RecipientController::class, 'scanQr'])->name('recipients.scan');
    Route::post('/recipients/verify-qr', [RecipientController::class, 'verifyQr'])->name('recipients.verify-qr');
    Route::post('/recipients/{recipient}/distribute', [RecipientController::class, 'distribute'])->name('recipients.distribute');
    Route::get('/recipients/{recipient}/receipt', [RecipientController::class, 'generateReceipt'])->name('recipients.receipt');
    Route::get('/recipients/{recipient}/signature', [RecipientController::class, 'generateSignatureForm'])->name('recipients.signature');
    Route::get('/report', [RecipientController::class, 'generateReport'])->name('recipients.report');

    Route::get('/recipient/import', [RecipientImportController::class, 'form']);
    Route::post('/recipient/import', [RecipientImportController::class, 'import'])->name('recipients.import');

    Route::post('/verify-qr-registration', [RecipientController::class, 'verifyQrRegistration']);
    Route::post('/mark-registered', [RecipientController::class, 'markRegistered']);

    Route::get('/registration', function () {
        return view('registration');
    })->name('registration');
    Route::post('/registration/verify', [RegistrationController::class, 'verifyRegistrationQr'])->name('registration.verify');
    Route::post('/registration/confirm', [RegistrationController::class, 'confirmRegistration'])->name('registration.confirm');
});

// ===========================
    // export pdf status penyaluran

    Route::get('/recipients/{recipient}/export-distribution',
    [RecipientController::class, 'exportDistribution'])
    ->name('recipients.export-distribution');

    // status penyaluran

// =======================
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('userdashboard');
    Route::get('/list', [UserController::class, 'list'])->name('list');
});
Route::get('/tentang-kami', function () {
    return view('pages.tentang-kami');
})->name('tentang');

Route::get('/program', function () {
    return view('pages.program');
})->name('program');
Route::get('/zakat', action: function () {
    return view('pages.zakat');
})->name('zakat');
Route::get('/wakaf', action: function () {
    return view('pages.wakaf');
})->name(name: 'wakaf');
Route::get('/kontak', action: function () {
    return view('pages.kontak');
})->name(name: 'kontak');
// =======================
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
