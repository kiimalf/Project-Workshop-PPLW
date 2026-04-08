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

    Route::get('/modul/tm4_tableHTML', [App\Http\Controllers\ModulController::class, 'tm4_tableHTML'])->name('modul.tm4_tableHTML');
    Route::get('/modul/tm4_datatables', [App\Http\Controllers\ModulController::class, 'tm4_datatables'])->name('modul.tm4_datatables');
    Route::get('/modul/tm4_2select', [App\Http\Controllers\ModulController::class, 'tm4_selectKota'])->name('modul4.2select');

    Route::get('/modul/tm5_index',[App\Http\Controllers\ModulController::class, 'tm5_index'])->name('modul.tm5_index');
    Route::post('/modul/tm5_ajaxSubmit',[App\Http\Controllers\ModulController::class, 'tm5_ajaxSubmit'])->name('modul.tm5_ajaxSubmit');
    Route::get('/modul/tm5_ajaxSelect', [App\Http\Controllers\ModulController::class, 'tm5_ajaxSelect'])->name('modul.tm5_ajaxSelect');
    Route::get('/modul/tm5_axiosSelect', [App\Http\Controllers\ModulController::class, 'tm5_axiosSelect'])->name('modul.tm5_axiosSelect');

    Route::get('/modul/tm5_getProvinsi', [App\Http\Controllers\ModulController::class, 'tm5_getProvinsi'])->name('modul.tm5_getProvinsi');
    Route::get('/modul/tm5_getKota', [App\Http\Controllers\ModulController::class, 'tm5_getKota'])->name('modul.tm5_getKota');
    Route::get('/modul/tm5_getKecamatan', [App\Http\Controllers\ModulController::class, 'tm5_getKecamatan'])->name('modul.tm5_getKecamatan');
    Route::get('/modul/tm5_getKelurahan', [App\Http\Controllers\ModulController::class, 'tm5_getKelurahan'])->name('modul.tm5_getKelurahan');

    Route::get('/modul/tm5_ajaxPOS', [App\Http\Controllers\POSController::class, 'POS_ajax'])->name('POS_ajax');
    Route::get('/modul/tm5_axiosPOS', [App\Http\Controllers\POSController::class, 'POS_axios'])->name('POS_axios');
    Route::get('/modul/findBarang', [App\Http\Controllers\POSController::class, 'findBarang'])->name('findBarang');
    Route::post('modul/store', [App\Http\COntrollers\POSController::class, 'store'])->name('store');
});