<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerifiedForGuard
{
    public function handle(Request $request, Closure $next, string $guard = 'web')
    {
        $user = auth($guard)->user();
        if ($user && method_exists($user, 'hasVerifiedEmail') && ! $user->hasVerifiedEmail()) {
            if ($guard === 'admin') {
                return redirect()->route('admin.login')->withErrors(['email' => 'Please verify your email.']);
            }
            return redirect()->route('login')->withErrors(['email' => 'Please verify your email.']);
        }
        return $next($request);
    }
}
