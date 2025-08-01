<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LapDokumen;
use Illuminate\Http\Request;

class LapDokumenController extends Controller
{
    public function index()
    {
        $lapDokumens = LapDokumen::all();
        return view('karyawan.lap_dokumens.index', compact('lapDokumens'));
    }

    public function create()
    {
        return view('karyawan.lap_dokumens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'nama_dokumen' => 'required|string|max:255',
            'file_path' => 'required|string|max:255',
        ]);

        LapDokumen::create($request->all());

        return redirect()->route('karyawan.lap-dokumens.index')->with('success', 'Laporan dokumen berhasil ditambahkan!');
    }

    public function edit(LapDokumen $lapDokumen)
    {
        return view('karyawan.lap_dokumens.edit', compact('lapDokumen'));
    }

    public function update(Request $request, LapDokumen $lapDokumen)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'nama_dokumen' => 'required|string|max:255',
            'file_path' => 'required|string|max:255',
        ]);

        $lapDokumen->update($request->all());

        return redirect()->route('karyawan.lap-dokumens.index')->with('success', 'Laporan dokumen berhasil diperbarui!');
    }

    public function destroy(LapDokumen $lapDokumen)
    {
        $lapDokumen->delete();
        return redirect()->route('karyawan.lap-dokumens.index')->with('success', 'Laporan dokumen berhasil dihapus!');
    }
}
