<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', '!=', 'pelanggan')
            ->latest()
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function create(): View
    {
        return view('owner.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,kasir'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun staf berhasil ditambahkan!');
    }

    public function edit(int $id): View
    {
        $user = User::findOrFail($id);
        $this->ensureEditableAccount($user);

        return view('owner.users.edit', compact('user'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $this->ensureEditableAccount($user);

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,kasir'],
        ]);

        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data akun user berhasil diperbarui!');
    }

    public function toggleStatus(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $this->ensureEditableAccount($user);
        abort_if($user->id === auth()->id(), 403);

        $user->update(['is_active' => ! $user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Akun {$user->name} berhasil {$status}!");
    }

    private function ensureEditableAccount(User $user): void
    {
        abort_unless(in_array(strtolower($user->role), ['admin', 'kasir'], true), 403);
    }
}
