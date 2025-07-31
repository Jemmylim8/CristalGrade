<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, \Closure $next)
{
    if (auth()->check() && auth()->user()->two_factor_code) {
        // if the code hasn't expired yet
        if (!auth()->user()->two_factor_expires_at->isPast()) {
            // if the user is NOT already on the 2FA page, redirect them there
            if (!$request->is('two-factor*')) {
                return redirect()->route('two-factor.index');
            }
        } else {
            // if code expired, reset code, log out user for security
            auth()->user()->resetTwoFactorCode();
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['two_factor' => 'Your 2FA code expired. Please login again.']);
        }
    }

    return $next($request);
}

}
