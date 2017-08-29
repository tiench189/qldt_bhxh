<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/20/2017
 * Time: 3:13 PM
 */

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Settings;

use App\MoodleRest;


class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $pcat = intval($request->c);

        $select_parrent = DB::table('course_categories')->where('parent', '=', 1)->get();
        $parents = array();
        $pids = array();
        foreach ($select_parrent as $row) {
            $parents[$row->id] = $row;
            $pids[] = $row->id;
        }

        if ($pcat > 0) {
            $category = DB::table('course_categories')->where('parent', '=', $pcat)->get();
            $catinfo = DB::table('course_categories')->where('id', $pcat)->first();

        } else {
            $category = DB::table('course_categories')->whereIn('parent', $pids)->get();
            $catinfo = [];
        }

        $output = ['category' => $category, 'parents' => $parents, 'catinfo' => $catinfo];
//        return response()->json($output);
        return view('category.index', $output);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            $parents = DB::table('course_categories')->where('parent', '=', 1)->get();
            return view('category.create', ['parents' => $parents]);
        }

        if ($request->isMethod('post')) {
            $description = $request->description;
            if (!isset($description)) $description = $request->name;

            try {
                $result = DB::table('course_categories')
                    ->insert([
                        'name' => $request->name,
                        'description' => $request->description,
                        'parent' => $request->parent,
                    ]);
            } catch (Exception $e) {
                $request->session()->flash('message', "Có lỗi phát sinh: Không thể thêm Danh mục");
            }


            if (!$result) {
                $request->session()->flash('message', "Có lỗi phát sinh: Không thể thêm Danh mục");
            } else {
                $request->session()->flash('message', "Cập nhật danh mục mới thành công.");
            }

            return redirect()->action(
                'CategoryController@index'
            );
        }
    }

    public function update(Request $request)
    {
        $id = intval($request->input('id'));
        $category = DB::table('course_categories')->where('id', $id)->first();
        if (!$category) {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CategoryController@index');
        }

        if ($request->isMethod('get')) {
            $parents = DB::table('course_categories')->where('parent', '=', 1)->get();
            return view('category.update', ['category' => $category, 'parents' => $parents]);
        } else {
            try {
                $result = DB::table('course_categories')
                    ->where('id', $id)
                    ->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'parent' => $request->parent,
                    ]);
            } catch (Exception $e) {
                $request->session()->flash('message', "Có lỗi phát sinh: Không thể cập nhật Danh mục");
            }


            if (!$result) {
                $request->session()->flash('message', "Có lỗi phát sinh: Không thể cập nhật Danh mục");
            } else {
                $request->session()->flash('message', "Cập nhật danh mục thành công.");
            }

            return redirect()->action(
                'CategoryController@index'
            );
        }
    }

    public function remove(Request $request)
    {

        $result = DB::table('course_categories')
            ->where('id', $request->id)
            ->delete();

        if (!$result) {
            $request->session()->flash('message', "Không thể xóa danh mục đào tạo");
        } else {
            $request->session()->flash('message', "Xóa thành công danh mục đào tạo");
        }

        return back()->withInput();
    }

    public function danhsachhocvien(Request $request){
        $id = intval($request->input('id'));
        $users = array();
        // Danh sach cac course
        $courses = DB::table('course')->where('category', $id)->get();
        foreach ($courses as $course) {
            $courseIds[] = $course->id;
        }

        if(count($courses) == 0) return view('category.danhsachhocvien', ['users' => $users]);
        // Danh sach cac lop
        $classes = DB::table('lop')
            ->whereIn('course_id', $courseIds)
            ->select('*')
            ->get();

        if(count($classes) == 0) return view('category.danhsachhocvien', ['users' => $users]);
        foreach ($classes as $class) {
            $classIds[] = $class->id;
        }

        //Lay danh sach ket qua
        $allResult = DB::table('lop_hocvien')
            ->join('lop', 'lop.id', '=', 'lop_hocvien.lop_id')
            ->whereIn('lop.id', $classIds)
            ->select('lop.ten_lop as ten_lop', 'lop.course_id as course_id', 'lop_hocvien.*')
            ->get();

        //Lay thong tin hoc vien
        $uid = array();
        foreach ($allResult as $row) {
            $uid[] = $row->user_id;
        }
        $dataUser = DB::table('person')
            ->where('type', 'student')
            ->whereIn('id', $uid)
            ->select('id', 'username', 'email', 'firstname', 'lastname', 'donvi', 'sex', 'chucdanh', 'chucvu')
            ->get();

        $users = \App\Utils::row2Array($dataUser);

        //Lay thong tin don vi
        $datadonvi = DB::table('donvi')
            ->get();
        $donvi = \App\Utils::row2Array($datadonvi);

        //var_dump($users); die;

        return view('category.danhsachhocvien', ['users' => $users, 'donvi' => $donvi]);
    }

}