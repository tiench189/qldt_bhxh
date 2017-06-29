<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/21/2017
 * Time: 2:56 PM
 */

namespace app;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utils extends Model
{
    public static function listCategories(){
        return DB::table('course_categories')
            ->orderBy('sortorder', 'asc')
            ->get();
    }

    public static function row2Array($rows){
        $arr = array();
        foreach ($rows as $r){
            $arr[$r->id] = $r;
        }
        return $arr;
    }

    public static function formatTimestamp($time){
        if ($time == null) return '';
        return date('d/m/Y', strtotime($time));
    }


    public static function toTimeFormat($time){
        if ($time == null || $time == 0) return '';
//        return date('d/m/Y', $time);
        return (new \DateTime($time))->format('d/m/Y');
    }
  
  
    public static function getStatus($status){
        $dict = array();
        $dict['finished'] = 'Hoàn thành';
        if (! array_key_exists($status, $dict)) return '';
        return $dict[$status];
    }

    public static function parseSessID($xml){
        $openTag = '<samlp:SessionIndex>';
        $closeTag = '</samlp:SessionIndex>';

        $start = strpos($xml, $openTag);
        $end = strpos($xml, $closeTag);
        $sessID = substr($xml, $start + strlen($openTag), $end - $start - strlen($openTag));
        return $sessID;
    }
}