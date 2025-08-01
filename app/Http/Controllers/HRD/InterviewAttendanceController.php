<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;

class InterviewAttendanceController extends Controller
{
    public function index()
    {
        $pelamars = Pelamar::whereNotNull('tanggal_interview')
                            ->orderBy('tanggal_interview', 'desc')
                            ->get();
        return view('hrd.administrasi_pelamar.interview_attendance', compact('pelamars'));
    }
}
