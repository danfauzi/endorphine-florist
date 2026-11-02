<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $credentials = $request->only('email');

        if (app()->environment('local')) {
            /** @var PasswordBroker $broker */
            $broker = Password::broker();
            $user = $broker->getUser($credentials);

            if ($user) {
                $token = $broker->createToken($user);
                $user->sendPasswordResetNotification($token);

                return back()
                    ->with('status', __(Password::RESET_LINK_SENT))
                    ->with('reset_link', route('password.reset', [
                        'token' => $token,
                        'email' => $user->getEmailForPasswordReset(),
                    ]));
            }
        }

        $status = Password::sendResetLink($credentials);

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
