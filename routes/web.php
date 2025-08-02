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
use App\Http\Controllers\Keuangan\KeuanganController;
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

Route::get('/', function () {
    $is_form_enabled = Setting::where('key', 'is_form_enabled')->first();
    $is_form_enabled = $is_form_enabled ? ($is_form_enabled->value === 'true') : false;
    $website_footer_description = Setting::where('key', 'website_footer_description')->firstOrNew();
    $website_logo = Setting::where('key', 'website_logo')->firstOrNew();
    $website_made_by_text = Setting::where('key', 'website_made_by_text')->firstOrNew();
    return view('welcome', compact('is_form_enabled', 'website_footer_description', 'website_logo', 'website_made_by_text'));
});


    Route::get('/hutang', [App\Http\Controllers\Keuangan\HutangController::class, 'indexHutang'])->name('hutang.index');
    Route::get('/hutang/{hutangKaryawan}', [App\Http\Controllers\Keuangan\HutangController::class, 'showHutang'])->name('hutang.show');

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



Route::prefix('karyawan/auth')->name('karyawan.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

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
    Route::get('/administrasi-pelamar', [App\Http\Controllers\HRD\PelamarController::class, 'index'])->name('administrasi-pelamar.index');
    Route::get('/interview-attendance', [App\Http\Controllers\HRD\InterviewAttendanceController::class, 'index'])->name('interview-attendance.index');

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

    // Pengajuan Barang Routes for HRD - TEMPORARILY DISABLED
        Route::get('/pengajuan-barang/create', [App\Http\Controllers\HRD\HrdPengajuanBarangController::class, 'create'])->name('pengajuan-barang.create');
    Route::post('/pengajuan-barang', [App\Http\Controllers\HRD\HrdPengajuanBarangController::class, 'store'])->name('pengajuan-barang.store');

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
});

// Karyawan Authentication Routes
Route::prefix('karyawan')->name('karyawan.')->group(function () {
    Route::middleware('guest:karyawan')->group(function () {
        Route::get('/login', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Karyawan\Auth\KaryawanAuthController::class, 'login']);
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
        'store' => 'lap-dokumens.store',
        'show' => 'lap-dokumens.show',
        'edit' => 'lap-dokumens.edit',
        'update' => 'lap-dokumens.update',
        'destroy' => 'lap-dokumens.destroy',
    ]);
    Route::resource('pembinaans', App\Http\Controllers\Karyawan\PembinaanController::class)->names([
        'index' => 'pembinaans',
        'create' => 'pembinaans.create',
        'store' => 'pembinaans.store',
        'show' => 'pembinaans.show',
        'edit' => 'pembinaans.edit',
        'update' => 'pembinaans.update',
        'destroy' => 'pembinaans.destroy',
    ]);
});

// Logistik Routes
Route::middleware(['auth', 'check.role:' . RoleEnum::Logistik->value])->prefix('logistik')->name('logistik.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Logistik\LogistikController::class, 'index'])->name('dashboard');
    // Pengajuan Barang Routes for Logistic
    Route::resource('pengajuan-barang', App\Http\Controllers\Logistik\PengajuanBarangController::class);
});

// Pelamar Routes
Route::middleware(['auth', 'check.role:' . RoleEnum::Pelamar->value . ',' . RoleEnum::SuperAdmin->value])->prefix('pelamar')->name('pelamar.')->group(function () {
    Route::get('/dashboard/{pelamar?}', [App\Http\Controllers\Pelamar\PelamarDashboardController::class, 'index'])->name('dashboard');
    Route::post('/update-attendance/{pelamar}', [App\Http\Controllers\Pelamar\PelamarDashboardController::class, 'updateAttendance'])->name('update-attendance');
});