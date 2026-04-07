<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/register', [MemberController::class, 'create']);
Route::post('/register', [MemberController::class, 'store']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login-failed', [AuthController::class, 'failed']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/reservation', [ReservationController::class, 'create']);
Route::post('/reservation', [ReservationController::class, 'store']);

Route::get('/thank-you/{reservation}', [ReservationController::class, 'thankYou']);
use App\Http\Controllers\PasswordResetController;

//260407_forgetpassword function @Sha
Route::get('/forgot-password', [PasswordResetController::class, 'showRequestForm']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);

//260407_forgetpassword function @Sha
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
