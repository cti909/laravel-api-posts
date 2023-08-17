<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RefreshToken
{
    public function handle($request, Closure $next)
    {
        try {
            // Kiểm tra token
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            // Thực hiện refresh token
            $newToken = JWTAuth::parseToken()->refresh();

            // Thêm token mới vào header của response
            return $next($request)->header('Authorization', 'Bearer ' . $newToken);
        }

        return $next($request);
    }
}
