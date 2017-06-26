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

}