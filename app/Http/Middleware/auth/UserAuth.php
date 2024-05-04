<?php

namespace App\Http\Middleware\auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || (Auth::user() && Auth::user()->role !== 'user')) {
            return redirect()->route("login")->with("error","You Haven't Access");
        }
        return $next($request);
    }
}
