<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutasis = \App\Models\Mutasi::with('karyawan')->get();
        return view('hrd.mutasis.index', compact('mutasis'));
    }

    public function edit(\App\Models\Mutasi $mutasi)
    {
        return view('hrd.mutasis.edit', compact('mutasi'));
    }

    public function create()
    {
        return view('hrd.mutasis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:users,id',
            'tanggal_mutasi' => 'required|date',
            'departemen_lama' => 'required|string|max:255',
            'departemen_baru' => 'required|string|max:255',
            'jabatan_lama' => 'required|string|max:255',
            'jabatan_baru' => 'required|string|max:255',
        ]);

        \App\Models\Mutasi::create($request->all());

        return redirect()->route('superadmin.hrd.mutasi-karyawan')->with('success', 'Mutasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Mutasi $mutasi)
    {
        $mutasi->load('karyawan'); // Memuat relasi karyawan
        return view('hrd.mutasis.show', compact('mutasi'));
    }

    public function update(Request $request, \App\Models\Mutasi $mutasi)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:users,id',
            'tanggal_mutasi' => 'required|date',
            'departemen_lama' => 'required|string|max:255',
            'departemen_baru' => 'required|string|max:255',
            'jabatan_lama' => 'required|string|max:255',
            'jabatan_baru' => 'required|string|max:255',
        ]);

        $mutasi->update($request->all());

        return redirect()->route('hrd.mutasi-karyawan.index')->with('success', 'Mutasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
