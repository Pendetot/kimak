<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\RoleEnum;
use App\Models\Setting;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole(RoleEnum::SuperAdmin)) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->hasRole(RoleEnum::HRD)) {
            return redirect()->route('hrd.dashboard');
        } elseif ($user->hasRole(RoleEnum::Keuangan)) {
            return redirect()->route('keuangan.dashboard');
        
        } elseif ($user->hasRole(RoleEnum::Logistik)) {
            return redirect()->route('logistik.dashboard');
        } else {
            $is_form_enabled = Setting::where('key', 'is_form_enabled')->first();
            $is_form_enabled = $is_form_enabled ? ($is_form_enabled->value === 'true') : true; // Default to true if not set
            return view('home', compact('is_form_enabled'));
        }
    }
}
