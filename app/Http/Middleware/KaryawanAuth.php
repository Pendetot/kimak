<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KaryawanAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('karyawan')->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Please login as karyawan.',
                ], 401);
            }
            
            return redirect()->route('karyawan.login');
        }

        $karyawan = Auth::guard('karyawan')->user();

        // Check if karyawan is active
        if (!$karyawan->isActive()) {
            Auth::guard('karyawan')->logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is inactive. Please contact HR.',
                ], 403);
            }
            
            return redirect()->route('karyawan.login')
                           ->withErrors(['email' => 'Your account is inactive. Please contact HR.']);
        }

        return $next($request);
    }
}