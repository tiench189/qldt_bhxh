<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'donvi'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'user';

    public function getDonvi()
    {
        return $this->belongsTo('App\Donvi', 'donvi');
    }

    public static function getUser($email)
    {
        return DB::table('users')
            ->where('email', '=', $email)
            ->first();
    }

    public static function adduser($name, $email, $donvi, $auth)
    {

        $dvbh = DB::table('donvi')->where('ma_donvi', $donvi)->first();

        if (count($dvbh) > 0) {
            $donvi = $dvbh->id;
        } else $donvi = 0;

        $result = DB::table('users')
            ->insert([
                'auth' => $auth,
                'confirmed' => 1,
                'firstname' => $name,
                'email' => $email,
                'username' => $email,
                'timecreated' => time(),
                'timemodified' => time(),
                'donvi' => $donvi,
            ]);
        return $result;
    }

    public static function insert($data)
    {
        if (!array_key_exists('email', $data))
            return ['result' => false, 'mess' => 'Email is required'];
        if (!array_key_exists('auth', $data))
            $data['auth'] = 'manual';
        if (!array_key_exists('username', $data))
            $data['username'] = $data['email'];
        $data['confirmed'] = 1;
        $data['timecreated'] = time();
        $data['timemodified'] = time();
        $result = DB::table('users')->insert($data);
        if ($result) return ['result' => true, 'mess' => 'Success'];
        return ['result' => false, 'mess' => $result];
    }

    public static function checkEmailExist($email)
    {
        $user = DB::table('users')->where('email', '=', $email)->get();
        return (count($user) > 0);
    }

    public static function addUserFromCas($attr)
    {
        $email = $attr['email'];
        if (self::checkEmailExist($email))
            return false;
        $maCQ = $attr['maCqBhxh'];
        $ten = (array_key_exists('ten', $attr)) ? $attr['ten'] : '';
        self::adduser($ten, $email, $maCQ, 'cas');
        return true;
    }
}
