<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\General\HomeController;

use App\Http\Controllers\HRD\KaryawanController;
use App\Http\Controllers\HRD\CutiController;
use App\Http\Controllers\HRD\HrdPengajuanBarangController;
use App\Http\Controllers\HRD\FormController;
use App\Http\Controllers\HRD\MutasiController;
use App\Http\Controllers\HRD\ResignController;
use App\Http\Controllers\HRD\SuratPeringatanController;
use App\Http\Controllers\HRD\InterviewAttendanceController;
use App\Http\Controllers\Keuangan\KeuanganController;
use App\Http\Controllers\Keuangan\PembayaranController;
use App\Http\Controllers\Keuangan\GajiController;
use App\Http\Controllers\Logistik\BarangController;
use App\Http\Controllers\Logistik\StockController;
use App\Http\Controllers\Logistik\DistribusiController;
use App\Http\Controllers\Pelamar\PelamarController;
use App\Http\Controllers\Karyawan\KPIController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Karyawan\LapDokumenController;
use App\Http\Controllers\Karyawan\PembinaanController;
use App\Http\Controllers\Keuangan\RekeningKaryawanController;
use App\Http\Controllers\Keuangan\HutangKaryawanController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Enums\RoleEnum;
use App\Http\Controllers\HRD\PelamarController;
use App\Http\Controllers\SuperAdmin\PembelianBarangController;
use App\Http\Controllers\SuperAdmin\SuperadminPengajuanBarangController;
use App\Http\Controllers\Logistik\PengajuanBarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    try {
        // Check if settings table exists and is accessible
        if (Schema::hasTable('settings')) {
            $is_form_enabled = Setting::where('key', 'is_form_enabled')->first();
            $is_form_enabled = $is_form_enabled ? ($is_form_enabled->value === 'true') : false;
            $website_footer_description = Setting::where('key', 'website_footer_description')->firstOrNew();
            $website_logo = Setting::where('key', 'website_logo')->firstOrNew();
            $website_made_by_text = Setting::where('key', 'website_made_by_text')->firstOrNew();
        } else {
            // Default values when settings table doesn't exist
            $is_form_enabled = true; // Default to enabled
            $website_footer_description = (object)['value' => 'Default footer description'];
            $website_logo = (object)['value' => 'Default logo'];
            $website_made_by_text = (object)['value' => 'Made with ❤️'];
        }
    } catch (\Exception $e) {
        // Fallback values in case of any database error
        $is_form_enabled = true;
        $website_footer_description = (object)['value' => 'Default footer description'];
        $website_logo = (object)['value' => 'Default logo'];
        $website_made_by_text = (object)['value' => 'Made with ❤️'];
        
        // Log the error for debugging
        \Log::warning('Settings table access failed in welcome route: ' . $e->getMessage());
    }
    
    return view('welcome', compact('is_form_enabled', 'website_footer_description', 'website_logo', 'website_made_by_text'));
});


// Moved these routes to Keuangan group to avoid conflicts

Route::post('/pelamar/store', [App\Http\Controllers\HRD\PelamarController::class, 'store'])->name('pelamar.store');
Route::get('/pelamar/store', function () {
    return redirect('/');
});



// Custom Authentication Routes
Route::name('superadmin.')->prefix('superadmin/auth')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::prefix('hrd/auth')->name('hrd.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::prefix('keuangan/auth')->name('keuangan.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

// Notification Routes (requires authentication for regular users)
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
});

// Notification Routes for Karyawan (separate authentication)
Route::middleware('auth:karyawan')->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
});

// Note: Karyawan authentication routes are handled in the main karyawan routes group below

