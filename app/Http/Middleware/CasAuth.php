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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sessID = $request->session()->get('st');
        $isAuth = MySession::isAuthen($sessID);
        if (!($isAuth == Config::get('ctx.is_login'))) {
            $request->session()->put('next_request', $request->url());
//            phpCAS::setDebug();
//            phpCAS::setVerbose(true);
//            phpCAS::client(CAS_VERSION_2_0, Config::get('conf.cas_host'),
//                Config::get('conf.cas_port'), Config::get('conf.cas_context'));
//            phpCAS::setNoCasServerValidation();
//            phpCAS::handleLogoutRequests();
//            phpCAS::forceAuthentication();
            if ($isAuth == Config::get('ctx.logout')){
//                phpCAS::logoutWithRedirectService(env('ALIAS') . "/cas");
                return redirect('/logout');
            }else{
                return redirect('/cas');
//                MySession::logSession(phpCAS::getUser());
//                $request->session()->put('st', session_id());
            }
        }
        return $next($request);
    }
}
