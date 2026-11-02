<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah role user saat ini ada dalam daftar role yang diizinkan
        // Mengubah semua role menjadi huruf kecil sebelum dibandingkan
        $userRole = strtolower($user->role);
        $allowedRoles = array_map('strtolower', $roles);

        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}