<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Keuangan\Hutang\StoreHutangKaryawanRequest;
use App\Http\Requests\Keuangan\Hutang\UpdateHutangKaryawanRequest;
use App\Models\HutangKaryawan;
use Illuminate\Http\Request;

class HutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hutangKaryawans = HutangKaryawan::with('user')->get();
        return view('keuangan.hutang_karyawans.index', compact('hutangKaryawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::all();
        return view('keuangan.hutang_karyawans.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHutangKaryawanRequest $request)
    {
        HutangKaryawan::create($request->validated());

        return redirect()->route('keuangan.hutang-karyawans.index')->with('success', 'Hutang karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HutangKaryawan $hutangKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HutangKaryawan $hutangKaryawan)
    {
        $users = \App\Models\User::all();
        return view('keuangan.hutang_karyawans.edit', compact('hutangKaryawan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHutangKaryawanRequest $request, HutangKaryawan $hutangKaryawan)
    {
        $hutangKaryawan->update($request->validated());

        return redirect()->route('keuangan.hutang-karyawans.index')->with('success', 'Hutang karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HutangKaryawan $hutangKaryawan)
    {
        $hutangKaryawan->delete();
        return redirect()->route('keuangan.hutang-karyawans.index')->with('success', 'Hutang karyawan berhasil dihapus.');
    }
}
