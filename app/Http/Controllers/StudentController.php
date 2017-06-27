<?php
/**
 * Created by PhpStorm.
 * User: go
 * Date: 6/21/2017
 * Time: 10:20 AM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request){
        $users = DB::table('user')->get();

        //Lay thong tin don vi
        $iddv = array();
        foreach ($users as $row){
            $iddv[] = $row->donvi;
        }
        $datadonvi = DB::table('donvi')
            ->whereIn('id', $iddv)
            ->get();
        $donvi = \App\Utils::row2Array($datadonvi);
        return view('student.index', ['users'=>$users, 'donvi' => $donvi]);
    }

    public function histories(Request $request){
        $uid = intval($request->u);

        $histories = DB::table('lop_hocvien')
            ->where('user_id', $uid)
            ->get();
        //Lay thong tin hoc vien
        $user = DB::table('user')
            ->where('id', $uid)
            ->first();

        //Lay thong tin lop va khoa hoc
        $lid = array();
        foreach ($histories as $row){
            $lid[] = $row->lop_id;
        }
        $datalop = DB::table('lop')
            ->join('course', 'lop.course_id', '=', 'course.id')
            ->whereIn('lop.id', $lid)
            ->select('lop.id',  'lop.ten_lop', 'course.fullname as course_name', 'course.id as course_id')
            ->get();
        $lop = \App\Utils::row2Array($datalop);

        //Lay thong tin xep loai
        $dataXeploai = DB::table('xeploai')->get();
        $xeploai = \App\Utils::row2Array($dataXeploai);

        $output = ['user' => $user, 'histories' => $histories, 'lop' => $lop, 'xeploai' => $xeploai];
//        return response()->json($output);
        return view('student.histories', $output);
    }
}