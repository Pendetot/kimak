<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operasional\KPI\StoreKPIRequest;
use App\Http\Requests\Operasional\KPI\UpdateKPIRequest;
use App\Models\KPI;
use Illuminate\Http\Request;

class KPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kpis = KPI::with('user')->get();
        return view('operasional.kpis.index', compact('kpis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::all();
        return view('operasional.kpis.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKPIRequest $request)
    {
        KPI::create($request->validated());

        return redirect()->route('operasional.kpis.index')->with('success', 'KPI berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KPI $kPI)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KPI $kPI)
    {
        $users = \App\Models\User::all();
        return view('operasional.kpis.edit', compact('kPI', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKPIRequest $request, KPI $kPI)
    {
        $kPI->update($request->validated());

        return redirect()->route('operasional.kpis.index')->with('success', 'KPI berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KPI $kPI)
    {
        $kPI->delete();
        return redirect()->route('karyawan.kpis.index')->with('success', 'KPI berhasil dihapus.');
    }
}