<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(!auth()->check()){
            return redirect()->route('login0')->withErrors(['email' => 'You must be logged in to access this page.']);
            
        }
        $userRole = auth()->user()->user_role;

        if(!in_array($userRole, $roles)){
            abort(403, 'Pagina nao autorizada!');
        }
        return $next($request);
    }
}
