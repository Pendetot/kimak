<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ResignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resigns = \App\Models\Resign::with('karyawan')->get();
        return view('hrd.resigns.index', compact('resigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrd.resigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:users,id',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_efektif' => 'required|date|after_or_equal:tanggal_pengajuan',
            'alasan' => 'required|string',
            'status_resign' => 'required|string',
        ]);

        \App\Models\Resign::create($request->all());

        return redirect()->route('hrd.data-resign')->with('success', 'Pengajuan resign berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Resign $resign)
    {
        $resign->load('karyawan'); // Memuat relasi karyawan

        // Hitung lama bekerja dalam tahun, bulan, dan hari
        $lamaBekerja = null;
        $tahunBekerja = 0;
        $bulanBekerja = 0;
        $hariBekerja = 0;

        if ($resign->karyawan && $resign->karyawan->created_at !== null) {
            $tanggalBergabung = $resign->karyawan->created_at ? Carbon::parse($resign->karyawan->created_at) : Carbon::now();
            $tanggalResign = Carbon::parse($resign->tanggal_efektif);
            $interval = $tanggalBergabung->diff($tanggalResign);

            $tahunBekerja = $interval->y;
            $bulanBekerja = $interval->m;
            $hariBekerja = $interval->d;
        }

        return view('hrd.resigns.show', compact('resign', 'tahunBekerja', 'bulanBekerja', 'hariBekerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Resign $resign)
    {
        return view('hrd.resigns.edit', compact('resign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Resign $resign)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:users,id',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_efektif' => 'required|date|after_or_equal:tanggal_pengajuan',
            'alasan' => 'required|string',
            'status_resign' => 'required|string',
        ]);

        $resign->update($request->all());

        return redirect()->route('hrd.data-resign')->with('success', 'Pengajuan resign berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Resign $resign)
    {
        $resign->delete();
        return redirect()->route('hrd.data-resign')->with('success', 'Pengajuan resign berhasil dihapus!');
    }

    public function approve(\App\Models\Resign $resign)
    {
        $resign->update(['status' => 'disetujui']);
        return redirect()->route('hrd.data-resign')->with('success', 'Pengajuan resign berhasil disetujui!');
    }

    public function reject(\App\Models\Resign $resign)
    {
        $resign->update(['status' => 'ditolak']);
        return redirect()->route('hrd.data-resign')->with('success', 'Pengajuan resign berhasil ditolak!');
    }
}
