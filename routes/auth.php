<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Rute untuk menampilkan formulir registrasi
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Rute untuk menangani registrasi
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Rute untuk menampilkan formulir login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Rute untuk menangani login
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Rute untuk menampilkan formulir forgot password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Rute untuk menangani permintaan forgot password
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Rute untuk menampilkan formulir reset password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Rute untuk menangani pengaturan password baru
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Rute untuk menampilkan prompt verifikasi email
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Rute untuk menangani verifikasi email
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Rute untuk mengirim ulang email verifikasi
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Rute untuk menampilkan formulir konfirmasi password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // Rute untuk menangani konfirmasi password
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Rute untuk menangani perubahan password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Rute untuk menangani logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
