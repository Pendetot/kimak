<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Models\Pelamar;
use App\Models\PelamarOverride;
use Illuminate\Support\Facades\Auth;

class OverrideController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->role !== RoleEnum::SuperAdmin->value) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'pelamar_id' => 'required|exists:pelamars,id',
            'nik' => 'required|string',
            'nama' => 'required|string',
            'penempatan' => 'required|string',
            'jabatan' => 'required|string',
            'referensi' => 'required|string',
        ]);

        $validatedData['authorized_by'] = Auth::id();

        PelamarOverride::create($validatedData);

        $pelamar = Pelamar::find($request->input('pelamar_id'));
        $pelamar->status_validasi = 'valid';
        $pelamar->save();

        return response()->json(['message' => 'Override successful']);
    }
}
