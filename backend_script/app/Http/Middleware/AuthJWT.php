<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class AuthJWT
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error'=>'Invalid token.']);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error'=>'Expired token.']);
            } else {
                return response()->json(['error'=>'Authentication error.']);
            }
        }
        return $next($request);
    }
}
