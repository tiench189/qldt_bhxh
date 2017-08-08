<?php
/**
 * Created by PhpStorm.
 * User: Vivi
 * Date: 18/07/2017
 * Time: 2:40 CH
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    protected $table = 'lop';

    public function teachers()
    {
        return $this->belongsToMany('App\Person', 'lop_giangvien', 'lop_id', 'giangvien_id');
    }
}