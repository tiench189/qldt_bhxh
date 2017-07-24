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

        $category =  DB::table('course_categories')->where('parent', '=', 1)->get();
        return view('category.index', ['category' => $category]);
    }

    public function create(Request $request){
        if($request->isMethod('get')){
            return view('category.create');
        }

        if($request->isMethod('post')){
            $params = array(
                "categories[0][name]" => $request->name,
                "categories[0][description]" => $request->description,
                "categories[0][parent]" => 1
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
            return view('category.create', ['category' => $category]);
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