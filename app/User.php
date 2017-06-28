<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUser($email){
        return DB::table('user')
            ->where('email', '=', $email)
            ->first();
    }

    public static function addUserFromCas($attr){
        $email = $attr['email'];
        $user = DB::table('user')->where('email', '=', $email)->get();
        if (count($user) == 0)
            return false;
        $maCQ = $attr['maCqBhxh'];
        $ten = (array_key_exists('ten'))?$attr['ten']:'';
    }
}
