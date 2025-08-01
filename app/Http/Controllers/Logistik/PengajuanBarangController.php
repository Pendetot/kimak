<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuanBarangs = PengajuanBarang::where('requester_id', Auth::id())->get();
        return view('logistik.pengajuan_barang.index', compact('pengajuanBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logistik.pengajuan_barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        PengajuanBarang::create([
            'requester_id' => Auth::id(),
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('logistik.pengajuan-barang.index')->with('success', 'Pengajuan barang berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanBarang $pengajuanBarang)
    {
        return view('logistik.pengajuan_barang.show', compact('pengajuanBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanBarang $pengajuanBarang)
    {
        if ($pengajuanBarang->status !== 'pending') {
            return redirect()->route('logistik.pengajuan-barang.index')->with('error', 'Hanya pengajuan dengan status pending yang bisa diedit.');
        }
        return view('logistik.pengajuan_barang.edit', compact('pengajuanBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanBarang $pengajuanBarang)
    {
        if ($pengajuanBarang->status !== 'pending') {
            return redirect()->route('logistik.pengajuan-barang.index')->with('error', 'Hanya pengajuan dengan status pending yang bisa diupdate.');
        }

        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $pengajuanBarang->update([
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('logistik.pengajuan-barang.index')->with('success', 'Pengajuan barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanBarang $pengajuanBarang)
    {
        if ($pengajuanBarang->status !== 'pending') {
            return redirect()->route('logistik.pengajuan-barang.index')->with('error', 'Hanya pengajuan dengan status pending yang bisa dihapus.');
        }

        $pengajuanBarang->delete();

        return redirect()->route('logistik.pengajuan-barang.index')->with('success', 'Pengajuan barang berhasil dihapus.');
    }
}
