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
    // Authentication
    Route::post('/auth/login', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'apiLogin']);
    
    Route::middleware('auth:sanctum')->group(function () {
        // Auth routes
        Route::post('/auth/logout', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'apiLogout']);
        Route::get('/auth/me', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'me']);
        Route::put('/auth/change-password', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'apiChangePassword']);
        Route::put('/auth/profile', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'apiUpdateProfile']);
        
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Karyawan\DashboardController::class, 'apiDashboard']);
        Route::get('/dashboard/widget-data', [App\Http\Controllers\Karyawan\DashboardController::class, 'widgetData']);
        
        // Absensi
        Route::prefix('absensi')->group(function () {
            Route::get('/', [App\Http\Controllers\Karyawan\AbsensiController::class, 'index']);
            Route::post('/', [App\Http\Controllers\Karyawan\AbsensiController::class, 'store']);
            Route::get('/statistics', [App\Http\Controllers\Karyawan\AbsensiController::class, 'statistics']);
            Route::post('/check-in', [App\Http\Controllers\Karyawan\AbsensiController::class, 'checkIn']);
            Route::post('/check-out', [App\Http\Controllers\Karyawan\AbsensiController::class, 'checkOut']);
            Route::get('/{absensi}', [App\Http\Controllers\Karyawan\AbsensiController::class, 'show']);
            Route::put('/{absensi}', [App\Http\Controllers\Karyawan\AbsensiController::class, 'update']);
        });
        
        // KPI
        Route::prefix('kpi')->group(function () {
            Route::get('/', [App\Http\Controllers\Karyawan\KPIController::class, 'index']);
            Route::get('/statistics', [App\Http\Controllers\Karyawan\KPIController::class, 'statistics']);
            Route::get('/history', [App\Http\Controllers\Karyawan\KPIController::class, 'history']);
            Route::get('/current-summary', [App\Http\Controllers\Karyawan\KPIController::class, 'currentSummary']);
            Route::get('/ranking', [App\Http\Controllers\Karyawan\KPIController::class, 'ranking']);
            Route::get('/suggestions', [App\Http\Controllers\Karyawan\KPIController::class, 'suggestions']);
            Route::get('/{kpi}', [App\Http\Controllers\Karyawan\KPIController::class, 'show']);
        });
    });
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