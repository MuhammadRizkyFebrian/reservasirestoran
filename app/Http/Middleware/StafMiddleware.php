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
        if (Auth::guard('staf')->check()) {
            return $next($request);
        }

        return redirect()->route('admin.login')->with('error', 'Silakan login sebagai staf restoran terlebih dahulu.');
    }
}
