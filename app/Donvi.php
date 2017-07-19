<?php
/**
 * Created by PhpStorm.
 * User: Vivi
 * Date: 18/07/2017
 * Time: 2:40 CH
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Donvi extends Model
{

    protected $table = 'donvi';
    protected $primaryKey = 'ID';

    public function capDonVi()
    {
        return $this->belongsTo('App\CapDonvi', 'cap_donvi');
    }

    public function trucThuoc()
    {
        return $this->belongsTo('App\Donvi', 'ma_truc_thuoc', 'ma_donvi');
    }
}