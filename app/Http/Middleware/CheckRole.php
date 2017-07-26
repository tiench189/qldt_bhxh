<?php

namespace App\Http\Middleware;

use App\Roles;
use Closure;
use Illuminate\Support\Facades\Session;

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
        if (!Roles::checkRole($request->route()->getName(), true)) {
            return redirect('/errpermission');
        }
//        return response()->json(Session::get('role-' . Session::get('user')->id));
        return $next($request);
    }
}
