<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu untuk mengakses dashboard admin.');
        }

        return $next($request);
    }
}