Route::prefix('logistik/auth')->name('logistik.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});
Route::prefix('pelamar/auth')->name('pelamar.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::get('/pelamar/{pelamar}/confirm-interview', [App\Http\Controllers\HRD\PelamarController::class, 'showConfirmationForm'])->name('pelamar.show-confirm-interview');
Route::post('/pelamar/{pelamar}/confirm-interview', [App\Http\Controllers\HRD\PelamarController::class, 'confirmInterview'])->name('pelamar.confirm-interview');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/home', [HomeController::class, 'index'])->name('home');

// Super Admin Routes
Route::middleware(['auth', 'check.role:' . RoleEnum::SuperAdmin->value])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\SettingController::class, 'showFormSettings'])->name('index');
        Route::get('website', [App\Http\Controllers\SuperAdmin\SettingController::class, 'showWebsiteSettings'])->name('website.index');
        Route::get('validation', [App\Http\Controllers\SuperAdmin\SettingController::class, 'showValidationSettings'])->name('validation.index');
        Route::get('smtp', [App\Http\Controllers\SuperAdmin\SettingController::class, 'showSmtpSettings'])->name('smtp.index');
        Route::put('form', [App\Http\Controllers\SuperAdmin\SettingController::class, 'update'])->name('form.update');
        Route::put('website', [App\Http\Controllers\SuperAdmin\SettingController::class, 'update'])->name('website.update');
        Route::put('validation', [App\Http\Controllers\SuperAdmin\SettingController::class, 'update'])->name('validation.update');
        Route::put('smtp', [App\Http\Controllers\SuperAdmin\SettingController::class, 'update'])->name('smtp.update');
    });

    Route::resource('pembelian-barang', PembelianBarangController::class);

    Route::prefix('pengajuan-barang-approval')->name('pengajuan-barang-approval.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\PengajuanBarangApprovalController::class, 'index'])->name('index');
        Route::get('{pengajuanBarang}', [App\Http\Controllers\SuperAdmin\PengajuanBarangApprovalController::class, 'show'])->name('show');
        Route::post('{pengajuanBarang}/approve', [App\Http\Controllers\SuperAdmin\PengajuanBarangApprovalController::class, 'approve'])->name('approve');
        Route::post('{pengajuanBarang}/reject', [App\Http\Controllers\SuperAdmin\PengajuanBarangApprovalController::class, 'reject'])->name('reject');
    });

    // HRD Pengajuan Barang Routes for SuperAdmin - Final Approval
    Route::prefix('pengajuan-barang-hrd')->name('pengajuan-barang-hrd.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\PengajuanBarangHRDController::class, 'index'])->name('index');
        Route::get('/{pengajuanBarang}', [App\Http\Controllers\SuperAdmin\PengajuanBarangHRDController::class, 'show'])->name('show');
        Route::get('/{pengajuanBarang}/approval/{action}', [App\Http\Controllers\SuperAdmin\PengajuanBarangHRDController::class, 'showApprovalForm'])->name('approval-form');
        Route::post('/{pengajuanBarang}/approve', [App\Http\Controllers\SuperAdmin\PengajuanBarangHRDController::class, 'approve'])->name('approve');
        Route::post('/{pengajuanBarang}/reject', [App\Http\Controllers\SuperAdmin\PengajuanBarangHRDController::class, 'reject'])->name('reject');
        Route::post('/bulk-approve', [App\Http\Controllers\SuperAdmin\PengajuanBarangHRDController::class, 'bulkApprove'])->name('bulk-approve');
        Route::get('/export-report', [App\Http\Controllers\SuperAdmin\PengajuanBarangHRDController::class, 'exportReport'])->name('export-report');
    });

    // Laporan & Analytics Routes for SuperAdmin
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/karyawan', [App\Http\Controllers\SuperAdmin\LaporanController::class, 'karyawan'])->name('karyawan');
        Route::get('/keuangan', [App\Http\Controllers\SuperAdmin\LaporanController::class, 'keuangan'])->name('keuangan');
        Route::get('/logistik', [App\Http\Controllers\SuperAdmin\LaporanController::class, 'logistik'])->name('logistik');
        Route::get('/analytics', [App\Http\Controllers\SuperAdmin\LaporanController::class, 'analytics'])->name('analytics');
        Route::get('/dashboard-data', [App\Http\Controllers\SuperAdmin\LaporanController::class, 'dashboardData'])->name('dashboard-data');
    });
    // Moved to HRD routes to avoid duplication
    Route::get('/interview-attendance', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'index'])->name('interview-attendance.index');
    
    // Interview Attendance Routes for HRD
    Route::prefix('interview-attendance')->name('interview-attendance.')->group(function () {
        Route::get('/', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'store'])->name('store');
        Route::get('/{attendance}', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'show'])->name('show');
        Route::get('/{attendance}/edit', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'edit'])->name('edit');
        Route::put('/{attendance}', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'update'])->name('update');
        Route::delete('/{attendance}', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'destroy'])->name('destroy');
    });

    // Pengajuan Barang Routes for Director
    Route::get('/pengajuan-barang', [App\Http\Controllers\SuperAdmin\DirectorPengajuanBarangController::class, 'index'])->name('pengajuan-barang.index');
    Route::post('/pengajuan-barang/{pengajuan_barang}/approve', [App\Http\Controllers\SuperAdmin\DirectorPengajuanBarangController::class, 'approve'])->name('pengajuan-barang.approve');
    Route::post('/pengajuan-barang/{pengajuan_barang}/reject', [App\Http\Controllers\SuperAdmin\DirectorPengajuanBarangController::class, 'reject'])->name('pengajuan-barang.reject');
    Route::post('/pengajuan-barang/{pengajuan_barang}/postpone', [App\Http\Controllers\SuperAdmin\DirectorPengajuanBarangController::class, 'postpone'])->name('pengajuan-barang.postpone');
});

