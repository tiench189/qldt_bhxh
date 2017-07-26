<?php

namespace App\Http\Middleware;

use Closure;
use phpCAS;
use App\MySession;
use Illuminate\Support\Facades\Config;

class CasAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sessID = $request->session()->get('st');
        $isAuth = MySession::isAuthen($sessID);
        if (!($isAuth == Config::get('ctx.is_login'))) {
            $request->session()->put('next_request', $request->url());
            if ($isAuth == Config::get('ctx.logout')) {
                return redirect('/logout');
            } else {
                return redirect('/cas');
            }
        }
        return $next($request);
    }
}
