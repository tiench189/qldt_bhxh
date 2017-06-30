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
use Validator;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Settings;


class CourseController extends Controller
{
    public function index(Request $request){
        $cate = $request->c;
        if (isset($cate)){
            $course = DB::table('course')->where('category', '=', $cate)->get();
            $catename = DB::table('course_categories')->where('id', $cate)->first()->name;
        }else {
            $course = DB::table('course')->get();
            $catename = "";
        }
        return view('course.index', ['course' => $course, 'category' => $catename]);
    }

    public function edit(Request $request){
        $courseId = intval($request->id);
        if($courseId > 0) {
            $course = DB::table('course')->where('id', $courseId)->first();
            return view('course.edit', ['course'=>$course]);
        } else {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CourseController@index');
        }
    }
    public function update(Request $request)
    {
        $id = intval( $request->input('id') );
        if($id > 0) {
            $messages = [
                'shortname.required' => 'Yêu cầu nhập tên khóa học (rút gọn)',
                'fullname.required' => 'Yêu cầu nhập tên khóa học.',
            ];
            $validator = Validator::make($request->all(), [
                'shortname' => 'required',
                'fullname' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('CourseController@update',["id"=>$id])
                    ->withErrors($validator)
                    ->withInput();
            }

            $result = DB::table('course')
                ->where('id', $id)
                ->update([
                    'shortname'=>$request->input('shortname'),
                    'fullname'=>$request->input('fullname'),
                    'summary'=>$request->input('summary'),
                    'timemodified'=>time(),
                    ]);

            if($result) {
                $request->session()->flash('message', "Cập nhật thành công.");
            } else {
                $request->session()->flash('message', "Cập nhật không thành công.");
            }

            return redirect()->action(
                'CourseController@index', ['update' => $result]
            );
        } else {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CourseController@index');
        }
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
            ->select('id', 'username', 'email', 'firstname', 'lastname', 'donvi')
            ->get();
        $users = \App\Utils::row2Array($dataUser);

        //Lay thong tin xep loai
        $dataXeploai = DB::table('xeploai')->get();
        $xeploai = \App\Utils::row2Array($dataXeploai);

        //Lay thong tin don vi
        $datadonvi = DB::table('donvi')
            ->get();
        $donvi = \App\Utils::row2Array($datadonvi);

        $output = ['course' => $course, 'allResult' => $allResult, 'users' => $users, 'xeploai' => $xeploai, 'donvi' => $donvi];
//        return response()->json($output);
        return view('course.result', $output);
    }

    public function export(Request $request)
    {
        $course = DB::table('lop')
            ->select("COURSE_ID",DB::raw('count("COURSE_ID") as so_lop'),"doi_tuong",DB::raw('EXTRACT(YEAR FROM "TIME_START") as NAM'))
            ->groupBy('course_id','doi_tuong',DB::raw('EXTRACT(YEAR FROM "TIME_START")'))
            ->get();



        $courseinfo = DB::table('course')
            ->select("ID","SHORTNAME","FULLNAME")->get();
        $coursearray = [];
        foreach ($courseinfo as $r) {
            $coursearray[$r->id] = $r;
        }

        $rs = [];

        foreach ($course as $row) {
            $rs[$row->nam][$row->course_id]["so_lop"] = $row->so_lop;
            $rs[$row->nam][$row->course_id]["doi_tuong"] = $row->doi_tuong;
        }

        return view('course.report', ['coursearray'=>$coursearray,'rs' => $rs]);
    }
    // Danh sach lop

    public function classindex(Request $request){
        $courseId = intval($request->c);

        if($courseId > 0 ) {
            //Lay thong tin khoa hoc
            $course = DB::table('course')->where('id', $courseId)->first();
            // lay thong tin lop
            $class = DB::table('lop')->where('course_id', $courseId)->get();

            $lophocvien = DB::table('lop_hocvien')
                ->select('lop_id', DB::raw('count(user_id) as hoc_vien'))
                ->groupBy('lop_id')
                ->get();

            $hocvien = [];
            foreach ($lophocvien as $r) {
                $hocvien[$r->lop_id] = $r->hoc_vien;
            }
            $output = ['class'=>$class,'course' => $course,'hocvien'=>$hocvien];
//            dd($output);
            return view('course.classindex', $output);

        } else {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CourseController@index');
        }
    }

    public function dshocvien(Request $request){
        define('CONTEXT_COURSE', 50);

        $courseId = $request->input('courseId');
        $enrols = DB::table('enrol')->where('courseid', '=', $courseId)->get();

        foreach ($enrols as $item){
            $enrolIds[] = $item->id;
        }

        $userObjs = DB::table('user_enrolments')
            ->whereIn('enrolid', $enrolIds)
            ->select('userid')
            ->get();
        $users = array();
        if(!empty($userObjs)){
            foreach ($userObjs as $item){
                $userIds[] = $item->userid;
            }
            $users = DB::table('user')
                ->whereIn('id', $userIds)
                ->select('id', 'username', 'firstname', 'lastname', 'email', 'description')
                ->get();
        }

        $instances = DB::table('context')
            ->where('contextlevel', '=', CONTEXT_COURSE)
            ->where('instanceid', '=', $courseId)
            ->select('id')
            ->get();


        if(!empty($instances)){
            foreach ($instances as $instance) {
                $instanceIds[] = $instance->id;
            }
        }

        $roles = DB::table('role_assignments')
            ->whereIn('contextid', $instanceIds)
            ->select('id', 'userid', 'roleid')
            ->get();

        $teacherIds = array();
        foreach ($roles as $item){
            if($item->roleid == 5){ // student
                $data[$item->userid][] = 'editingteacher';
                $studentIds[] = $item->userid;
            }
        }

        $students = array();
        foreach ($users as $user){
            if(in_array($user->id, $studentIds)){
                $students[] = $user;
            }
        }

        return view('course.dshocvien',['users' => $students]);
    }
}