<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class Honeypot
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('POST')) {
            return $next($request);
        }

        if ($request->filled('website')) {
            return back();
        }

        if ($request->is('register')) {
            $allowed = RateLimiter::attempt(
                key: 'register|'.$request->ip(),
                maxAttempts: 5,
                callback: fn () => true,
                decaySeconds: 3600,
            );

            if (! $allowed) {
                abort(429);
            }
        }

        return $next($request);
    }
}
