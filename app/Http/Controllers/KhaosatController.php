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
        return view('khaosat.index',['khaosat'=>$khaosat]);
    }
    public function create(Request $request){
        if ($request->isMethod('get')) {
            $course = DB::table('course')->orderBy('id')->get();
            $class = DB::table('lop')->orderBy('id')->get();
            return view('khaosat.add', ['course' => $course,'class' => $class]);
        }
        if ($request->isMethod('post')) {
            $data = array();
            $data['cap_donvi'] = $request->cap_donvi;
            $data['ten_donvi'] = $request->ten_donvi;
            $data['ma_donvi'] = $request->ma_donvi;
            $data['ma_truc_thuoc'] = $request->ma_truc_thuoc;

            $messages = [
                'ten_donvi.required' => 'Yêu cầu nhập tên đơn vị.',
                'ten_donvi.unique' => 'Tên đơn vị đã tồn tại.',
                'ma_donvi.required' => 'Yêu cầu nhập mã đơn vị.',
                'ma_donvi.unique' => 'Mã đơn vị đã tồn tại.',
                'cap_donvi.required' => 'Yêu cầu nhập cấp đơn vị.',
            ];
            $validator = Validator::make($request->all(), [
                'cap_donvi' => 'required',
                'ten_donvi' => 'required|unique:donvi',
                'ma_donvi' => 'required|unique:donvi',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('DonviController@add')
                    ->withErrors($validator)
                    ->withInput();
            }
            $result = DB::table('donvi')->insert($data);
            if ($result) {
                $request->session()->flash('message', 'Thêm đơn vị thành công');
                return redirect(route('donvi-index'));
            } else {
                $request->session()->flash('message', 'Thêm đơn vị thất bại: ');
                return redirect(route('donvi-add'));
            }

        }
    }
    public function update(Request $request){
    }
    public function remove(Request $request){
    }
}