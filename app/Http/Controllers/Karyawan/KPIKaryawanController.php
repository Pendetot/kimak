<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\KPI;
use Illuminate\Http\Request;

class KPIKaryawanController extends Controller
{
    public function index()
    {
        $kpis = KPI::all();
        return view('karyawan.kpis.index', compact('kpis'));
    }

    public function create()
    {
        $karyawans = \App\Models\Karyawan::all();
        return view('karyawan.kpis.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'periode' => 'required|string|max:255',
            'nilai_kpi' => 'required|integer|min:0|max:100',
            'evaluasi' => 'required|string',
        ]);

        KPI::create($request->all());

        return redirect()->route('karyawan.kpis.index')->with('success', 'KPI berhasil ditambahkan!');
    }

    public function edit(KPI $kpi)
    {
        $karyawans = \App\Models\Karyawan::all();
        return view('karyawan.kpis.edit', compact('kpi', 'karyawans'));
    }

    public function update(Request $request, KPI $kpi)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'periode' => 'required|string|max:255',
            'nilai_kpi' => 'required|integer|min:0|max:100',
            'evaluasi' => 'required|string',
        ]);

        $kpi->update($request->all());

        return redirect()->route('karyawan.kpis.index')->with('success', 'KPI berhasil diperbarui!');
    }

    public function destroy(KPI $kpi)
    {
        $kpi->delete();
        return redirect()->route('karyawan.kpis.index')->with('success', 'KPI berhasil dihapus!');
    }
}
