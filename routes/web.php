<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BoardGameController;
use App\Http\Controllers\PasswordResetController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/register', [MemberController::class, 'create']);
Route::post('/register', [MemberController::class, 'store']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login-failed', [AuthController::class, 'failed']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* 260413 @fj v1.2 update change routes
Route::get('/reservation', [ReservationController::class, 'create']);
Route::post('/reservation', [ReservationController::class, 'store']);

Route::get('/thank-you/{reservation}', [ReservationController::class, 'thankYou']);
*/

//260407_forgetpassword function @Sha
Route::get('/forgot-password', [PasswordResetController::class, 'showRequestForm']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);

//260407_forgetpassword function @Sha
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/board-games', [BoardGameController::class, 'index'])->name('board-games');

/*  260413 @fj v1.2 update change routes
//260408_Profile @fj
Route::get('/profile', [MemberController::class, 'profile'])->middleware('auth.session');
Route::post('/profile', [MemberController::class, 'updateProfile'])->middleware('auth.session');

//260408_Reservation History & Cancel @fj
Route::get('/reservation-history', [ReservationController::class, 'history'])->middleware('auth.session');
Route::delete('/reservation/{reservation}', [ReservationController::class, 'cancel'])->middleware('auth.session');
*/ 

//260408_API route for availability @fj
Route::get('/api/available-spaces', [ReservationController::class, 'getAvailableSpaces']);

//260408_debugging @fj
Route::post('/test-reservation', function(Request $request) {
    \Log::info('Test reservation received:', $request->all());
    return response()->json(['message' => 'Form data received', 'data' => $request->all()]);
});

Route::get('/board-games', [BoardGameController::class, 'index'])->name('board-games.index');
Route::get('/board-games/{id}', [BoardGameController::class, 'show'])->name('board-games.show');

Route::middleware(['web'])->group(function () {
    // Reservation routes
    Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation');    Route::post('/reservation', [ReservationController::class, 'store']);
    Route::get('/thank-you/{reservation}', [ReservationController::class, 'thankYou']);
    Route::delete('/reservation/{reservation}', [ReservationController::class, 'cancel']);
    
    // Profile routes
    Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
    Route::get('/profile/info', [MemberController::class, 'profileInfo'])->name('profile.info');
    Route::get('/profile/edit', [MemberController::class, 'profileEdit'])->name('profile.edit');
    Route::post('/profile/edit', [MemberController::class, 'updateProfile']);
    Route::post('/profile/password', [MemberController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/history', [ReservationController::class, 'profileHistory'])->name('profile.history');
});
Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store']);
Route::get('/reservation/confirm', [ReservationController::class, 'showConfirm'])->name('reservation.confirm');
Route::post('/reservation/confirm', [ReservationController::class, 'processConfirm'])->name('reservation.process');
Route::post('/reservation/temp', [ReservationController::class, 'storeTemp'])->name('reservation.temp');