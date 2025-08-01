<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\OverrideController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Generic logout route
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

// Role-based authentication routes
Route::prefix('superadmin')->group(function () {
    Route::post('/auth/login', [LoginController::class, 'login']);
    // TEMPORARILY DISABLED - SuperadminPengajuanBarangController issues
    // Route::post('/pembelian-barang/{pembelian}/approve', [SuperadminPengajuanBarangController::class, 'approvePurchaseRequest'])->name('superadmin.pembelian-barang.approve')->middleware('auth:sanctum');
    // Route::post('/pembelian-barang/{pembelian}/reject', [SuperadminPengajuanBarangController::class, 'rejectPurchaseRequest'])->name('superadmin.pembelian-barang.reject')->middleware('auth:sanctum');
    // Route::get('/pembelian-barang', [SuperadminPengajuanBarangController::class, 'indexPembelianBarang'])->name('superadmin.pembelian-barang.index')->middleware('auth:sanctum');
});

Route::prefix('hrd')->group(function () {
    Route::post('/auth/login', [LoginController::class, 'login']);
    // Route::post('/pelamar/{pelamar}/forward-documents', [HrdPengajuanBarangController::class, 'forwardDocumentsToLogistic'])->middleware('auth:sanctum');
    // Route::get('/pelamar/{pelamar}/upload-payment-proof', [HrdAdministrasiPelamarController::class, 'showUploadPaymentProofForm'])->name('hrd.administrasi-pelamar.show-upload-payment-proof');
    // Route::post('/pelamar/{pelamar}/upload-payment-proof', [HrdAdministrasiPelamarController::class, 'uploadPaymentProof'])->name('hrd.administrasi-pelamar.upload-payment-proof');
    // Route::get('/pelamar/{pelamar}/documents', [HrdAdministrasiPelamarController::class, 'showUploadedDocuments'])->name('hrd.administrasi-pelamar.show-documents')->middleware('auth:sanctum');
});

Route::prefix('keuangan')->group(function () {
    Route::post('/auth/login', [LoginController::class, 'login']);
    // Route::get('/pelamar/{pelamar}/confirm-payment', [KeuanganController::class, 'showPaymentConfirmationForm'])->name('keuangan.confirm_payment');
    // Route::post('/pelamar/{pelamar}/confirm-payment', [KeuanganController::class, 'confirmPayment']);
});

Route::prefix('karyawan')->group(function () {
    Route::post('/auth/login', [LoginController::class, 'login']);
});

Route::prefix('logistik')->group(function () {
    Route::post('/auth/login', [LoginController::class, 'login']);
    // Route::post('/pelamar/{pelamar}/confirm-goods-receipt', [LogisticPengajuanBarangController::class, 'confirmGoodsReceipt'])->middleware('auth:sanctum');
    // Route::post('/pengajuan-barang/{pengajuan}/create-purchase-request', [LogisticPengajuanBarangController::class, 'createPurchaseRequest'])->name('logistik.pengajuan-barang.create-purchase-request')->middleware('auth:sanctum');
});

Route::prefix('pelamar')->group(function () {
    Route::post('/auth/login', [LoginController::class, 'login']);
    Route::get('/filter', [PelamarController::class, 'filter']);
    Route::post('/{pelamar}/validate', [PelamarController::class, 'performValidation']);
    Route::post('/override', [OverrideController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/{pelamar}/generate-interview-invitation', [PelamarController::class, 'generateInterviewInvitation']);
    Route::post('/{pelamar}/approve', [PelamarController::class, 'approve']);
    Route::post('/{pelamar}/send-administration-invitation', [PelamarController::class, 'sendAdministrationInvitation'])->middleware('auth:sanctum');
    Route::get('/{pelamar}/confirm-administration', [PelamarController::class, 'showAdministrationConfirmationForm'])->name('pelamar.confirm_administration');
    Route::post('/{pelamar}/confirm-administration', [PelamarController::class, 'confirmAdministration']);
    Route::get('/{pelamar}/upload-documents', [PelamarController::class, 'showDocumentUploadForm'])->name('pelamar.show-upload-documents')->middleware('auth:sanctum');
    Route::post('/{pelamar}/upload-documents', [PelamarController::class, 'uploadDocument'])->name('pelamar.upload-document')->middleware('auth:sanctum');
});