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


class CategoryController extends Controller
{

    public function index(Request $request){

        $pcat = intval($request->c);

        $select_parrent = DB::table('course_categories')->where('parent', '=', 1)->get();
        $parents = array();
        $pids = array();
        foreach ($select_parrent as $row){
            $parents[$row->id] = $row;
            $pids[] = $row->id;
        }

        if($pcat > 0) {
            $category =  DB::table('course_categories')->where('parent', '=', $pcat)->get();
            $catinfo = DB::table('course_categories')->where('id', $pcat)->first();

        } else {
            $category =  DB::table('course_categories')->whereIn('parent', $pids)->get();
            $catinfo = [];
        }

        $output = ['category' => $category, 'parents' => $parents,'catinfo' => $catinfo];
//        return response()->json($output);
        return view('category.index', $output);
    }

    public function create(Request $request){
        if($request->isMethod('get')){
            $parents = DB::table('course_categories')->where('parent', '=', 1)->get();
            return view('category.create', ['parents' => $parents]);
        }

        if($request->isMethod('post')){
            $description = $request->description;
            if(!isset($description)) $description = $request->name;
            $params = array(
                "categories[0][name]" => $request->name,
                "categories[0][description]" => $description,
                "categories[0][parent]" => $request->parent
            );

            $rs = MoodleRest::call(MoodleRest::METHOD_POST, "core_course_create_categories", $params);
            $result = json_decode($rs);

            if (is_null($result) || isset($result->errorcode)) {
                $request->session()->flash('message', "Có lỗi : " . $result->message);
            } else {
                $request->session()->flash('message', "Cập nhật thành công.");
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
        if(!$category){
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CategoryController@index');
        }

        if($request->isMethod('get')){
            $parents = DB::table('course_categories')->where('parent', '=', 1)->get();
            return view('category.update', ['category' => $category, 'parents' => $parents]);
        }else{
            $params = array(
                "categories[0][id]" => $id,
                "categories[0][name]" => $request->name,
                "categories[0][description]" => $request->description,
            );
            $rs = MoodleRest::call(MoodleRest::METHOD_POST, "core_course_update_categories", $params);
            $result = json_decode($rs);

            if (!is_null($result) && isset($result->errorcode)) {
                $request->session()->flash('message', "Có lỗi : " . $result->message);
            } else {
                $request->session()->flash('message', "Cập nhật thành công.");
            }

            return redirect()->action(
                'CategoryController@index'
            );
        }
    }

    public function remove(Request $request){

        $params = array(
            'categories[0][id]' => $request->id,
            'categories[0][recursive]' => 1 // delete all contents inside this category
        );
        $rs = MoodleRest::call(MoodleRest::METHOD_POST, "core_course_delete_categories", $params);
        $result = json_decode($rs);

        if(!is_null($result) && !empty($result->warnings)){
            $request->session()->flash('message', "Không thể xóa danh mục đào tạo");
        }else{
            $request->session()->flash('message', "Xóa thành công danh mục đào tạo");
        }

        return back()->withInput();
    }

}