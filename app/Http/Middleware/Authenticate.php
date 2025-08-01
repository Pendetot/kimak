<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->is('superadmin/*') || $request->is('superadmin')) {
                return route('superadmin.showLoginForm');
            } elseif ($request->is('hrd/*') || $request->is('hrd')) {
                return route('hrd.showLoginForm');
            } elseif ($request->is('keuangan/*') || $request->is('keuangan')) {
                return route('keuangan.showLoginForm');
            
            } elseif ($request->is('logistik/*') || $request->is('logistik')) {
                return route('logistik.showLoginForm');
            }
            return route('login'); // Default fallback
        }
        return null;
    }
}
