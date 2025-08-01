<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelamar;
use Illuminate\Support\Facades\Auth;

class PelamarDashboardController extends Controller
{
    public function index()
    {
        $pelamar = Auth::user()->pelamar; // Assuming a one-to-one relationship between User and Pelamar
        return view('pelamar.dashboard', compact('pelamar'));
    }

    public function updateAttendance(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'status' => 'required|in:hadir,tidak_hadir',
        ]);

        $pelamar->interview_attendance_status = $request->status;
        $pelamar->save();

        return redirect()->back()->with('success', 'Status kehadiran berhasil diperbarui.');
    }
}