<?php

use App\Http\Controllers\PlagiatController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/admin/login', function () {
    return 'Halaman Login Admin (belum dibuat)';
})->name('admin.login');

Route::get('/cv/create', function () {
    return view('cv.create');
})->name('cv.create');

Route::post('/cv/store', function () {
    return 'Proses optimasi CV belum dibuat';
})->name('cv.store');

Route::prefix('plagiat')->name('plagiat.')->group(function () {
    Route::get('/create', [PlagiatController::class, 'create'])->name('create');
    Route::post('/store', [PlagiatController::class, 'store'])->name('store');
    Route::get('/hasil/{cek}', [PlagiatController::class, 'show'])->name('show');
});

Route::get('/resume/create', [ResumeController::class, 'create'])->name('resume.create');
Route::post('/resume', [ResumeController::class, 'store'])->name('resume.store');