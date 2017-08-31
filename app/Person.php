<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'type', 'email', 'donvi', 'sex', 'chucvu', 'birthday',
        'chucdanh', 'auth', 'username', 'confirmed', 'timecreated', 'timemodified', 'hocvan'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'person';

    public $timestamps = false;

    public function getDonvi()
    {
        return $this->belongsTo('App\Donvi', 'donvi');
    }

    public function getGiangVien()
    {
        return $this->hasOne('App\GiangVien', 'user_id');
    }

    public static function getUser($email)
    {
        return DB::table('person')
            ->where('email', '=', $email)
            ->first();
    }

    public static function adduser($name, $email, $donvi, $auth)
    {

        $dvbh = DB::table('donvi')->where('ma_donvi', $donvi)->first();

        if (count($dvbh) > 0) {
            $donvi = $dvbh->id;
        } else $donvi = 0;

        $result = DB::table('person')
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
        $result = DB::table('person')->insert($data);
        if ($result) return ['result' => true, 'mess' => 'Success'];
        return ['result' => false, 'mess' => $result];
    }


    public static function insertLastID($data)
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

//        echo json_encode($data);die;

        $person = Person::create($data);

        return $person->id;
    }

    public static function checkEmailExist($email)
    {
        $user = DB::table('person')->where('email', '=', $email)->get();
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

    public function classes()
    {
        return $this->belongsToMany('App\Lop', 'lop_giangvien', 'giangvien_id', 'lop_id');
    }

    public function st_hocvan()
    {
        return $this->hasOne('App\Hocvan', 'id', 'hocvan');
    }
}
