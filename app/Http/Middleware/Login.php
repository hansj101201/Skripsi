<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(!isLoggedIn()){
            return redirect( "login" );
        }

        $user = Auth::user();
        $userRole = $user->Role()->pluck('ROLE_NAMA')->first();
        // dd ($roles);
        // dd($userRole);
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect('dashboard');
    }
}
