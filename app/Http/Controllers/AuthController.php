<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            $user->update([
                'last_login_ip' => $ipAddress,
                'last_login_at' => now(),
            ]);

            UserLoginLog::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => $ipAddress,
                'status' => 'Success',
                'user_agent' => $userAgent,
                'login_at' => now(),
            ]);

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back to Track Tech Solutions!');
        }

        UserLoginLog::create([
            'user_id' => null,
            'email' => $credentials['email'],
            'ip_address' => $ipAddress,
            'status' => 'Failed',
            'user_agent' => $userAgent,
            'login_at' => now(),
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'in:Admin,Production Manager,Cutting Operator,Quality Inspector'],
        ]);

        $ipAddress = $request->ip();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'Production Manager',
            'last_login_ip' => $ipAddress,
            'last_login_at' => now(),
        ]);

        UserLoginLog::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $ipAddress,
            'status' => 'Success (Register)',
            'user_agent' => $request->userAgent(),
            'login_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account created successfully! Welcome to Track Tech Solutions.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
