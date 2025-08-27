<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontAuthController extends Controller
{
    public function showLogin()
    {
        return view('front.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $creds = ['login_id' => $request->login_id, 'password' => $request->password];
        if (Auth::guard('web')->attempt($creds, $request->boolean('remember'))) {
            $user = Auth::guard('web')->user();
            if (! $user->hasVerifiedEmail()) {
                Auth::guard('web')->logout();
                return back()->withErrors(['email' => 'Email not verified.']);
            }
            $request->session()->regenerate();
            return redirect()->route('front.mypage.edit');
        }
        return back()->withErrors(['login_id' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showEntry()
    {
        return view('front.auth.entry');
    }

    public function entry(CustomerStoreRequest $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'login_id' => $request->login_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($customer));

        return redirect()->route('login')->with('status','Registration complete. Please verify your email.');
    }

    public function mypageEdit()
    {
        $customer = auth('web')->user();
        return view('front.mypage.edit', compact('customer'));
    }

    public function mypageUpdate(CustomerUpdateRequest $request)
    {
        $customer = auth('web')->user();
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $customer->update($data);
        return back()->with('status','Profile updated');
    }
}
