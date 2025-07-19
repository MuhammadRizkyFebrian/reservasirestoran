<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StafMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('staf')->check()) {
            return redirect()->route('staf.login')->with('error', 'Silakan login sebagai staf restoran terlebih dahulu.');
        }

        return $next($request);
    }
}
