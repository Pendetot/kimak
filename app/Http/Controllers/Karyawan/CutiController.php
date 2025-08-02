<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cuti::where('karyawan_id', Auth::guard('karyawan')->id());

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->whereYear('tanggal_mulai', $request->year);
        }

        $cutis = $query->latest()->paginate(10);

        // Statistics
        $statistics = [
            'total' => Cuti::where('karyawan_id', Auth::guard('karyawan')->id())->count(),
            'disetujui' => Cuti::where('karyawan_id', Auth::guard('karyawan')->id())
                              ->where('status', 'disetujui')->count(),
            'pending' => Cuti::where('karyawan_id', Auth::guard('karyawan')->id())
                             ->where('status', 'pending')->count(),
            'ditolak' => Cuti::where('karyawan_id', Auth::guard('karyawan')->id())
                             ->where('status', 'ditolak')->count(),
            'sisa_cuti_tahun_ini' => $this->getSisaCutiTahunIni()
        ];

        return view('karyawan.cuti.index', compact('cutis', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sisaCuti = $this->getSisaCutiTahunIni();
        return view('karyawan.cuti.create', compact('sisaCuti'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti' => 'required|in:tahunan,sakit,melahirkan,menikah,ibadah,lainnya',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
            'alamat_selama_cuti' => 'nullable|string|max:255',
            'no_telepon_darurat' => 'nullable|string|max:20',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();
        $data['karyawan_id'] = Auth::guard('karyawan')->id();
        $data['status'] = 'pending';
        $data['tanggal_pengajuan'] = now();

        // Calculate duration
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $data['durasi_hari'] = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Handle file upload
        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')->store('cuti-files', 'public');
        }

        // Check cuti balance for annual leave
        if ($request->jenis_cuti === 'tahunan') {
            $sisaCuti = $this->getSisaCutiTahunIni();
            if ($data['durasi_hari'] > $sisaCuti) {
                return back()->withErrors(['durasi_hari' => 'Sisa cuti tahunan Anda tidak mencukupi.']);
            }
        }

        Cuti::create($data);

        return redirect()->route('karyawan.cuti.index')
                        ->with('success', 'Pengajuan cuti berhasil disubmit. Menunggu persetujuan HRD.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuti $cuti)
    {
        // Ensure karyawan can only view their own cuti
        if ($cuti->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('karyawan.cuti.show', compact('cuti'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuti $cuti)
    {
        // Ensure karyawan can only edit their own cuti
        if ($cuti->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow edit if status is pending
        if ($cuti->status !== 'pending') {
            return redirect()->route('karyawan.cuti.show', $cuti)
                           ->with('error', 'Pengajuan cuti yang sudah diproses tidak dapat diubah.');
        }

        $sisaCuti = $this->getSisaCutiTahunIni();
        return view('karyawan.cuti.edit', compact('cuti', 'sisaCuti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuti $cuti)
    {
        // Ensure karyawan can only edit their own cuti
        if ($cuti->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow edit if status is pending
        if ($cuti->status !== 'pending') {
            return redirect()->route('karyawan.cuti.show', $cuti)
                           ->with('error', 'Pengajuan cuti yang sudah diproses tidak dapat diubah.');
        }

        $request->validate([
            'jenis_cuti' => 'required|in:tahunan,sakit,melahirkan,menikah,ibadah,lainnya',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
            'alamat_selama_cuti' => 'nullable|string|max:255',
            'no_telepon_darurat' => 'nullable|string|max:20',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        // Calculate duration
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $data['durasi_hari'] = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        // Handle file upload
        if ($request->hasFile('file_pendukung')) {
            // Delete old file if exists
            if ($cuti->file_pendukung) {
                \Storage::disk('public')->delete($cuti->file_pendukung);
            }
            $data['file_pendukung'] = $request->file('file_pendukung')->store('cuti-files', 'public');
        }

        // Check cuti balance for annual leave
        if ($request->jenis_cuti === 'tahunan') {
            $sisaCuti = $this->getSisaCutiTahunIni();
            $existingDuration = $cuti->jenis_cuti === 'tahunan' ? $cuti->durasi_hari : 0;
            $availableCuti = $sisaCuti + $existingDuration;
            
            if ($data['durasi_hari'] > $availableCuti) {
                return back()->withErrors(['durasi_hari' => 'Sisa cuti tahunan Anda tidak mencukupi.']);
            }
        }

        $cuti->update($data);

        return redirect()->route('karyawan.cuti.index')
                        ->with('success', 'Pengajuan cuti berhasil diperbarui.');
    }

    /**
     * Get remaining annual leave for current year
     */
    private function getSisaCutiTahunIni()
    {
        $karyawan = Auth::guard('karyawan')->user();
        $currentYear = now()->year;
        
        // Annual leave allocation (default 12 days per year)
        $jatahCutiTahunan = 12;
        
        // Calculate years of service for additional leave
        $tahunKerja = $karyawan->tanggal_masuk->diffInYears(now());
        if ($tahunKerja >= 5) {
            $jatahCutiTahunan += 1; // +1 day after 5 years
        }
        if ($tahunKerja >= 10) {
            $jatahCutiTahunan += 1; // +1 day after 10 years
        }

        // Calculate used annual leave this year
        $cutiTerpakai = Cuti::where('karyawan_id', $karyawan->id)
                           ->where('jenis_cuti', 'tahunan')
                           ->where('status', 'disetujui')
                           ->whereYear('tanggal_mulai', $currentYear)
                           ->sum('durasi_hari');

        return max(0, $jatahCutiTahunan - $cutiTerpakai);
    }

    /**
     * Cancel pending cuti request
     */
    public function cancel(Cuti $cuti)
    {
        // Ensure karyawan can only cancel their own cuti
        if ($cuti->karyawan_id !== Auth::guard('karyawan')->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow cancel if status is pending
        if ($cuti->status !== 'pending') {
            return redirect()->route('karyawan.cuti.show', $cuti)
                           ->with('error', 'Pengajuan cuti yang sudah diproses tidak dapat dibatalkan.');
        }

        $cuti->update(['status' => 'dibatalkan']);

        return redirect()->route('karyawan.cuti.index')
                        ->with('success', 'Pengajuan cuti berhasil dibatalkan.');
    }
}