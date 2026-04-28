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

Route::post('midtrans/webhook', [App\Http\Controllers\CustomerController::class, 'webhook'])->name('midtrans.webhook');

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

    Route::get('/modul_4/tableHTML', [App\Http\Controllers\ModulController::class, 'tm4_tableHTML'])->name('modul_4.tableHTML');
    Route::get('/modul_4/datatables', [App\Http\Controllers\ModulController::class, 'tm4_datatables'])->name('modul_4.datatables');
    Route::get('/modul_4/2select', [App\Http\Controllers\ModulController::class, 'tm4_selectKota'])->name('modul_4.2select');

    Route::get('/modul_5/index', [App\Http\Controllers\ModulController::class, 'tm5_index'])->name('modul_5.index');
    Route::post('/modul_5/ajaxSubmit', [App\Http\Controllers\ModulController::class, 'tm5_ajaxSubmit'])->name('modul_5.ajaxSubmit');
    Route::get('/modul_5/ajaxSelect', [App\Http\Controllers\ModulController::class, 'tm5_ajaxSelect'])->name('modul_5.ajaxSelect');
    Route::get('/modul_5/axiosSelect', [App\Http\Controllers\ModulController::class, 'tm5_axiosSelect'])->name('modul_5.axiosSelect');

    Route::get('/modul_5/getProvinsi', [App\Http\Controllers\ModulController::class, 'tm5_getProvinsi'])->name('modul_5.getProvinsi');
    Route::get('/modul_5/getKota', [App\Http\Controllers\ModulController::class, 'tm5_getKota'])->name('modul_5.getKota');
    Route::get('/modul_5/getKecamatan', [App\Http\Controllers\ModulController::class, 'tm5_getKecamatan'])->name('modul_5.getKecamatan');
    Route::get('/modul_5/getKelurahan', [App\Http\Controllers\ModulController::class, 'tm5_getKelurahan'])->name('modul_5.getKelurahan');

    Route::get('/modul_5/ajaxPOS', [App\Http\Controllers\POSController::class, 'POS_ajax'])->name('modul_5.ajaxPOS');
    Route::get('/modul_5/axiosPOS', [App\Http\Controllers\POSController::class, 'POS_axios'])->name('modul_5.axiosPOS');
    Route::get('/modul_5/findBarang', [App\Http\Controllers\POSController::class, 'findBarang'])->name('POS.findBarang');
    Route::post('/modul_5/store', [App\Http\Controllers\POSController::class, 'store'])->name('POS.store');

    Route::get('customer/index', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/payment/{idpesanan}', [App\Http\Controllers\CustomerController::class, 'payment'])->name('customer.payment');
    Route::get('customer/success/{idpesanan}', [App\Http\Controllers\CustomerController::class, 'paymentSuccess'])->name('customer.paymentSuccess');
    Route::post('customer/updateStatus', [App\Http\Controllers\CustomerController::class, 'updateStatus'])->name('customer.updateStatus');
    Route::post('customer/checkout', [App\Http\Controllers\CustomerController::class, 'checkout'])->name('customer.checkout');
    Route::get('/customer/pesanan', [App\Http\Controllers\PesananController::class, 'index'])->name('customer.pesanan');

    Route::get('/vendor/{idvendor}/menu', [App\Http\Controllers\VendorController::class, 'getMenuByVendor'])->name('vendor.menu.index');
    Route::get('/vendor/{idvendor}/menu/create', [App\Http\Controllers\VendorController::class, 'createMenu'])->name('vendor.menu.create');
    Route::post('/vendor/{idvendor}/menu/store', [App\Http\Controllers\VendorController::class, 'storeMenu'])->name('vendor.menu.store');
    Route::get('/vendor/{idvendor}/menu/edit/{idmenu}', [App\Http\Controllers\VendorController::class, 'editMenu'])->name('vendor.menu.edit');
    Route::put('/vendor/{idvendor}/menu/update/{idmenu}', [App\Http\Controllers\VendorController::class, 'updateMenu'])->name('vendor.menu.update');
    Route::delete('/vendor/{idvendor}/menu/delete/{idmenu}', [App\Http\Controllers\VendorController::class, 'deleteMenu'])->name('vendor.menu.delete');

    Route::get('/vendor/{idvendor}/pesanan', [App\Http\Controllers\VendorController::class, 'getPesananByVendor'])->name('vendor.pesanan.index');
    Route::get('/vendor/{idvendor}/pesanan/{idpesanan}', [App\Http\Controllers\VendorController::class, 'getDetailPesanan'])->name('vendor.pesanan.detail');
});
