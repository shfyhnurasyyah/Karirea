<?php

use App\Http\Controllers\PlagiatController;
use Illuminate\Http\Request;
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