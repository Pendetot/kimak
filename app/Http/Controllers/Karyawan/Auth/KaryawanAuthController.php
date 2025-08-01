<?php

namespace App\Http\Controllers\Karyawan\Auth;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class KaryawanAuthController extends Controller
{
    /**
     * Show the karyawan login form.
     */
    public function showLoginForm()
    {
        return view('karyawan.auth.login');
    }

    /**
     * Handle karyawan login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Add status check to credentials
        $credentials['is_active'] = true;
        $credentials['status_karyawan'] = 'aktif';

        if (Auth::guard('karyawan')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Update last login
            $karyawan = Auth::guard('karyawan')->user();
            $karyawan->updateLastLogin($request->ip());
            
            return redirect()->intended(route('karyawan.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or your account is not active.',
        ])->onlyInput('email');
    }

    /**
     * Handle karyawan API login request.
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $karyawan = Karyawan::where('email', $request->email)
                          ->where('is_active', true)
                          ->where('status_karyawan', 'aktif')
                          ->first();

        if (!$karyawan || !Hash::check($request->password, $karyawan->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect or account is not active.'],
            ]);
        }

        // Update last login
        $karyawan->updateLastLogin($request->ip());

        // Create token
        $token = $karyawan->createToken('karyawan-token', ['karyawan:*'])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'karyawan' => [
                    'id' => $karyawan->id,
                    'nik' => $karyawan->nik,
                    'nama_lengkap' => $karyawan->nama_lengkap,
                    'email' => $karyawan->email,
                    'jabatan' => $karyawan->jabatan,
                    'departemen' => $karyawan->departemen,
                    'foto_profil' => $karyawan->getPhotoUrl(),
                ],
                'token' => $token,
            ]
        ]);
    }

    /**
     * Handle karyawan logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('karyawan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('karyawan.login');
    }

    /**
     * Handle karyawan API logout request.
     */
    public function apiLogout(Request $request)
    {
        // Revoke the current token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }

    /**
     * Get authenticated karyawan data for API.
     */
    public function me(Request $request)
    {
        $karyawan = $request->user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'karyawan' => [
                    'id' => $karyawan->id,
                    'nik' => $karyawan->nik,
                    'nip' => $karyawan->nip,
                    'nama_lengkap' => $karyawan->nama_lengkap,
                    'nama_panggilan' => $karyawan->nama_panggilan,
                    'email' => $karyawan->email,
                    'jenis_kelamin' => $karyawan->jenis_kelamin?->label(),
                    'tanggal_lahir' => $karyawan->tanggal_lahir?->format('Y-m-d'),
                    'alamat_domisili' => $karyawan->alamat_domisili,
                    'no_telepon' => $karyawan->no_telepon,
                    'no_hp' => $karyawan->no_hp,
                    'jabatan' => $karyawan->jabatan,
                    'departemen' => $karyawan->departemen,
                    'divisi' => $karyawan->divisi,
                    'tanggal_masuk' => $karyawan->tanggal_masuk?->format('Y-m-d'),
                    'status_karyawan' => $karyawan->status_karyawan?->label(),
                    'jenis_kontrak' => $karyawan->jenis_kontrak?->label(),
                    'foto_profil' => $karyawan->getPhotoUrl(),
                    'age' => $karyawan->age,
                    'work_duration' => $karyawan->work_duration,
                ]
            ]
        ]);
    }

    /**
     * Show change password form.
     */
    public function showChangePasswordForm()
    {
        return view('karyawan.auth.change-password');
    }

    /**
     * Handle change password request.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $karyawan = Auth::guard('karyawan')->user();

        if (!Hash::check($request->current_password, $karyawan->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $karyawan->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    /**
     * Handle API change password request.
     */
    public function apiChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $karyawan = $request->user();

        if (!Hash::check($request->current_password, $karyawan->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
                'errors' => [
                    'current_password' => ['The current password is incorrect.']
                ]
            ], 422);
        }

        $karyawan->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.'
        ]);
    }

    /**
     * Show profile edit form.
     */
    public function showProfile()
    {
        $karyawan = Auth::guard('karyawan')->user();
        return view('karyawan.profile.show', compact('karyawan'));
    }

    /**
     * Update profile.
     */
    public function updateProfile(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();

        $request->validate([
            'nama_panggilan' => 'nullable|string|max:255',
            'alamat_domisili' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:20',
            'email_pribadi' => 'nullable|email|max:255',
            'kontak_darurat_nama' => 'nullable|string|max:255',
            'kontak_darurat_hubungan' => 'nullable|string|max:255',
            'kontak_darurat_telepon' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'nama_panggilan',
            'alamat_domisili',
            'no_telepon',
            'no_hp',
            'email_pribadi',
            'kontak_darurat_nama',
            'kontak_darurat_hubungan',
            'kontak_darurat_telepon',
        ]);

        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($karyawan->foto_profil && \Storage::exists($karyawan->foto_profil)) {
                \Storage::delete($karyawan->foto_profil);
            }

            $path = $request->file('foto_profil')->store('karyawan/photos', 'public');
            $data['foto_profil'] = $path;
        }

        $karyawan->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Handle API profile update.
     */
    public function apiUpdateProfile(Request $request)
    {
        $karyawan = $request->user();

        $request->validate([
            'nama_panggilan' => 'nullable|string|max:255',
            'alamat_domisili' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:20',
            'email_pribadi' => 'nullable|email|max:255',
            'kontak_darurat_nama' => 'nullable|string|max:255',
            'kontak_darurat_hubungan' => 'nullable|string|max:255',
            'kontak_darurat_telepon' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'nama_panggilan',
            'alamat_domisili',
            'no_telepon',
            'no_hp',
            'email_pribadi',
            'kontak_darurat_nama',
            'kontak_darurat_hubungan',
            'kontak_darurat_telepon',
        ]);

        // Handle photo upload
        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($karyawan->foto_profil && \Storage::exists($karyawan->foto_profil)) {
                \Storage::delete($karyawan->foto_profil);
            }

            $path = $request->file('foto_profil')->store('karyawan/photos', 'public');
            $data['foto_profil'] = $path;
        }

        $karyawan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => [
                'karyawan' => [
                    'id' => $karyawan->id,
                    'nama_lengkap' => $karyawan->nama_lengkap,
                    'nama_panggilan' => $karyawan->nama_panggilan,
                    'foto_profil' => $karyawan->getPhotoUrl(),
                ]
            ]
        ]);
    }
}