// HRD Routes
Route::middleware(['auth', 'check.role:' . RoleEnum::HRD->value])->prefix('hrd')->name('hrd.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HRD\HRDDashboardController::class, 'index'])->name('dashboard');

    // Form Templates Management
    Route::get('/forms', [App\Http\Controllers\FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/download/{filename}', [App\Http\Controllers\FormController::class, 'download'])->name('forms.download');

    Route::get('/kpi-penilaian', [App\Http\Controllers\HRD\KpiPenilaianController::class, 'index'])->name('kpi-penilaian.index');

    // Pengajuan Barang Routes for HRD (New Employee Procurement)
    Route::resource('pengajuan-barang', App\Http\Controllers\HRD\PengajuanBarangController::class);
    Route::get('/pengajuan-barang/{pengajuanBarang}/duplicate', [App\Http\Controllers\HRD\PengajuanBarangController::class, 'duplicate'])->name('pengajuan-barang.duplicate');
    Route::post('/pengajuan-barang/{pengajuanBarang}/duplicate', [App\Http\Controllers\HRD\PengajuanBarangController::class, 'storeDuplicate'])->name('pengajuan-barang.store-duplicate');

    Route::resource('karyawans', KaryawanController::class)->names([
        'index' => 'data-karyawan',
        'create' => 'data-karyawan.create',
        'store' => 'data-karyawan.store',
        'show' => 'data-karyawan.show',
        'edit' => 'data-karyawan.edit',
        'update' => 'data-karyawan.update',
        'destroy' => 'data-karyawan.destroy',
    ]);

    Route::resource('cutis', CutiController::class)->names([
        'index' => 'pengajuan-cuti',
        'create' => 'pengajuan-cuti.create',
        'store' => 'pengajuan-cuti.store',
        'show' => 'pengajuan-cuti.show',
        'edit' => 'pengajuan-cuti.edit',
        'update' => 'pengajuan-cuti.update',
        'destroy' => 'pengajuan-cuti.destroy',
    ]);
    Route::post('cutis/{cuti}/approve', [CutiController::class, 'approve'])->name('pengajuan-cuti.approve');
    Route::post('cutis/{cuti}/reject', [CutiController::class, 'reject'])->name('pengajuan-cuti.reject');
    Route::get('cutis/template/download', [CutiController::class, 'downloadTemplate'])->name('pengajuan-cuti.download-template');
    Route::get('cutis/{cuti}/generate-document', [CutiController::class, 'generateDocument'])->name('pengajuan-cuti.generate-document');

    Route::resource('resigns', ResignController::class)->names([
        'index' => 'data-resign',
        'create' => 'data-resign.create',
        'store' => 'data-resign.store',
        'show' => 'data-resign.show',
        'edit' => 'data-resign.edit',
        'update' => 'data-resign.update',
        'destroy' => 'data-resign.destroy',
    ]);
    Route::post('resigns/{resign}/approve', [ResignController::class, 'approve'])->name('data-resign.approve');
    Route::post('resigns/{resign}/reject', [ResignController::class, 'reject'])->name('data-resign.reject');

    Route::resource('surat-peringatans', SuratPeringatanController::class)->names([
        'index' => 'surat-peringatan',
        'create' => 'surat-peringatan.create',
        'store' => 'surat-peringatan.store',
        'show' => 'surat-peringatan.show',
        'edit' => 'surat-peringatan.edit',
        'update' => 'surat-peringatan.update',
        'destroy' => 'surat-peringatan.destroy',
    ]);

    Route::resource('mutasis', MutasiController::class)->names([
        'index' => 'mutasi-karyawan',
        'create' => 'mutasi-karyawan.create',
        'store' => 'mutasi-karyawan.store',
        'show' => 'mutasi-karyawan.show',
        'edit' => 'mutasi-karyawan.edit',
        'update' => 'mutasi-karyawan.update',
        'destroy' => 'mutasi-karyawan.destroy',
    ]);

    Route::resource('pelamars', PelamarController::class)->names([
        'index' => 'administrasi-pelamar',
        'create' => 'administrasi-pelamar.create',
        'store' => 'administrasi-pelamar.store',
        'show' => 'administrasi-pelamar.show',
        'edit' => 'administrasi-pelamar.edit',
        'update' => 'administrasi-pelamar.update',
        'destroy' => 'administrasi-pelamar.destroy',
    ]);
    Route::post('pelamars/{pelamar}/approve', [PelamarController::class, 'approve'])->name('administrasi-pelamar.approve');
    Route::post('pelamars/{pelamar}/reject', [PelamarController::class, 'reject'])->name('administrasi-pelamar.reject');
    Route::get('pelamars/{pelamar}/pat', [PelamarController::class, 'showPatForm'])->name('administrasi-pelamar.show-pat-form');
    Route::post('pelamars/{pelamar}/pat', [PelamarController::class, 'storePatResult'])->name('administrasi-pelamar.store-pat-result');
    Route::get('pelamars/{pelamar}/psikotest', [PelamarController::class, 'showPsikotestForm'])->name('administrasi-pelamar.show-psikotest-form');
    Route::post('pelamars/{pelamar}/psikotest', [PelamarController::class, 'storePsikotestResult'])->name('administrasi-pelamar.store-psikotest-result');
    Route::get('pelamars/{pelamar}/health-test', [PelamarController::class, 'showHealthTestForm'])->name('administrasi-pelamar.show-health-test-form');
    Route::post('pelamars/{pelamar}/health-test', [PelamarController::class, 'storeHealthTestResult'])->name('administrasi-pelamar.store-health-test-result');
    Route::get('pelamars/{pelamar}/interview', [PelamarController::class, 'showInterviewForm'])->name('administrasi-pelamar.show-interview-form');
    Route::post('pelamars/{pelamar}/interview', [PelamarController::class, 'storeInterviewResult'])->name('administrasi-pelamar.store-interview-result');
    Route::get('pelamars/{pelamar}/final-decision', [PelamarController::class, 'showFinalDecisionForm'])->name('administrasi-pelamar.show-final-decision-form');
    Route::post('pelamars/{pelamar}/final-decision', [PelamarController::class, 'storeFinalDecision'])->name('administrasi-pelamar.store-final-decision');
    
    // PKWT Contract Routes
    Route::get('pelamars/{pelamar}/pkwt', [PelamarController::class, 'showPkwtForm'])->name('administrasi-pelamar.show-pkwt-form');
    Route::post('pelamars/{pelamar}/pkwt', [PelamarController::class, 'storePkwtData'])->name('administrasi-pelamar.store-pkwt-data');
    
    // BPJS Routes
    Route::get('pelamars/{pelamar}/bpjs', [PelamarController::class, 'showBpjsForm'])->name('administrasi-pelamar.show-bpjs-form');
    Route::post('pelamars/{pelamar}/bpjs', [PelamarController::class, 'storeBpjsData'])->name('administrasi-pelamar.store-bpjs-data');
    
    // SPT Routes
    Route::get('pelamars/{pelamar}/spt', [PelamarController::class, 'showSptForm'])->name('administrasi-pelamar.show-spt-form');
    Route::post('pelamars/{pelamar}/spt', [PelamarController::class, 'storeSptData'])->name('administrasi-pelamar.store-spt-data');
    
    // Document Receipt Routes
    Route::get('pelamars/{pelamar}/document-receipt', [PelamarController::class, 'showDocumentReceiptForm'])->name('administrasi-pelamar.show-document-receipt-form');
    Route::post('pelamars/{pelamar}/document-receipt', [PelamarController::class, 'storeDocumentReceipt'])->name('administrasi-pelamar.store-document-receipt');
    
    // Statement Routes
    Route::get('pelamars/{pelamar}/statement', [PelamarController::class, 'showStatementForm'])->name('administrasi-pelamar.show-statement-form');
    Route::post('pelamars/{pelamar}/statement', [PelamarController::class, 'storeStatementData'])->name('administrasi-pelamar.store-statement-data');
    
    // Banking Routes
    Route::get('pelamars/{pelamar}/banking', [PelamarController::class, 'showBankingForm'])->name('administrasi-pelamar.show-banking-form');
    Route::post('pelamars/{pelamar}/banking', [App\Http\Controllers\HRD\PelamarController::class, 'storeBankingData'])->name('administrasi-pelamar.store-banking-data');

    // Laporan Routes for HRD
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [App\Http\Controllers\HRD\LaporanController::class, 'index'])->name('index');
        Route::get('/karyawan', [App\Http\Controllers\HRD\LaporanController::class, 'karyawan'])->name('karyawan');
        Route::get('/cuti', [App\Http\Controllers\HRD\LaporanController::class, 'cuti'])->name('cuti');
        Route::get('/mutasi', [App\Http\Controllers\HRD\LaporanController::class, 'mutasi'])->name('mutasi');
        Route::get('/resign', [App\Http\Controllers\HRD\LaporanController::class, 'resign'])->name('resign');
        Route::get('/pelamar', [App\Http\Controllers\HRD\LaporanController::class, 'pelamar'])->name('pelamar');
        Route::get('/kpi', [App\Http\Controllers\HRD\LaporanController::class, 'kpi'])->name('kpi');
        Route::get('/absensi', [App\Http\Controllers\HRD\LaporanController::class, 'absensi'])->name('absensi');
    });
});

