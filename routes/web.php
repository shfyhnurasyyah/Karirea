<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\PlagiatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Halaman pilihan "Mulai gratis"
Route::get('/mulai', fn () => view('mulai'))->name('mulai');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

Route::get('/cv/create', function () {
    return view('cv.create');
})->name('cv.create');

Route::get('/cv/optimasi', function () {
    return view('cv.optimasi', ['targetPosisi' => 'Product Designer']);
})->name('cv.optimasi');

Route::post('/cv/store', function (Request $request) {
    $validated = $request->validate([
        'target_posisi' => ['required', 'string', 'max:120'],
    ]);

    return view('cv.optimasi', ['targetPosisi' => $validated['target_posisi']]);
})->name('cv.store');

Route::prefix('plagiat')->name('plagiat.')->group(function () {
    Route::get('/create', [PlagiatController::class, 'create'])->name('create');
    Route::post('/store', [PlagiatController::class, 'store'])->name('store');
    Route::get('/hasil/{cek}', [PlagiatController::class, 'show'])->name('show');
});
