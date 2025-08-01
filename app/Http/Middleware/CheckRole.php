<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\RoleEnum;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $roleEnum = RoleEnum::tryFrom($role);

            if ($roleEnum && ($user->hasRole(RoleEnum::SuperAdmin) || $user->hasRole($roleEnum))) {
                return $next($request);
            }
        }

        return redirect('/')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}