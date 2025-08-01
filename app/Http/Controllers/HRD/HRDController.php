<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\HRD;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HRDController extends Controller
{
    public function index()
    {
        $hrds = HRD::all();
        return view('hrd.hrd.index', compact('hrds'));
    }

    public function create()
    {
        return view('hrd.hrd.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:hrds',
            'password' => 'required|string|min:8',
        ]);

        $plainPassword = $request->password;

        $latestHRD = HRD::latest()->first();
        $nextId = $latestHRD ? $latestHRD->id + 1 : 1;
        $karyawanCode = 'Lazy-KR' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $hrd = HRD::create([
            'karyawan_code' => $karyawanCode,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
        ]);

        $loginLink = route('hrd.showLoginForm');

        return view('hrd.hrd.account_created', [
            'user' => $hrd,
            'role' => 'hrd',
            'loginLink' => $loginLink,
            'plainPassword' => $plainPassword,
            'karyawanCode' => $karyawanCode,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HRD $hrd)
    {
        return view('hrd.hrd.edit', compact('hrd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HRD $hrd)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:hrds,email,' . $hrd->id,
            'password' => 'nullable|string|min:8',
        ]);

        $hrd->nama = $request->nama;
        $hrd->email = $request->email;
        if ($request->filled('password')) {
            $hrd->password = Hash::make($request->password);
        }
        $hrd->save();

        return redirect()->route('hrd.hrd.index')->with('success', 'HRD updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HRD $hrd)
    {
        $hrd->delete();
        return redirect()->route('hrd.hrd.index')->with('success', 'HRD deleted successfully!');
    }
}