// Keuangan Routes
Route::middleware(['auth', 'check.role:' . RoleEnum::Keuangan->value])->prefix('keuangan')->name('keuangan.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Keuangan\KeuanganController::class, 'index'])->name('dashboard');
    Route::resource('hutang-karyawans', HutangKaryawanController::class);
    Route::resource('rekening-karyawans', RekeningKaryawanController::class);
    Route::get('/penalti-sp', [App\Http\Controllers\Keuangan\PenaltiSPController::class, 'index'])->name('penalti-sp.index');
    Route::get('/penalti-sp/{penaltiSP}', [App\Http\Controllers\Keuangan\PenaltiSPController::class, 'show'])->name('penalti-sp.show');
    Route::resource('surat-peringatan', SuratPeringatanController::class)->only(['show', 'edit', 'update', 'destroy']);
    Route::get('/surat-peringatan/create', [SuratPeringatanController::class, 'create'])->name('surat-peringatan.create');
    Route::post('/surat-peringatan', [SuratPeringatanController::class, 'store'])->name('surat-peringatan.store');

    // Pembayaran Routes for Keuangan
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [App\Http\Controllers\Keuangan\PembayaranController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Keuangan\PembayaranController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Keuangan\PembayaranController::class, 'store'])->name('store');
        Route::get('/{pembayaran}', [App\Http\Controllers\Keuangan\PembayaranController::class, 'show'])->name('show');
        Route::get('/{pembayaran}/edit', [App\Http\Controllers\Keuangan\PembayaranController::class, 'edit'])->name('edit');
        Route::put('/{pembayaran}', [App\Http\Controllers\Keuangan\PembayaranController::class, 'update'])->name('update');
        Route::delete('/{pembayaran}', [App\Http\Controllers\Keuangan\PembayaranController::class, 'destroy'])->name('destroy');
    });

    // Gaji Routes for Keuangan
    Route::prefix('gaji')->name('gaji.')->group(function () {
        Route::get('/', [App\Http\Controllers\Keuangan\GajiController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Keuangan\GajiController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Keuangan\GajiController::class, 'store'])->name('store');
        Route::get('/{gaji}', [App\Http\Controllers\Keuangan\GajiController::class, 'show'])->name('show');
        Route::get('/{gaji}/edit', [App\Http\Controllers\Keuangan\GajiController::class, 'edit'])->name('edit');
        Route::put('/{gaji}', [App\Http\Controllers\Keuangan\GajiController::class, 'update'])->name('update');
        Route::delete('/{gaji}', [App\Http\Controllers\Keuangan\GajiController::class, 'destroy'])->name('destroy');
        Route::post('/{gaji}/process', [App\Http\Controllers\Keuangan\GajiController::class, 'process'])->name('process');
        Route::get('/slip/{gaji}', [App\Http\Controllers\Keuangan\GajiController::class, 'generateSlip'])->name('slip');
    });

    // Laporan Routes for Keuangan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/hutang', [App\Http\Controllers\Keuangan\LaporanController::class, 'hutang'])->name('hutang');
        Route::get('/gaji', [App\Http\Controllers\Keuangan\LaporanController::class, 'gaji'])->name('gaji');
        Route::get('/cash-flow', [App\Http\Controllers\Keuangan\LaporanController::class, 'cashFlow'])->name('cash-flow');
        Route::get('/penalti', [App\Http\Controllers\Keuangan\LaporanController::class, 'penalti'])->name('penalti');
        Route::get('/rekening', [App\Http\Controllers\Keuangan\LaporanController::class, 'rekening'])->name('rekening');
        Route::get('/pembayaran', [App\Http\Controllers\Keuangan\LaporanController::class, 'pembayaran'])->name('pembayaran');
    });
});

