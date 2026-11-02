<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            'rememberedEmail' => request()->cookie('endorphine_remembered_email'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Cek ketersediaan user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 2. Jika user ditemukan dan statusnya nonaktif (is_active == false / 0)
        if ($user && ! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi Owner.',
            ]);
        }

        // 3. Proses otentikasi standar Laravel
        $request->authenticate();

        $request->session()->regenerate();

        // Paksa semua role masuk ke /dashboard utama (diatur universal oleh DashboardController)
        $response = redirect()->intended(route('dashboard', absolute: false));

        if ($request->boolean('remember')) {
            $response->withCookie(cookie('endorphine_remembered_email', $request->email, 60 * 24 * 30));
        } else {
            $response->withCookie(cookie()->forget('endorphine_remembered_email'));
        }

        return $response;
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}