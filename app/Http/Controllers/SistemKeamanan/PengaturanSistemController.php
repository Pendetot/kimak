<?php

namespace App\Http\Controllers\SistemKeamanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanSistemController extends Controller
{
    public function index()
    {
        return view('sistem-keamanan.pengaturan-sistem');
    }
}
