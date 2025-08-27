<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function register(AdminRegisterRequest $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'login_id' => $request->login_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($admin));

        return redirect()->route('admin.login')->with('status', 'Registration complete. Please verify your email.');
    }

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $creds = ['login_id' => $request->login_id, 'password' => $request->password];
        if (Auth::guard('admin')->attempt($creds, $request->boolean('remember'))) {
            $admin = Auth::guard('admin')->user();
            if (! $admin->hasVerifiedEmail()) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Email not verified.']);
            }
            $request->session()->regenerate();
            return redirect()->route('admin.members.index');
        }
        return back()->withErrors(['login_id' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
