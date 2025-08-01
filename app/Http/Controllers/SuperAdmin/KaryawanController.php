<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\KaryawanOperasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = KaryawanOperasional::all();
        return view('superadmin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('superadmin.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:karyawan_operasionals',
            'password' => 'required|string|min:8',
        ]);

        $plainPassword = $request->password;

        $latestKaryawan = KaryawanOperasional::latest()->first();
        $nextId = $latestKaryawan ? $latestKaryawan->id + 1 : 1;
        $karyawanCode = 'Lazy-KR' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $karyawan = KaryawanOperasional::create([
            'karyawan_code' => $karyawanCode,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
        ]);

        $loginLink = url('/karyawan/auth/login');

        return view('superadmin.karyawan.account_created', compact('karyawan', 'plainPassword', 'loginLink', 'karyawanCode'));
    }

    public function edit(KaryawanOperasional $karyawan)
    {
        return view('superadmin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, KaryawanOperasional $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:karyawan_operasionals,email,' . $karyawan->id,
            'password' => 'nullable|string|min:8',
        ]);

        $karyawan->nama = $request->nama;
        $karyawan->email = $request->email;
        if ($request->filled('password')) {
            $karyawan->password = bcrypt($request->password);
        }
        $karyawan->save();

        return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan updated successfully!');
    }

    public function destroy(KaryawanOperasional $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('superadmin.karyawan.index')->with('success', 'Karyawan deleted successfully!');
    }
}
