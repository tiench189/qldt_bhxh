<?php

namespace App\Http\Middleware;

use App\Roles;
use Closure;

class CheckRole
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
        if (Roles::checkRole($request->route()->getName())) {
            return $next($request);
        }else{
            return redirect('/errpermission');
        }
    }
}
