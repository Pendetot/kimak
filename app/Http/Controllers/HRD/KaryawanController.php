<?php

namespace App\Http\Controllers\HRD;

use App\Models\Karyawan;
use App\Enums\StatusKaryawanEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusPernikahanEnum;
use App\Enums\JenisKontrakEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // Filter berdasarkan departemen
        if ($request->filled('departemen')) {
            $query->where('departemen', $request->departemen);
        }

        // Filter berdasarkan status
        if ($request->filled('status_karyawan')) {
            $query->where('status_karyawan', $request->status_karyawan);
        }

        // Filter berdasarkan jenis kontrak
        if ($request->filled('jenis_kontrak')) {
            $query->where('jenis_kontrak', $request->jenis_kontrak);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $karyawans = $query->latest()->paginate(15);

        // Get unique departments for filter
        $departments = Karyawan::distinct('departemen')->pluck('departemen')->filter();

        return view('hrd.karyawans.index', compact('karyawans', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrd.karyawans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:karyawans,email',
            'password' => 'required|string|min:8',
            'nik' => 'required|string|max:50|unique:karyawans,nik',
            'nip' => 'nullable|string|max:50|unique:karyawans,nip',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'jabatan' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'tanggal_masuk' => 'required|date',
            'jenis_kontrak' => 'required|in:tetap,kontrak,magang,freelance',
            'tanggal_berakhir_kontrak' => 'nullable|date|after:tanggal_masuk',
            'status_karyawan' => 'required|in:aktif,non_aktif,cuti,resign,terminated',
            'gaji_pokok' => 'nullable|numeric|min:0',
            'status_pernikahan' => 'nullable|in:single,married,divorced,widowed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['created_by'] = auth()->id();

        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('karyawan-photos', 'public');
        }

        Karyawan::create($data);

        return redirect()->route('hrd.karyawans.index')
                        ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        $karyawan->load(['absensi' => function($query) {
            $query->latest()->take(10);
        }, 'kpi' => function($query) {
            $query->latest()->take(5);
        }, 'hutangKaryawan', 'suratPeringatan']);

        return view('hrd.karyawans.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $jabatanList = [
            'Manager' => 'Manager',
            'Supervisor' => 'Supervisor', 
            'Staff' => 'Staff',
            'Operator' => 'Operator',
            'Intern' => 'Intern'
        ];
        
        return view('hrd.karyawans.edit', compact('karyawan', 'jabatanList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'email' => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'nik' => 'required|string|max:50|unique:karyawans,nik,' . $karyawan->id,
            'nip' => 'nullable|string|max:50|unique:karyawans,nip,' . $karyawan->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'jabatan' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'tanggal_masuk' => 'required|date',
            'jenis_kontrak' => 'required|in:tetap,kontrak,magang,freelance',
            'tanggal_berakhir_kontrak' => 'nullable|date|after:tanggal_masuk',
            'status_karyawan' => 'required|in:aktif,non_aktif,cuti,resign,terminated',
            'gaji_pokok' => 'nullable|numeric|min:0',
            'status_pernikahan' => 'nullable|in:single,married,divorced,widowed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except(['password']);
        $data['updated_by'] = auth()->id();

        // Handle password update
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            // Delete old photo
            if ($karyawan->foto_profil) {
                Storage::disk('public')->delete($karyawan->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('karyawan-photos', 'public');
        }

        $karyawan->update($data);

        return redirect()->route('hrd.karyawans.index')
                        ->with('success', 'Data karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        // Soft delete
        $karyawan->delete();
        
        return redirect()->route('hrd.karyawans.index')
                        ->with('success', 'Karyawan berhasil dihapus!');
    }

    /**
     * Restore soft deleted karyawan
     */
    public function restore($id)
    {
        $karyawan = Karyawan::withTrashed()->findOrFail($id);
        $karyawan->restore();

        return redirect()->route('hrd.karyawans.index')
                        ->with('success', 'Karyawan berhasil dipulihkan!');
    }

    /**
     * Force delete karyawan
     */
    public function forceDelete($id)
    {
        $karyawan = Karyawan::withTrashed()->findOrFail($id);
        
        // Delete photo if exists
        if ($karyawan->foto_profil) {
            Storage::disk('public')->delete($karyawan->foto_profil);
        }
        
        $karyawan->forceDelete();

        return redirect()->route('hrd.karyawans.index')
                        ->with('success', 'Karyawan berhasil dihapus permanen!');
    }

    /**
     * Export karyawan data
     */
    public function export()
    {
        // This can be implemented with Excel export
        return response()->json(['message' => 'Export feature will be implemented']);
    }

    /**
     * Get karyawan statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => Karyawan::count(),
            'aktif' => Karyawan::where('status_karyawan', StatusKaryawanEnum::Aktif)->count(),
            'non_aktif' => Karyawan::where('status_karyawan', StatusKaryawanEnum::NonAktif)->count(),
            'kontrak_akan_berakhir' => Karyawan::contractExpiringSoon()->count(),
            'by_department' => Karyawan::select('departemen')
                                    ->selectRaw('count(*) as total')
                                    ->groupBy('departemen')
                                    ->get(),
            'by_contract_type' => Karyawan::select('jenis_kontrak')
                                        ->selectRaw('count(*) as total')
                                        ->groupBy('jenis_kontrak')
                                        ->get()
        ];

        return response()->json($stats);
    }
}
