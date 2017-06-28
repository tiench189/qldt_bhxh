<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/28/2017
 * Time: 9:02 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MySession extends Model
{

    public static function isAuthen($sessID){
        if (!isset($sessID))
            return Config::get('ctx.not_login');
        $sesslog = DB::table('cas_sessions')
            ->where('sessid', '=', $sessID)
            ->first();
        if (!isset($sesslog))
            return Config::get('ctx.not_login');
        if ($sesslog->status == 'LOGOUT')
            return Config::get('ctx.logout');
        return Config::get('ctx.is_login');
    }

    public static function logSession($email){
        DB::table('cas_sessions')->insert([
           'email' => $email,
            'sessid' => session_id(),
            'status' => 'LOGIN'
        ]);
    }

    public static function removeLog($sessID){
        DB::table('cas_sessions')
            ->where('sessid', '=', $sessID)
            ->delete();
    }

    public static function logout($sessID)
    {
        DB::table('cas_sessions')
            ->where('sessid', '=', $sessID)
            ->update(['status' => 'LOGOUT']);
    }
}