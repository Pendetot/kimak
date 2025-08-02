<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /**
     * Display a listing of absensi for the authenticated karyawan.
     */
    public function index(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $query = $karyawan->absensi()->with('karyawan');
        
        // Filter by month/year if provided
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('tanggal', $request->month)
                  ->whereYear('tanggal', $request->year);
        } else {
            // Default to current month
            $query->whereMonth('tanggal', now()->month)
                  ->whereYear('tanggal', now()->year);
        }
        
        $absensis = $query->orderBy('tanggal', 'desc')->get();
        
        // Statistics
        $stats = [
            'total' => $absensis->count(),
            'hadir' => $absensis->where('status_absensi', 'hadir')->count(),
            'izin' => $absensis->where('status_absensi', 'izin')->count(),
            'sakit' => $absensis->where('status_absensi', 'sakit')->count(),
            'alpha' => $absensis->where('status_absensi', 'alpha')->count(),
        ];
        
        return view('karyawan.absensi.index', compact('absensis', 'stats'));
    }

    /**
     * Show the form for creating a new absensi.
     */
    public function create()
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        // Check if already checked in today
        $todayAbsensi = $karyawan->absensi()->whereDate('tanggal', today())->first();
        
        return view('karyawan.absensi.create', compact('todayAbsensi'));
    }

    /**
     * Store a newly created absensi.
     */
    public function store(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i|after:jam_masuk',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:500',
            'foto_absensi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi_absensi' => 'nullable|string|max:255',
        ]);

        // Check if already has absensi for this date
        $existingAbsensi = $karyawan->absensi()->whereDate('tanggal', $request->tanggal)->first();
        if ($existingAbsensi) {
            return back()->withErrors(['tanggal' => 'Absensi untuk tanggal ini sudah ada.']);
        }

        $data = [
            'karyawan_id' => $karyawan->id,
            'tanggal' => $request->tanggal,
            'status_absensi' => $request->status_absensi,
            'keterangan' => $request->keterangan,
            'lokasi_absensi' => $request->lokasi_absensi,
        ];

        // Add time if provided
        if ($request->jam_masuk) {
            $data['jam_masuk'] = $request->tanggal . ' ' . $request->jam_masuk;
        }
        if ($request->jam_keluar) {
            $data['jam_keluar'] = $request->tanggal . ' ' . $request->jam_keluar;
        }

        // Handle photo upload
        if ($request->hasFile('foto_absensi')) {
            $path = $request->file('foto_absensi')->store('absensi/photos', 'public');
            $data['foto_absensi'] = $path;
        }

        Absensi::create($data);

        return redirect()->route('karyawan.absensi.index')
                        ->with('success', 'Absensi berhasil ditambahkan!');
    }

    /**
     * Display the specified absensi.
     */
    public function show(Absensi $absensi)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        // Ensure karyawan can only view their own absensi
        if ($absensi->karyawan_id !== $karyawan->id) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('karyawan.absensi.show', compact('absensi'));
    }

    /**
     * Show the form for editing absensi.
     */
    public function edit(Absensi $absensi)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        // Ensure karyawan can only edit their own absensi
        if ($absensi->karyawan_id !== $karyawan->id) {
            abort(403, 'Unauthorized access.');
        }
        
        // Check if absensi is still editable (e.g., within 24 hours)
        if ($absensi->tanggal < now()->subDay()) {
            return redirect()->route('karyawan.absensi.index')
                           ->with('error', 'Absensi yang sudah lebih dari 1 hari tidak dapat diedit.');
        }
        
        return view('karyawan.absensi.edit', compact('absensi'));
    }

    /**
     * Update the specified absensi.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        // Ensure karyawan can only update their own absensi
        if ($absensi->karyawan_id !== $karyawan->id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i|after:jam_masuk',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:500',
            'foto_absensi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi_absensi' => 'nullable|string|max:255',
        ]);

        $data = [
            'status_absensi' => $request->status_absensi,
            'keterangan' => $request->keterangan,
            'lokasi_absensi' => $request->lokasi_absensi,
        ];

        // Update time if provided
        if ($request->jam_masuk) {
            $data['jam_masuk'] = $absensi->tanggal->format('Y-m-d') . ' ' . $request->jam_masuk;
        }
        if ($request->jam_keluar) {
            $data['jam_keluar'] = $absensi->tanggal->format('Y-m-d') . ' ' . $request->jam_keluar;
        }

        // Handle photo upload
        if ($request->hasFile('foto_absensi')) {
            // Delete old photo
            if ($absensi->foto_absensi && Storage::exists($absensi->foto_absensi)) {
                Storage::delete($absensi->foto_absensi);
            }
            
            $path = $request->file('foto_absensi')->store('absensi/photos', 'public');
            $data['foto_absensi'] = $path;
        }

        $absensi->update($data);

        return redirect()->route('karyawan.absensi.index')
                        ->with('success', 'Absensi berhasil diperbarui!');
    }

    /**
     * Quick check-in for today.
     */
    public function checkIn(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        // Check if already checked in today
        $todayAbsensi = $karyawan->absensi()->whereDate('tanggal', today())->first();
        if ($todayAbsensi && $todayAbsensi->jam_masuk) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-in hari ini.'
            ], 422);
        }

        $request->validate([
            'foto_absensi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi_absensi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $data = [
            'karyawan_id' => $karyawan->id,
            'tanggal' => today(),
            'jam_masuk' => now(),
            'status_absensi' => 'hadir',
            'lokasi_absensi' => $request->lokasi_absensi,
            'keterangan' => $request->keterangan,
        ];

        // Handle photo upload
        if ($request->hasFile('foto_absensi')) {
            $path = $request->file('foto_absensi')->store('absensi/photos', 'public');
            $data['foto_absensi'] = $path;
        }

        if ($todayAbsensi) {
            $todayAbsensi->update($data);
            $absensi = $todayAbsensi;
        } else {
            $absensi = Absensi::create($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'data' => [
                'jam_masuk' => $absensi->jam_masuk->format('H:i:s'),
                'is_late' => $absensi->isLate(),
            ]
        ]);
    }

    /**
     * Quick check-out for today.
     */
    public function checkOut(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $todayAbsensi = $karyawan->absensi()->whereDate('tanggal', today())->first();
        if (!$todayAbsensi || !$todayAbsensi->jam_masuk) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan check-in hari ini.'
            ], 422);
        }

        if ($todayAbsensi->jam_keluar) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-out hari ini.'
            ], 422);
        }

        $request->validate([
            'keterangan' => 'nullable|string|max:500',
        ]);

        $todayAbsensi->update([
            'jam_keluar' => now(),
            'keterangan' => $request->keterangan ?? $todayAbsensi->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil!',
            'data' => [
                'jam_keluar' => $todayAbsensi->jam_keluar->format('H:i:s'),
                'working_hours' => $todayAbsensi->getWorkingHours(),
            ]
        ]);
    }

    /**
     * Get absensi statistics.
     */
    public function statistics(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        
        $year = $request->get('year', now()->year);
        $month = $request->get('month');
        
        $query = $karyawan->absensi()->whereYear('tanggal', $year);
        
        if ($month) {
            $query->whereMonth('tanggal', $month);
        }
        
        $absensis = $query->get();
        
        $stats = [
            'total_days' => $absensis->count(),
            'hadir' => $absensis->where('status_absensi', 'hadir')->count(),
            'izin' => $absensis->where('status_absensi', 'izin')->count(),
            'sakit' => $absensis->where('status_absensi', 'sakit')->count(),
            'alpha' => $absensis->where('status_absensi', 'alpha')->count(),
            'late_count' => $absensis->filter(fn($a) => $a->isLate())->count(),
            'average_working_hours' => $absensis->filter(fn($a) => $a->getWorkingHours())->avg(fn($a) => $a->getWorkingHours()),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
