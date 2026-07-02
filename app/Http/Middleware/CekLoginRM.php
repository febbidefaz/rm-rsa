<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLoginRM
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_rm_id')) {
            return redirect()->route('rm.login');
        }

        return $next($request);
    }
}