<?php
/**
 * Created by PhpStorm.
 * User: Vivi
 * Date: 18/07/2017
 * Time: 2:40 CH
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{

    protected $table = 'giangvien';
    protected $primaryKey = 'ID';

//    protected $fillable = ['user_id', 'hoc_ham', 'chuyen_nganh'];
    public $timestamps = false;
}