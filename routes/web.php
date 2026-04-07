<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BoardGameController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/register', [MemberController::class, 'create']);
Route::post('/register', [MemberController::class, 'store']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
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

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/board-games', [BoardGameController::class, 'index'])->name('board-games');

//260408_Profile @fj
Route::get('/profile', [MemberController::class, 'profile'])->middleware('auth.session');
Route::post('/profile', [MemberController::class, 'updateProfile'])->middleware('auth.session');

//260408_Reservation History & Cancel @fj
Route::get('/reservation-history', [ReservationController::class, 'history'])->middleware('auth.session');
Route::delete('/reservation/{reservation}', [ReservationController::class, 'cancel'])->middleware('auth.session');

//260408_API route for availability @fj
Route::get('/api/available-spaces', [ReservationController::class, 'getAvailableSpaces']);
