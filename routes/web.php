<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('auth.google');

Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('auth.google.callback');
Route::get('/otp', [App\Http\Controllers\Auth\GoogleController::class, 'otpForm'])->name('otp.form');
Route::post('/otp', [App\Http\Controllers\Auth\GoogleController::class, 'otpVerify'])->name('otp.verify');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);

    Route::resource('buku', App\Http\Controllers\BukuController::class);
});