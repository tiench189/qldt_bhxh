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

class TeacherController extends Controller
{
    public function index(Request $request){

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

    public function create(){

    }

}