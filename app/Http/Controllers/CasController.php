<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/27/2017
 * Time: 12:05 PM
 */

namespace App\Http\Controllers;


use App\MySession;
use App\User;
use app\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use phpCAS;

class CasController extends Controller
{
    public function login(Request $request)
    {
        phpCAS::setDebug();
        phpCAS::setVerbose(true);
        phpCAS::client(CAS_VERSION_3_0, Config::get('conf.cas_host'),
            Config::get('conf.cas_port'), Config::get('conf.cas_context'));
        phpCAS::setNoCasServerValidation();
        phpCAS::handleLogoutRequests();
        phpCAS::forceAuthentication();
        $email = phpCAS::getUser();
        $attr = phpCAS::getAttributes();
        MySession::logSession($email);
        $user = User::getUser($email);
        $request->session()->put('user', $user);
        $request->session()->put('isAuth', true);
        $request->session()->put('st', session_id());
        return redirect($request->session()->get('next_request'));
    }

    public function logout(Request $request)
    {
        $sessID = $request->session()->get('st');
        MySession::removeLog($sessID);
        $request->session()->put('user', null);
        $request->session()->put('isAuth', false);
        phpCAS::setDebug();
        phpCAS::setVerbose(true);
        phpCAS::client(CAS_VERSION_2_0, Config::get('conf.cas_host'),
            Config::get('conf.cas_port'), Config::get('conf.cas_context'));
        phpCAS::logoutWithRedirectService("http://tiench.qldt.vn/cas");
    }

    public function caslogout(Request $request){
        $xml =$request->getContent();
        $xml = urldecode($xml);
        $sessID = \App\Utils::parseSessID($xml);
        MySession::logout($sessID);
        return "Success";
    }
}