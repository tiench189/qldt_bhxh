<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/20/2017
 * Time: 3:13 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index(Request $request){
        $course = DB::table('course')->get();
        dd($course);
    }

    public function allResult(Request $request){
        $courseId = intval($request->c);
        //Lay thong tin khoa hoc
        $course = DB::table('course')->where('id', $courseId)->first();

        //Lay danh sach ket qua
        $allResult = DB::table('ketqua')
            ->where('course_id', $courseId)
            ->orderBy('xeploai', 'asc')
            ->get();

        //Lay thong tin hoc vien
        $uid = array();
        foreach ($allResult as $row){
            $uid[] = $row->user_id;
        }
        $dataUser = DB::table('user')
            ->whereIn('id', $uid)
            ->select('id', 'username', 'email', 'firstname', 'lastname')
            ->get();
        $users = \App\Utils::row2Array($dataUser);

        //Lay thong tin xep loai
        $dataXeploai = DB::table('xeploai')->get();
        $xeploai = \App\Utils::row2Array($dataXeploai);

        $output = ['course' => $course, 'allResult' => $allResult, 'users' => $users, 'xeploai' => $xeploai];
//        return response()->json($output);
        return view('course.result', $output);
    }
}