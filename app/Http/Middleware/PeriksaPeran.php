<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeriksaPeran
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$perans): Response
    {
        if (! $request->user()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        if ($request->user()->peran === 'admin') {
            return $next($request);
        }

        if (! in_array($request->user()->peran, $perans)) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return $next($request);
    }
}
