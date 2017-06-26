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
class CourseController extends Controller
{
    public function index(Request $request){
        $course = DB::table('course')->get();
        return view('course.index', ['course'=>$course]);
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


    // Danh sach lop

    public function classindex(Request $request){
        $courseId = intval($request->c);

        if($courseId > 0 ) {
            //Lay thong tin khoa hoc
            $course = DB::table('course')->where('id', $courseId)->first();
            // lay thong tin lop
            $class = DB::table('lop')->where('course_id', $courseId)->get();
            return view('course.classindex', ['class'=>$class,'course' => $course]);
        } else {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CourseController@index');
        }
    }
}