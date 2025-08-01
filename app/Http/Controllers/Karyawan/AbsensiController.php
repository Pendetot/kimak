<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::all();
        return view('karyawan.absensis.index', compact('absensis'));
    }

    public function create()
    {
        return view('karyawan.absensis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        Absensi::create($request->all());

        return redirect()->route('karyawan.absensis.index')->with('success', 'Absensi berhasil ditambahkan!');
    }

    public function edit(Absensi $absensi)
    {
        return view('karyawan.absensis.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update($request->all());

        return redirect()->route('karyawan.absensis.index')->with('success', 'Absensi berhasil diperbarui!');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('karyawan.absensis.index')->with('success', 'Absensi berhasil dihapus!');
    }
}
