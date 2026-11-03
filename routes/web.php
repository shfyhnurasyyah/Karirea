<?php

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

Route::get('/plagiat/create', function () {
    return 'Halaman Cek Plagiat (belum dibuat)';
})->name('plagiat.create');