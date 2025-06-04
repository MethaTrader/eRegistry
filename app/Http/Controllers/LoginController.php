<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        return view('login'); // Файл resources/views/auth/login.blade.php
    }

    /**
     * Handle the login request.
     */
    public function login(LoginRequest $request)
    {
        $throttleKey = $this->throttleKey($request);

        // Проверяем, превышено ли количество попыток
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            if ($seconds < 60) {
                $timeMessage = 'less minute';
            } else {
                $minutes = ceil($seconds / 60);
                $timeMessage = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
            }

            return back()->withErrors([
                'email' => 'Too many login attempts. Please wait ' . $timeMessage . ' before trying again.',
            ])->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Проверка, что пользователь имеет роль Admin или Doctor
            if (!$user->hasAnyRole(['admin', 'doctor'])) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Access denied. You do not have permission to log in.',
                ])->withInput($request->only('email'));
            }

            // При успешном входе сбрасываем счётчик попыток
            RateLimiter::clear($throttleKey);
            return redirect()->intended('/dashboard');
        }

        // Фиксируем неудачную попытку с периодом действия 300 секунд (5 минут)
        RateLimiter::hit($throttleKey, 300);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Log out the user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Генерирует уникальный ключ для rate limiting на основе email и IP-адреса.
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
