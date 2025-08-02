<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Gaji;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class GajiController extends Controller
{
    /**
     * Display a listing of salary records
     */
    public function index(Request $request)
    {
        $query = Gaji::with('karyawan');

        // Apply filters
        if ($request->karyawan_id) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        if ($request->bulan) {
            $query->whereMonth('periode_bulan', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('periode_bulan', $request->tahun);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nik', 'like', "%{$request->search}%")
                  ->orWhere('nip', 'like', "%{$request->search}%");
            });
        }

        $gajis = $query->latest('periode_bulan')->paginate(15);

        // Statistics
        $stats = [
            'total_gaji' => Gaji::sum('total_gaji'),
            'gaji_bulan_ini' => Gaji::whereMonth('periode_bulan', now()->month)
                                   ->whereYear('periode_bulan', now()->year)
                                   ->sum('total_gaji'),
            'karyawan_dibayar' => Gaji::whereMonth('periode_bulan', now()->month)
                                     ->whereYear('periode_bulan', now()->year)
                                     ->where('status', 'dibayar')
                                     ->count(),
            'pending_approval' => Gaji::where('status', 'pending')->count(),
        ];

        $karyawans = Karyawan::where('status_karyawan', 'aktif')
                            ->orderBy('nama_lengkap')
                            ->get();

        $years = Gaji::selectRaw('YEAR(periode_bulan) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');

        return view('keuangan.gaji.index', compact('gajis', 'stats', 'karyawans', 'years'));
    }

    /**
     * Show the form for creating a new salary record
     */
    public function create()
    {
        $karyawans = Karyawan::where('status_karyawan', 'aktif')
                            ->orderBy('nama_lengkap')
                            ->get();

        return view('keuangan.gaji.create', compact('karyawans'));
    }

    /**
     * Store a newly created salary record
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'periode_bulan' => 'required|date',
            'hari_kerja' => 'required|integer|min:1|max:31',
            'hari_hadir' => 'required|integer|min:0|max:31',
            'hari_sakit' => 'nullable|integer|min:0|max:31',
            'hari_izin' => 'nullable|integer|min:0|max:31',
            'hari_alpha' => 'nullable|integer|min:0|max:31',
            'lembur_jam' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string|max:500'
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);
        
        // Check if salary for this period already exists
        $existing = Gaji::where('karyawan_id', $request->karyawan_id)
                        ->whereMonth('periode_bulan', Carbon::parse($request->periode_bulan)->month)
                        ->whereYear('periode_bulan', Carbon::parse($request->periode_bulan)->year)
                        ->first();

        if ($existing) {
            return back()->withInput()
                ->with('error', 'Salary record for this employee and period already exists');
        }

        DB::beginTransaction();
        try {
            // Calculate salary components
            $gajiPokok = $karyawan->gaji_pokok;
            $tunjangan = is_string($karyawan->tunjangan) ? 
                        array_sum(json_decode($karyawan->tunjangan, true) ?? []) : 
                        ($karyawan->tunjangan ?? 0);
            
            // Calculate attendance-based deductions
            $hariKerja = $request->hari_kerja;
            $hariHadir = $request->hari_hadir;
            $potonganAbsen = $hariKerja > 0 ? ($gajiPokok / $hariKerja) * ($hariKerja - $hariHadir) : 0;
            
            // Calculate overtime
            $lemburJam = $request->lembur_jam ?? 0;
            $upahLembur = $lemburJam * ($gajiPokok / (8 * $hariKerja)) * 1.5; // 1.5x normal rate
            
            // Calculate total
            $totalGaji = $gajiPokok + $tunjangan + $upahLembur + ($request->bonus ?? 0) 
                        - $potonganAbsen - ($request->potongan ?? 0);

            $gaji = Gaji::create([
                'karyawan_id' => $request->karyawan_id,
                'periode_bulan' => $request->periode_bulan,
                'gaji_pokok' => $gajiPokok,
                'tunjangan' => $tunjangan,
                'hari_kerja' => $request->hari_kerja,
                'hari_hadir' => $request->hari_hadir,
                'hari_sakit' => $request->hari_sakit ?? 0,
                'hari_izin' => $request->hari_izin ?? 0,
                'hari_alpha' => $request->hari_alpha ?? 0,
                'potongan_absen' => $potonganAbsen,
                'lembur_jam' => $lemburJam,
                'upah_lembur' => $upahLembur,
                'bonus' => $request->bonus ?? 0,
                'potongan_lain' => $request->potongan ?? 0,
                'total_gaji' => $totalGaji,
                'status' => 'pending',
                'catatan' => $request->catatan,
                'created_by' => Auth::id(),
            ]);

            // Create notification
            Notification::create([
                'user_id' => $karyawan->created_by ?? Auth::id(),
                'type' => 'salary_calculated',
                'title' => 'Salary Calculated',
                'message' => "Salary for " . Carbon::parse($request->periode_bulan)->format('F Y') . " has been calculated for " . $karyawan->nama_lengkap,
                'data' => json_encode([
                    'gaji_id' => $gaji->id,
                    'karyawan_id' => $request->karyawan_id,
                    'periode' => $request->periode_bulan,
                    'total' => $totalGaji
                ]),
                'action_url' => route('keuangan.gaji.show', $gaji->id),
                'icon' => 'ph-money',
                'color' => 'text-info'
            ]);

            DB::commit();
            return redirect()->route('keuangan.gaji.index')
                ->with('success', 'Salary record created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create salary record: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified salary record
     */
    public function show($id)
    {
        $gaji = Gaji::with('karyawan')->findOrFail($id);
        return view('keuangan.gaji.show', compact('gaji'));
    }

    /**
     * Show the form for editing the specified salary record
     */
    public function edit($id)
    {
        $gaji = Gaji::with('karyawan')->findOrFail($id);
        
        if ($gaji->status === 'dibayar') {
            return back()->with('error', 'Cannot edit paid salary records');
        }

        $karyawans = Karyawan::where('status_karyawan', 'aktif')
                            ->orderBy('nama_lengkap')
                            ->get();

        return view('keuangan.gaji.edit', compact('gaji', 'karyawans'));
    }

    /**
     * Update the specified salary record
     */
    public function update(Request $request, $id)
    {
        $gaji = Gaji::findOrFail($id);
        
        if ($gaji->status === 'dibayar') {
            return back()->with('error', 'Cannot edit paid salary records');
        }

        $request->validate([
            'periode_bulan' => 'required|date',
            'hari_kerja' => 'required|integer|min:1|max:31',
            'hari_hadir' => 'required|integer|min:0|max:31',
            'hari_sakit' => 'nullable|integer|min:0|max:31',
            'hari_izin' => 'nullable|integer|min:0|max:31',
            'hari_alpha' => 'nullable|integer|min:0|max:31',
            'lembur_jam' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $karyawan = $gaji->karyawan;
            
            // Recalculate salary components
            $gajiPokok = $karyawan->gaji_pokok;
            $tunjangan = is_string($karyawan->tunjangan) ? 
                        array_sum(json_decode($karyawan->tunjangan, true) ?? []) : 
                        ($karyawan->tunjangan ?? 0);
            
            $hariKerja = $request->hari_kerja;
            $hariHadir = $request->hari_hadir;
            $potonganAbsen = $hariKerja > 0 ? ($gajiPokok / $hariKerja) * ($hariKerja - $hariHadir) : 0;
            
            $lemburJam = $request->lembur_jam ?? 0;
            $upahLembur = $lemburJam * ($gajiPokok / (8 * $hariKerja)) * 1.5;
            
            $totalGaji = $gajiPokok + $tunjangan + $upahLembur + ($request->bonus ?? 0) 
                        - $potonganAbsen - ($request->potongan ?? 0);

            $gaji->update([
                'periode_bulan' => $request->periode_bulan,
                'hari_kerja' => $request->hari_kerja,
                'hari_hadir' => $request->hari_hadir,
                'hari_sakit' => $request->hari_sakit ?? 0,
                'hari_izin' => $request->hari_izin ?? 0,
                'hari_alpha' => $request->hari_alpha ?? 0,
                'potongan_absen' => $potonganAbsen,
                'lembur_jam' => $lemburJam,
                'upah_lembur' => $upahLembur,
                'bonus' => $request->bonus ?? 0,
                'potongan_lain' => $request->potongan ?? 0,
                'total_gaji' => $totalGaji,
                'catatan' => $request->catatan,
                'updated_by' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('keuangan.gaji.index')
                ->with('success', 'Salary record updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update salary record: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified salary record
     */
    public function destroy($id)
    {
        $gaji = Gaji::findOrFail($id);
        
        if ($gaji->status === 'dibayar') {
            return back()->with('error', 'Cannot delete paid salary records');
        }

        $gaji->delete();
        
        return back()->with('success', 'Salary record deleted successfully');
    }

    /**
     * Process salary payment
     */
    public function process(Request $request, $id)
    {
        $gaji = Gaji::with('karyawan')->findOrFail($id);
        
        if ($gaji->status === 'dibayar') {
            return back()->with('error', 'Salary already processed');
        }

        $request->validate([
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|in:cash,transfer,check',
            'nomor_referensi' => 'nullable|string|max:100',
            'catatan_pembayaran' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $gaji->update([
                'status' => 'dibayar',
                'tanggal_bayar' => $request->tanggal_bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'nomor_referensi' => $request->nomor_referensi,
                'catatan_pembayaran' => $request->catatan_pembayaran,
                'processed_by' => Auth::id(),
            ]);

            // Create notification
            Notification::create([
                'user_id' => $gaji->karyawan->created_by ?? Auth::id(),
                'type' => 'salary_paid',
                'title' => 'Salary Paid',
                'message' => "Salary of Rp " . number_format($gaji->total_gaji) . " has been paid to " . $gaji->karyawan->nama_lengkap,
                'data' => json_encode([
                    'gaji_id' => $gaji->id,
                    'karyawan_id' => $gaji->karyawan_id,
                    'amount' => $gaji->total_gaji,
                    'method' => $request->metode_pembayaran
                ]),
                'action_url' => route('keuangan.gaji.show', $gaji->id),
                'icon' => 'ph-check-circle',
                'color' => 'text-success'
            ]);

            DB::commit();
            return back()->with('success', 'Salary payment processed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    /**
     * Generate salary slip PDF
     */
    public function generateSlip($id)
    {
        $gaji = Gaji::with('karyawan')->findOrFail($id);
        
        $pdf = PDF::loadView('keuangan.gaji.slip', compact('gaji'));
        
        $filename = 'slip_gaji_' . $gaji->karyawan->nik . '_' . 
                   Carbon::parse($gaji->periode_bulan)->format('Y_m') . '.pdf';
        
        return $pdf->download($filename);
    }
}