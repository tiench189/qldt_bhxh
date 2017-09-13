<?php
/**
 * Created by PhpStorm.
 * User: motbit
 * Date: 09/08/2017
 * Time: 1:13 PM
 */

namespace App\Http\Controllers;

use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class KhaosatController extends Controller
{
    public function index(Request $request){
        $khaosat = DB::table('khaosat')->get();


        // Lấy thông tin toàn bộ lớp
        $ddclass = [];
        $dataClass = DB::table('lop')->get();
        foreach ($dataClass as $c) {
            $ddclass[$c->id] = $c->ten_lop;
        }
        // Lấy thông tin toàn bộ khóa
        $ddcourse = [];
        $dataCourse = DB::table('course')->get();
        foreach ($dataCourse as $c) {
            $ddcourse[$c->id] = $c->fullname;
        }

        return view('khaosat.index',['khaosat'=>$khaosat,'ddcourse'=>$ddcourse,'ddclass'=>$ddclass]);
    }
    public function create(Request $request){
        if ($request->isMethod('get')) {
            $course = DB::table('course')->orderBy('id')->get();
            $class = DB::table('lop')->orderBy('id')->get();
            return view('khaosat.add', ['course' => $course,'class' => $class]);
        }
        if ($request->isMethod('post')) {
            $data = array();
            $data['course'] = $request->course;
            $data['class'] = $request->class;
            $data['title'] = $request->title;
            $data['created_at'] = date('Y-m-d H:i:s');

            $messages = [
                'title.required' => 'Yêu cầu nhập nội dung khảo sát',
            ];
            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('KhaosatController@create')
                    ->withErrors($validator)
                    ->withInput();
            }
            $khaosat_id = DB::table('khaosat')->insertGetId($data);
            if ($khaosat_id > 0) {
                $request->session()->flash('message', 'Thêm phiếu khảo sát thành công');
                return redirect(route('khaosat-update',["id"=>$khaosat_id]));
            } else {
                $request->session()->flash('message', 'Thêm phiếu khảo sát thất bại: ');
                return redirect(route('khaosat-add'));
            }

        }
    }


    public function themchuyende(Request $request){

        if ($request->isMethod('post')) {

            $khaosat_id = isset($request->khaosat_id) ? intval($request->khaosat_id) : 0;
            $chuyende_id = isset($request->chuyende_id) ? intval($request->chuyende_id) : 0;



            $messages = [
                'chuyende_noidung.required' => 'Yêu cầu nhập nội dung chuyên đề',
            ];
            $validator = Validator::make($request->all(), [
                'chuyende_noidung' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('KhaosatController@update',["id"=>$khaosat_id])
                    ->withErrors($validator)
                    ->withInput();
            }

            if($chuyende_id > 0) {
                $data['noi_dung'] = $request->chuyende_noidung;
                $data['updated_at'] = date('Y-m-d H:i:s');
                $result = DB::table('khaosat_chuyende')->where('id', $chuyende_id)->update($data);
            } else {
                $data = array();
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['khaosat_id'] = $khaosat_id;
                $data['noi_dung'] = $request->chuyende_noidung;
                $result = DB::table('khaosat_chuyende')->insert($data);
            }


            if ($result > 0) {
                $request->session()->flash('message', (($chuyende_id > 0) ? "Cập nhật":"Thêm") . ' phiếu khảo sát thành công');
            } else {
                $request->session()->flash('message', (($chuyende_id > 0) ? "Cập nhật":"Thêm") . ' phiếu khảo sát thất bại: ');
            }
            return redirect(route('khaosat-update',["id"=>$khaosat_id]));

        }
    }



    public function update(Request $request){
        if ($request->isMethod('get')) {
            $khaosat_id = intval($request->id);
            $khaosat = DB::table('khaosat')->where('id',$khaosat_id)->get()->first();
            $khaosat_chuyende = DB::table('khaosat_chuyende')->where('khaosat_id',$khaosat_id)->get();
            return view('khaosat.update', ['khaosat' => $khaosat,'khaosat_chuyende' => $khaosat_chuyende]);
        }
    }

    public function update_chuyende(Request $request){
        if ($request->isMethod('get')) {
            $chuyende_id = intval($request->id);
            $khaosat_chuyende = DB::table('khaosat_chuyende')->where('id',$chuyende_id)->get()->first();
            return response()->json($khaosat_chuyende);
        }
    }

    public function xoachuyende(Request $request)
    {
        $chuyendeid = intval($request->chuyendeid);
        $khaosat_chuyende = DB::table('khaosat_chuyende')->where('id',$chuyendeid)->get()->first();
        $khaosatid = $khaosat_chuyende->khaosat_id;
        DB::table('khaosat_chuyende')->where('id', $chuyendeid)->delete();
        $request->session()->flash('message', 'Xóa chuyên đề thành công!');
        return redirect(route('khaosat-update',["id"=>$khaosatid]));
    }
    public function remove(Request $request){
    }
}