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
class ClassController extends Controller
{
    public function index(Request $request){
        $course = DB::table('class')->get();
        return view('class.index', ['class'=>$course]);
    }

    public function edit(Request $request){
        $courseId = intval($request->id);
        $course = DB::table('course')->where('id', $courseId)->first();
        return view('course.edit', ['course'=>$course]);
    }
    public function update(Request $request)
    {
        $id = intval( $request->input('id') );
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
    }

    /**
     * Danh sach hoc vien cua mot lop
     * @param Request $request
     */
    public function danhsach(Request $request){
        $classId = intval($request->cid);
        $objects = DB::table('lop_hocvien')
            ->where('lop_id', $classId)
            ->select('user_id')
            ->get();

        $users = array();
        if(!is_null($objects)){
            foreach ($objects as $object){
                $userIds[] = $object->user_id;
            }
            $users = DB::table('user')
                ->whereIn('id', $userIds)
                ->select('id', 'username', 'firstname', 'lastname', 'email', 'description')
                ->get();
        }

        return view('class.danhsach',['users' => $users]);
    }
    public function xeploaihv(Request $request){
        $classId = intval($request->cid);
        $userId = intval($request->uid);
        $lhv = DB::table('lop_hocvien')->where('lop_id', $classId)->where('user_id', $userId)->first();
        $xeploai = DB::table('xeploai')->get();

        if(!is_null($lhv)) {
            $lhv = DB::table('lop_hocvien')->where('lop_id', $classId)->where('user_id', $userId)->first();
            $xeploai = DB::table('xeploai')->get();

            return view('class.capnhathocvien', ['lhv'=>$lhv, 'xeploai'=>$xeploai]);
        } else {
            $request->session()->flash('message', "Lớp học hoặc học viên không tồn tại");
            return redirect()->action('CourseController@index');
        }
    }

    public function capnhathocvien(Request $request){
        $cid = intval($request->cid);
        $uid = intval($request->uid);

        $messages = [
            'grade.numeric' => 'Điểm phải là số',
        ];
        $validator = Validator::make($request->all(), [
            'grade' => 'numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->action('ClassController@xeploaihv',["cid"=>$cid, 'uid'=>$uid])
                ->withErrors($validator)
                ->withInput();
        }

        $result = DB::table('lop_hocvien')
            ->where('lop_id', $cid)
            ->where('user_id', $uid)
            ->update([
                'grade'=>$request->input('grade'),
                'status'=>$request->input('status'),
                'xeploai'=>$request->input('xeploai'),
            ]);

        if($result) {
            $request->session()->flash('message', "Cập nhật thành công.");
        } else {
            $request->session()->flash('message', "Cập nhật không thành công.");
        }

        return redirect()->action(
            'ClassController@xeploaihv', ["cid"=>$cid, 'uid'=>$uid]
        );

    }

}