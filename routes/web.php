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


    Route::post('/barang/previewPdf', [App\Http\Controllers\BarangController::class, 'previewPdf'])->name('barang.previewPdf');
    Route::get('/barang/previewPdf', [App\Http\Controllers\BarangController::class, 'preview'])->name('barang.preview');
    Route::post('/barang/print', [App\Http\Controllers\BarangController::class, 'printPdf'])->name('barang.print');

    Route::resource('barang', App\Http\Controllers\BarangController::class);
    
    Route::get('/undangan/download', [App\Http\Controllers\PdfController::class, 'downloadUndangan'])->name('undangan.download');
    Route::get('/undangan', [App\Http\Controllers\PdfController::class, 'previewUndangan'])->name('undangan.preview');

    Route::get('/sertifikat/download', [App\Http\Controllers\PdfController::class, 'downloadSertifikat'])->name('sertifikat.download');
    Route::get('/sertifikat', [App\Http\Controllers\PdfController::class, 'previewSertifikat'])->name('sertifikat.preview');

    Route::get('/modul4/tableHTML', [App\Http\Controllers\Modul4Controller::class, 'tableHTML'])->name('modul4.tableHTML');
    Route::get('/modul4/datatables', [App\Http\Controllers\Modul4Controller::class, 'datatables'])->name('modul4.datatables');
    Route::get('/modul4/2select', [App\Http\Controllers\Modul4Controller::class, 'selectKota'])->name('modul4.2select');
});