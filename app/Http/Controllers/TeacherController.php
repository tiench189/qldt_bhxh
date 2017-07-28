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

class TeacherController extends Controller
{
    public function index(Request $request){
        $teachers = array();
        $objects = DB::table('role_assignments')->where('roleid', '=', 4)->select('userid')->get();
        if(!empty($objects)){
            foreach ($objects as $item){
                $ids[] = $item->userid;
            }
            $teachers = DB::table('person')
                ->whereIn('id', $ids)
                ->select('id', 'username', 'firstname', 'lastname', 'email', 'description')
                ->get();
        }
        return view('teacher.index',['teachers' => $teachers]);
    }

    public function edit(Request $request){
        $teacherId = intval($request->id);
        $teacher = DB::table('person')->where('id', $teacherId)->first();
        return view('teacher.edit', ['teacher'=>$teacher]);
    }

    public function update(Request $request)
    {
        $id = intval( $request->input('id') );
        $messages = [
            'username.required' => 'Yêu cầu nhập tên giáo viên',
            'username.unique' => 'Tên đăng nhập đã tồn tại.',
        ];
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:user,username,' . $id,
        ], $messages);

        if ($validator->fails()) {
            return redirect()->action('TeacherController@update',["id"=>$id])
                ->withErrors($validator)
                ->withInput();
        }

        $result = DB::table('person')
            ->where('id', $id)
            ->update([
                'username'=>$request->input('username'),
                'firstname'=>$request->input('firstname'),
                'lastname'=>$request->input('lastname'),
                'description'=>$request->input('description'),
                'timemodified'=>time(),
            ]);
        if($result) {
            $request->session()->flash('message', "Cập nhật thành công.");
        } else {
            $request->session()->flash('message', "Cập nhật không thành công.");
        }

        return redirect()->action(
            'TeacherController@index', ['update' => $result]
        );
    }



    public function danhsach(Request $request){
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
            $users = DB::table('person')
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
            if($item->roleid == 3 || $item->roleid == 4){ // editingteacher or teacher
                $teacherIds[] = $item->userid;
            }
        }

        $teachers = array();
        foreach ($users as $user){
            if(in_array($user->id, $teacherIds)){
                $teachers[] = $user;
            }
        }

        return view('teacher.danhsach',['teachers' => $teachers]);
    }

}