// Karyawan Authentication Routes
Route::prefix('karyawan')->name('karyawan.')->group(function () {
    // Guest routes (for login)
    Route::middleware('guest:karyawan')->group(function () {
        Route::get('/login', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'login'])->name('authenticate');
    });
    
    Route::middleware('auth:karyawan')->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Karyawan\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/widget-data', [App\Http\Controllers\Karyawan\DashboardController::class, 'widgetData'])->name('dashboard.widget-data');
        
        // Authentication & Profile
        Route::post('/logout', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'logout'])->name('logout');
        Route::get('/profile', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'showProfile'])->name('profile.show');
        Route::put('/profile', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'updateProfile'])->name('profile.update');
        Route::get('/change-password', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'showChangePasswordForm'])->name('password.change');
        Route::put('/change-password', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'changePassword'])->name('password.update');
        
        // Absensi Management
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/', [App\Http\Controllers\Karyawan\AbsensiController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Karyawan\AbsensiController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Karyawan\AbsensiController::class, 'store'])->name('store');
            Route::get('/{absensi}', [App\Http\Controllers\Karyawan\AbsensiController::class, 'show'])->name('show');
            Route::get('/{absensi}/edit', [App\Http\Controllers\Karyawan\AbsensiController::class, 'edit'])->name('edit');
            Route::put('/{absensi}', [App\Http\Controllers\Karyawan\AbsensiController::class, 'update'])->name('update');
            Route::post('/check-in', [App\Http\Controllers\Karyawan\AbsensiController::class, 'checkIn'])->name('check-in');
            Route::post('/check-out', [App\Http\Controllers\Karyawan\AbsensiController::class, 'checkOut'])->name('check-out');
            Route::get('/statistics', [App\Http\Controllers\Karyawan\AbsensiController::class, 'statistics'])->name('statistics');
        });
        
        // KPI Management
        Route::prefix('kpi')->name('kpi.')->group(function () {
            Route::get('/', [App\Http\Controllers\Karyawan\KPIController::class, 'index'])->name('index');
            Route::get('/{kpi}', [App\Http\Controllers\Karyawan\KPIController::class, 'show'])->name('show');
            Route::get('/statistics', [App\Http\Controllers\Karyawan\KPIController::class, 'statistics'])->name('statistics');
            Route::get('/history', [App\Http\Controllers\Karyawan\KPIController::class, 'history'])->name('history');
            Route::get('/current-summary', [App\Http\Controllers\Karyawan\KPIController::class, 'currentSummary'])->name('current-summary');
            Route::get('/ranking', [App\Http\Controllers\Karyawan\KPIController::class, 'ranking'])->name('ranking');
            Route::get('/suggestions', [App\Http\Controllers\Karyawan\KPIController::class, 'suggestions'])->name('suggestions');
        });
        
        // Cuti Management
        Route::resource('cuti', App\Http\Controllers\Karyawan\CutiController::class)->except(['destroy']);
        Route::patch('cuti/{cuti}/cancel', [App\Http\Controllers\Karyawan\CutiController::class, 'cancel'])->name('cuti.cancel');
        
        // Pengajuan Barang
        Route::resource('pengajuan-barang', App\Http\Controllers\Karyawan\PengajuanBarangController::class)->except(['destroy']);
        Route::patch('pengajuan-barang/{pengajuanBarang}/cancel', [App\Http\Controllers\Karyawan\PengajuanBarangController::class, 'cancel'])->name('pengajuan-barang.cancel');
        Route::patch('pengajuan-barang/{pengajuanBarang}/confirm-receipt', [App\Http\Controllers\Karyawan\PengajuanBarangController::class, 'confirmReceipt'])->name('pengajuan-barang.confirm-receipt');
        
        // Dokumen Management
        Route::resource('dokumen', App\Http\Controllers\Karyawan\LapDokumenController::class)->names([
            'index' => 'dokumen.index',
            'create' => 'dokumen.create',
            'store' => 'dokumen.store',
            'show' => 'dokumen.show',
            'edit' => 'dokumen.edit',
            'update' => 'dokumen.update',
            'destroy' => 'dokumen.destroy',
        ]);
        
        // Pembinaan Management
        Route::resource('pembinaans', App\Http\Controllers\Karyawan\PembinaanController::class)->names([
            'index' => 'pembinaans.index',
            'create' => 'pembinaans.create',
            'store' => 'pembinaans.store',
            'show' => 'pembinaans.show',
            'edit' => 'pembinaans.edit',
            'update' => 'pembinaans.update',
            'destroy' => 'pembinaans.destroy',
        ]);
    });
});

