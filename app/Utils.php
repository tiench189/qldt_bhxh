<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/21/2017
 * Time: 2:56 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utils extends Model
{
    public static function listCategories(){
        return DB::table('course_categories')
            ->orderBy('sortorder', 'asc')
            ->get();
    }
}