<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Pembinaan;
use Illuminate\Http\Request;

class PembinaanController extends Controller
{
    public function index()
    {
        $pembinaans = Pembinaan::all();
        return view('karyawan.pembinaans.index', compact('pembinaans'));
    }

    public function create()
    {
        return view('karyawan.pembinaans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal_pembinaan' => 'required|date',
            'catatan' => 'required|string',
            'hasil' => 'required|string',
        ]);

        Pembinaan::create($request->all());

        return redirect()->route('karyawan.pembinaans.index')->with('success', 'Pembinaan berhasil ditambahkan!');
    }

    public function edit(Pembinaan $pembinaan)
    {
        return view('karyawan.pembinaans.edit', compact('pembinaan'));
    }

    public function update(Request $request, Pembinaan $pembinaan)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal_pembinaan' => 'required|date',
            'catatan' => 'required|string',
            'hasil' => 'required|string',
        ]);

        $pembinaan->update($request->all());

        return redirect()->route('karyawan.pembinaans.index')->with('success', 'Pembinaan berhasil diperbarui!');
    }

    public function destroy(Pembinaan $pembinaan)
    {
        $pembinaan->delete();
        return redirect()->route('karyawan.pembinaans.index')->with('success', 'Pembinaan berhasil dihapus!');
    }
}
