<?php

namespace App\Http\Controllers\HRD;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('hrd.karyawans.index', compact('karyawans'));
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
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:karyawans',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'jabatan' => 'required|string|max:255',
            'penempatan' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('hrd.data-karyawan')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        return view('hrd.karyawans.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        return view('hrd.karyawans.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:karyawans,nik,' . $karyawan->id,
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'jabatan' => 'required|string|max:255',
            'penempatan' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $karyawan->update($request->all());

        return redirect()->route('hrd.data-karyawan')->with('success', 'Karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('hrd.data-karyawan')->with('success', 'Karyawan berhasil dihapus!');
    }
}
