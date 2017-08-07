<?php
/**
 * Created by PhpStorm.
 * User: go
 * Date: 6/21/2017
 * Time: 10:20 AM
 */

namespace App\Http\Controllers;


use App\Person;
use App\Utils;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = [
            'type' => 'student'
        ];
        if ($request->has('donvi')) {
            $donvi = (int) $request->get('donvi');
            $query['donvi'] = $donvi;
        }

        $users = DB::table('person')->where($query)->get();

        //Lay thong tin don vi
        $iddv = array();
        foreach ($users as $row) {
            $iddv[] = $row->donvi;
        }
        $datadonvi = DB::table('donvi')
            ->whereIn('id', $iddv)
            ->get();
        $donvi = \App\Utils::row2Array($datadonvi);
        return view('student.index', ['users' => $users, 'donvi' => $donvi]);
    }

    public function histories(Request $request)
    {
        $uid = intval($request->u);

        $histories = DB::table('lop_hocvien')
            ->where('user_id', $uid)
            ->get();
        //Lay thong tin hoc vien
//        $user = DB::table('person')
//            ->where('id', $uid)
//            ->first();
        $user = Person::where('id', $uid)->first();

        //Lay thong tin lop va khoa hoc
        $lid = array();
        foreach ($histories as $row) {
            $lid[] = $row->lop_id;
        }
        $datalop = DB::table('lop')
            ->join('course', 'lop.course_id', '=', 'course.id')
            ->whereIn('lop.id', $lid)
            ->select('lop.id', 'lop.ten_lop', 'course.fullname as course_name', 'course.id as course_id')
            ->get();
        $lop = \App\Utils::row2Array($datalop);

        //Lay thong tin xep loai
        $dataXeploai = DB::table('xeploai')->get();
        $xeploai = \App\Utils::row2Array($dataXeploai);

        $output = ['user' => $user, 'histories' => $histories, 'lop' => $lop, 'xeploai' => $xeploai];
//        return response()->json($output);
        return view('student.histories', $output);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            $donvi = DB::table('donvi')->orderBy('id')->get();
            return view('student.add', ['donvi' => $donvi]);
        }
        $data = array();
        $data['firstname'] = $request->name;
        $data['lastname'] = '';
        $data['type'] = 'student';
        $data['email'] = $request->email;
        $data['donvi'] = $request->donvi;
        if (isset($request->birthday))
            $data['birthday'] = Utils::str2Date($request->birthday);
        if (isset($request->sex))
            $data['sex'] = $request->sex;
        if (isset($request->chucdanh))
            $data['chucdanh'] = $request->chucdanh;
        $result = Person::insert($data);
        if ($result['result']) {
            $request->session()->flash('message', 'Thêm học viên thành công');
            return redirect(route('hocvien-index'));
        }
        $request->session()->flash('message', 'Thêm học viên thất bại: ' . $result['mess']);
        return redirect(route('hocvien-add'));
    }

    public function update(Request $request)
    {
        $uid = intval($request->uid);
        if ($request->isMethod('get')) {
            $user = DB::table('person')->where('id', $uid)->first();
            $donvi = DB::table('donvi')->orderBy('id')->get();
            $donvi = Utils::row2Array($donvi);
//            return response()->json(['user' => $user, 'donvi' => $donvi]);
            return view('student.update', ['user' => $user, 'donvi' => $donvi]);
        }
        $data = array();
        $data['firstname'] = $request->name;
        $data['donvi'] = $request->donvi;
        if (isset($request->birthday))
            $data['birthday'] = Utils::str2Date($request->birthday);
        if (isset($request->sex))
            $data['sex'] = $request->sex;
        if (isset($request->chucdanh))
            $data['chucdanh'] = $request->chucdanh;
        if (isset($request->chucvu))
            $data['chucvu'] = $request->chucvu;
//        dd($data);
        DB::table('person')->where('id', $uid)->update($data);
        $request->session()->flash('message', 'Cập nhật thông tin học viên thành công');
        return redirect(route('hocvien-index'));
    }

    public function remove(Request $request)
    {
        $uid = intval($request->uid);
        DB::table('person')->where('id', $uid)->delete();
        $request->session()->flash('message', 'Xóa học viên thành công');
        return redirect(route('hocvien-index'));
    }
}