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

use App\MoodleRest;


class CourseController extends Controller
{
    public function index(Request $request)
    {
        $cate = $request->c;
        if (isset($cate)) {
            $course = DB::table('course')->where('category', '=', $cate)->get();
            $catename = DB::table('course_categories')->where('id', $cate)->first()->name;
        } else {
            $course = DB::table('course')->get();
            $catename = "";
        }
        return view('course.index', ['course' => $course, 'category' => $catename]);
    }

    public function edit(Request $request)
    {
        $courseId = intval($request->id);
        if ($courseId > 0) {
            $course = DB::table('course')->where('id', $courseId)->first();
            $cate = DB::table('course_categories')->orderBy('id', 'asc')->get();
            $categories = array();
            foreach ($cate as $row){
                $categories[$row->id] = $row->name;
            }
            return view('course.edit', ['course' => $course, 'categories' => $categories]);
        } else {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CourseController@index');
        }
    }

    public function update(Request $request)
    {
        $id = intval($request->input('id'));
        if ($id > 0) {
            $messages = [
                'fullname.required' => 'Yêu cầu nhập tên khóa học.',
            ];
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('CourseController@update', ["id" => $id])
                    ->withErrors($validator)
                    ->withInput();
            }

            $result = DB::table('course')
                ->where('id', $id)
                ->update([
                    'fullname' => $request->input('fullname'),
                    'category' => $request->input('category'),
                    'summary' => $request->input('summary'),
                    'timemodified' => time(),
                ]);

            if ($result) {
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

    public function allResult(Request $request)
    {
        $courseId = intval($request->c);
        $courseId = isset($courseId) ? $courseId : 0;
        $classID = intval($request->class);
        $classID = isset($classID) ? $classID : 0;
        $ddclass = [];
        $dduser = [];
        if ($courseId != 0 && $classID == 0) {
            //Lay thong tin khoa hoc
            $course = DB::table('course')->where('id', $courseId)->first();
            //Lay danh sach ket qua
            $allResult = DB::table('lop_hocvien')
                ->join('lop', 'lop.id', '=', 'lop_hocvien.lop_id')
                ->where('lop.course_id', '=', $course->id)
                ->select('lop.ten_lop as ten_lop', 'lop_hocvien.*')
                ->get();
            $class = array();

            // Lấy thông tin toàn bộ lớp học trong khóa
            $dataClass = DB::table('lop')
                ->where('course_id', $courseId)
                ->get();
            foreach ($dataClass as $c) {
                $ddclass[$c->id] = $c->ten_lop;
            }

        }else{
            //Lấy thông tin lớp
            $class = DB::table('lop')->where('id', $classID)->first();
            //Lay thong tin khoa hoc
            $course = $course = DB::table('course')->where('id', $class->course_id)->first();
            //Lay danh sach ket qua
            $allResult = DB::table('lop_hocvien')
                ->join('lop', 'lop.id', '=', 'lop_hocvien.lop_id')
                ->where('lop.id', '=', $classID)
                ->select('lop.ten_lop as ten_lop', 'lop.course_id as course_id', 'lop_hocvien.*')
                ->get();
        }
        //Lay thong tin hoc vien
        $uid = array();
        foreach ($allResult as $row) {
            $uid[] = $row->user_id;
        }
        $dataUser = DB::table('user')
            ->whereIn('id', $uid)
            ->select('id', 'username', 'email', 'firstname', 'lastname', 'donvi')
            ->get();

        $users = \App\Utils::row2Array($dataUser);

        // Lấy toàn bộ danh sách học viên
        $allUser = DB::table('user')
            ->select('id', 'username', 'email', 'firstname', 'lastname', 'donvi')
            ->get();
        foreach ($allUser as $u) {
            $dduser[$u->id] = $u->firstname . " " . $u->lastname . " (" . $u->username . ")";
        }

        //Lay thong tin xep loai
        $dataXeploai = DB::table('xeploai')->get();
        $xeploai = \App\Utils::row2Array($dataXeploai);
        $ddlxeploai = [];
        foreach ($dataXeploai as $x) {
            $ddlxeploai[$x->id] = $x->name;
        }

        //Lay thong tin don vi
        $datadonvi = DB::table('donvi')
            ->get();
        $donvi = \App\Utils::row2Array($datadonvi);

        $output = ['course' => $course, 'allResult' => $allResult, 'users' => $users, 'xeploai' => $xeploai,'ddlxeploai' => $ddlxeploai,
            'donvi' => $donvi, 'courseID' => $courseId, 'classID' => $classID, 'class' => $class, "dduser"=> $dduser,"ddclass"=>$ddclass];
//        return response()->json($output);
        return view('course.result', $output);
    }


    public function addstudent(Request $request) {

        $cid = intval($request->input('cid'));
        $sid = intval($request->input('sid'));
        $xeploai = intval($request->input('xeploai'));
        $grade = floatval($request->input('grade'));
        $status = $request->input('status');

        // Lấy thông tin toàn bộ lớp học trong khóa
        $check = DB::table('lop_hocvien')
            ->where([
                ['lop_id', '=', $cid],
                ['user_id', '=', $sid],
            ])
            ->count();
        if($check == 0) {
            $result = DB::table('lop_hocvien')
                ->insert([
                    'lop_id' => $cid,
                    'user_id' => $sid,
                    'status' => $status,
                    'grade' => $grade,
                    'xeploai' => $xeploai,
                    'complete_at' => date('Y-m-d H:i:s'),
                ]);

            if ($result) {
                $request->session()->flash('message', "Thêm học viên vào lớp thành công.");
            } else {
                $request->session()->flash('message', "Thêm học viên vào lớp không thành công.");
            }
        } else {
            $request->session()->flash('message', "Học viên đã tồn tại trong lớp này.");
        }



            return back()->withInput();;
    }

    public function export(Request $request)
    {
        $course = DB::table('lop')
            ->select("COURSE_ID", DB::raw('count("COURSE_ID") as so_lop'), "doi_tuong", DB::raw('EXTRACT(YEAR FROM "TIME_START") as NAM'))
            ->groupBy('course_id', 'doi_tuong', DB::raw('EXTRACT(YEAR FROM "TIME_START")'))
            ->get();


        $courseinfo = DB::table('course')
            ->select("ID", "SHORTNAME", "FULLNAME")->get();
        $coursearray = [];
        foreach ($courseinfo as $r) {
            $coursearray[$r->id] = $r;
        }

        $rs = [];

        foreach ($course as $row) {
            $rs[$row->nam][$row->course_id]["so_lop"] = $row->so_lop;
            $rs[$row->nam][$row->course_id]["doi_tuong"] = $row->doi_tuong;
        }

        return view('course.report', ['coursearray' => $coursearray, 'rs' => $rs]);
    }

    // Danh sach lop

    public function classindex(Request $request)
    {
        $courseId = intval($request->c);

        if ($courseId > 0) {
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
            $output = ['class' => $class, 'course' => $course, 'hocvien' => $hocvien];
//            dd($output);
            return view('course.classindex', $output);

        } else {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CourseController@index');
        }
    }

    public function dshocvien(Request $request)
    {
        define('CONTEXT_COURSE', 50);

        $courseId = $request->input('courseId');
        $enrols = DB::table('enrol')->where('courseid', '=', $courseId)->get();

        foreach ($enrols as $item) {
            $enrolIds[] = $item->id;
        }

        $userObjs = DB::table('user_enrolments')
            ->whereIn('enrolid', $enrolIds)
            ->select('userid')
            ->get();
        $users = array();
        if (!empty($userObjs)) {
            foreach ($userObjs as $item) {
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


        if (!empty($instances)) {
            foreach ($instances as $instance) {
                $instanceIds[] = $instance->id;
            }
        }

        $roles = DB::table('role_assignments')
            ->whereIn('contextid', $instanceIds)
            ->select('id', 'userid', 'roleid')
            ->get();

        $teacherIds = array();
        foreach ($roles as $item) {
            if ($item->roleid == 5) { // student
                $data[$item->userid][] = 'editingteacher';
                $studentIds[] = $item->userid;
            }
        }

        $students = array();
        foreach ($users as $user) {
            if (in_array($user->id, $studentIds)) {
                $students[] = $user;
            }
        }

        return view('course.dshocvien', ['users' => $students]);
    }


    public function removestudent(Request $request)
    {
        $sid = $request->input('sid');
        $cid = $request->input('cid');

        $result = DB::table('lop_hocvien')
            ->where('lop_id', $cid)
            ->where('user_id', $sid)
            ->delete();

        if($result) $request->session()->flash('message', "Đã xóa học viên ra khỏi lớp học.");
        else $request->session()->flash('message', "Không thể xóa học viên khỏi lớp học.");

        return back()->withInput();
    }
    public function removeCourse(Request $request)
    {
        $cid = $request->input('cid');

        $result = DB::table('course')
            ->where('id', $cid)
            ->delete();

        if($result) $request->session()->flash('message', "Xóa thành công khóa đào tạo");
        else $request->session()->flash('message', "Không thể xóa khóa đào tạo");

        return back()->withInput();
    }

    public function getContents (Request $request){
        $cid = $request->input('cid');
        $rs = MoodleRest::call(MoodleRest::METHOD_GET, "core_course_get_contents", array("courseid" => $cid));
        var_dump(json_decode($rs)); die;
    }

    public function createCourse(Request $request){
        $cate = DB::table('course_categories')->orderBy('id', 'ASC')->select("id", "name")->get();
        if($request->isMethod('get')){
            return view('course.create', ['cate' => $cate]);
        }

        else if ($request->isMethod('post')) {
            $fullname = $request->fullname;
            $shortname = 'DT' . date('ymdhis');
            $categoryid = $request->categoryid;
            $summary = (isset($request->summary))?$request->summary:"";
            $doituong = (isset($request->doi_tuong))?$request->doi_tuong:"";
            $thoigian = (isset($request->thoi_gian))?$request->thoi_gian:"";
            $params = array(
                "courses[0][fullname]" => $fullname,
                "courses[0][shortname]" => $shortname,
                "courses[0][categoryid]" => $categoryid,
                "courses[0][summary]" => $summary,
                "courses[0][format]" => "topics",
            );
            $rs = MoodleRest::call(MoodleRest::METHOD_POST, "core_course_create_courses", $params);
            $result = json_decode($rs);
            if (isset($result->errorcode)) {
                $request->session()->flash('message', "Có lỗi : " . $result->message);
                return view('course.create', ['cate' => $cate]);
            } else {
//                dd($result);
                $id = intval($result[0]->id);
                DB::table('course')->where('id', $id)
                    ->update(['doi_tuong' => $doituong, 'thoi_gian' => $thoigian]);
                $request->session()->flash('message', "Cập nhật thành công.");
            }

            return redirect()->action(
                'CourseController@index', ['c' => $request->input('categoryid')]
            );
        }
    }

}