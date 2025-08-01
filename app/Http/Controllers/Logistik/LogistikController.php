<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanBarang;
use App\Enums\StatusPengajuanEnum;

class LogistikController extends Controller
{
    public function index()
    {
        // Total pengajuan barang
        $totalPengajuan = PengajuanBarang::count();
        
        // Pengajuan pending approval dari logistik
        $pendingLogisticApproval = PengajuanBarang::where('status', StatusPengajuanEnum::Pending)
                                                 ->whereNull('approved_by_logistic')
                                                 ->count();
        
        // Pengajuan yang sudah diapprove logistik
        $approvedByLogistic = PengajuanBarang::whereNotNull('approved_by_logistic')->count();
        
        // Pengajuan yang ditolak
        $rejectedPengajuan = PengajuanBarang::where('status', StatusPengajuanEnum::Rejected)->count();
        
        // Pengajuan yang sudah dibeli
        $purchasedPengajuan = PengajuanBarang::where('status', StatusPengajuanEnum::Purchased)->count();
        
        // Pengajuan yang sudah diterima
        $deliveredPengajuan = PengajuanBarang::where('status', StatusPengajuanEnum::Delivered)->count();
        
        return view('logistik.dashboard', compact(
            'totalPengajuan',
            'pendingLogisticApproval',
            'approvedByLogistic',
            'rejectedPengajuan',
            'purchasedPengajuan',
            'deliveredPengajuan'
        ));
    }
}