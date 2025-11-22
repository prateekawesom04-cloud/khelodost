<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AuthCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session::get('username')) {
            if($request->ajax()){
                return response()->json([
                    'mesaage'=> 'User Not Logged In',
                    'response_code'=> '403',
                    'redirect'=> route('login')
                ]);
            }
            return redirect()->route('login');
        } else{
            return $next($request);
        }
    }
}
