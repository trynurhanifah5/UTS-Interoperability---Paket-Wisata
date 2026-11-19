<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // Mengambil username & password dari Authorization: Basic Auth
        $username = $request->getUser();
        $password = $request->getPassword();

        if ($username !== 'admin' || $password !== 'rahasia123') {
            return response()->json([
                'status' => 'Unauthorized',
                'message' => 'Autentikasi Basic Auth gagal. Username atau password salah.'
            ], 401);
        }

        return $next($request);
    }
}