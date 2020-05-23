<?php
namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception; 
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Config;
class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    { 
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) { 
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 401,'message' => trans('messages.token-invalid')],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 401,'message' => trans('messages.token-exp')],401);
            }else{
                return response()->json(['status' => 401,'message' => trans('messages.auth-token')],401); 
            } 
        }  
        return $next($request);
    }
}