// Logistik Routes
Route::middleware(['auth', 'check.role:' . RoleEnum::Logistik->value])->prefix('logistik')->name('logistik.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Logistik\LogistikController::class, 'index'])->name('dashboard');
    
    // Pengajuan Barang Routes for Logistic (existing karyawan requests)
    Route::resource('pengajuan-barang', App\Http\Controllers\Logistik\PengajuanBarangController::class);
    
    // HRD Pengajuan Barang Routes for Logistic (new employee procurement)
    Route::prefix('pengajuan-barang-hrd')->name('pengajuan-barang-hrd.')->group(function () {
        Route::get('/', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'index'])->name('index');
        Route::get('/{pengajuanBarang}', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'show'])->name('show');
        Route::get('/{pengajuanBarang}/approval/{action}', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'showApprovalForm'])->name('approval-form');
        Route::post('/{pengajuanBarang}/approve', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'approve'])->name('approve');
        Route::post('/{pengajuanBarang}/reject', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'reject'])->name('reject');
        Route::get('/{pengajuanBarang}/complete-form', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'showCompletionForm'])->name('completion-form');
        Route::post('/{pengajuanBarang}/complete', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'complete'])->name('complete');
        Route::post('/bulk-approve', [App\Http\Controllers\Logistik\PengajuanBarangHRDController::class, 'bulkApprove'])->name('bulk-approve');
    });
    
    // Pembelian Management
    Route::resource('pembelian', App\Http\Controllers\Logistik\PembelianController::class);
    Route::post('/pembelian/{pembelian}/process', [App\Http\Controllers\Logistik\PembelianController::class, 'process'])->name('pembelian.process');
    Route::post('/pembelian/{pembelian}/complete', [App\Http\Controllers\Logistik\PembelianController::class, 'complete'])->name('pembelian.complete');
    
    // Vendor Management
    Route::resource('vendor', App\Http\Controllers\Logistik\VendorController::class);
    Route::post('/vendor/{vendor}/update-status', [App\Http\Controllers\Logistik\VendorController::class, 'updateStatus'])->name('vendor.update-status');
    Route::post('/vendor/{vendor}/update-rating', [App\Http\Controllers\Logistik\VendorController::class, 'updateRating'])->name('vendor.update-rating');
    Route::post('/vendor/{id}/restore', [App\Http\Controllers\Logistik\VendorController::class, 'restore'])->name('vendor.restore');
    Route::delete('/vendor/{id}/force-delete', [App\Http\Controllers\Logistik\VendorController::class, 'forceDelete'])->name('vendor.force-delete');

    // Barang/Inventory Routes for Logistik
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('/', [App\Http\Controllers\Logistik\BarangController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Logistik\BarangController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Logistik\BarangController::class, 'store'])->name('store');
        Route::get('/{barang}', [App\Http\Controllers\Logistik\BarangController::class, 'show'])->name('show');
        Route::get('/{barang}/edit', [App\Http\Controllers\Logistik\BarangController::class, 'edit'])->name('edit');
        Route::put('/{barang}', [App\Http\Controllers\Logistik\BarangController::class, 'update'])->name('update');
        Route::delete('/{barang}', [App\Http\Controllers\Logistik\BarangController::class, 'destroy'])->name('destroy');
    });

    // Stock Management Routes for Logistik
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', [App\Http\Controllers\Logistik\StockController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Logistik\StockController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Logistik\StockController::class, 'store'])->name('store');
        Route::get('/{stock}', [App\Http\Controllers\Logistik\StockController::class, 'show'])->name('show');
        Route::get('/{stock}/edit', [App\Http\Controllers\Logistik\StockController::class, 'edit'])->name('edit');
        Route::put('/{stock}', [App\Http\Controllers\Logistik\StockController::class, 'update'])->name('update');
        Route::delete('/{stock}', [App\Http\Controllers\Logistik\StockController::class, 'destroy'])->name('destroy');
        Route::post('/{stock}/adjust', [App\Http\Controllers\Logistik\StockController::class, 'adjust'])->name('adjust');
        Route::get('/movements', [App\Http\Controllers\Logistik\StockController::class, 'movements'])->name('movements');
    });

    // Distribusi Routes for Logistik
    Route::prefix('distribusi')->name('distribusi.')->group(function () {
        Route::get('/', [App\Http\Controllers\Logistik\DistribusiController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Logistik\DistribusiController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Logistik\DistribusiController::class, 'store'])->name('store');
        Route::get('/{distribusi}', [App\Http\Controllers\Logistik\DistribusiController::class, 'show'])->name('show');
        Route::get('/{distribusi}/edit', [App\Http\Controllers\Logistik\DistribusiController::class, 'edit'])->name('edit');
        Route::put('/{distribusi}', [App\Http\Controllers\Logistik\DistribusiController::class, 'update'])->name('update');
        Route::delete('/{distribusi}', [App\Http\Controllers\Logistik\DistribusiController::class, 'destroy'])->name('destroy');
        Route::post('/{distribusi}/confirm', [App\Http\Controllers\Logistik\DistribusiController::class, 'confirm'])->name('confirm');
    });

    // Laporan Routes for Logistik
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/pembelian', [App\Http\Controllers\Logistik\LaporanController::class, 'pembelian'])->name('pembelian');
        Route::get('/stock', [App\Http\Controllers\Logistik\LaporanController::class, 'stock'])->name('stock');
        Route::get('/distribusi', [App\Http\Controllers\Logistik\LaporanController::class, 'distribusi'])->name('distribusi');
        Route::get('/vendor', [App\Http\Controllers\Logistik\LaporanController::class, 'vendor'])->name('vendor');
        Route::get('/pengajuan-barang', [App\Http\Controllers\Logistik\LaporanController::class, 'pengajuanBarang'])->name('pengajuan-barang');
        Route::get('/performance', [App\Http\Controllers\Logistik\LaporanController::class, 'performance'])->name('performance');
    });
});

// Pelamar Routes
Route::middleware(['auth', 'check.role:' . RoleEnum::Pelamar->value . ',' . RoleEnum::SuperAdmin->value])->prefix('pelamar')->name('pelamar.')->group(function () {
    Route::get('/dashboard/{pelamar?}', [App\Http\Controllers\Pelamar\PelamarDashboardController::class, 'index'])->name('dashboard');
    Route::post('/update-attendance/{pelamar}', [App\Http\Controllers\Pelamar\PelamarDashboardController::class, 'updateAttendance'])->name('update-attendance');
    
    // Individual pelamar management (for pelamar role users)
    Route::get('/edit/{pelamar}', [App\Http\Controllers\Pelamar\PelamarController::class, 'edit'])->name('edit');
    Route::put('/update/{pelamar}', [App\Http\Controllers\Pelamar\PelamarController::class, 'update'])->name('update');
    Route::get('/upload-documents/{pelamar}', [App\Http\Controllers\Pelamar\PelamarController::class, 'showUploadForm'])->name('upload-documents');
    Route::post('/upload-documents/{pelamar}', [App\Http\Controllers\Pelamar\PelamarController::class, 'uploadDocuments'])->name('store-documents');
});