<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/20/2017
 * Time: 3:13 PM
 */

namespace App\Http\Controllers;


use App\Donvi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Settings;

use App\MoodleRest;


class DonviController extends Controller
{
    public function index(Request $request)
    {
        $donvi = Donvi::all();
        return view('donvi.index', ['donvi' => $donvi]);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            $listdonvi = DB::table('donvi')->orderBy('id')->get();
            return view('donvi.add', ['listdonvi' => $listdonvi]);
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

    public function edit(Request $request)
    {
        $courseId = intval($request->id);
        if ($courseId > 0) {
            $course = DB::table('course')->where('id', $courseId)->first();
            $cate = DB::table('course_categories')->orderBy('id', 'asc')->get();
            $categories = array();
            foreach ($cate as $row) {
                $categories[$row->id] = $row->name;
            }
            return view('course.edit', ['course' => $course, 'categories' => $categories]);
        } else {
            $request->session()->flash('message', "ID Khóa học không hợp lệ.");
            return redirect()->action('CourseController@index');
        }
    }

    public function update(Request $request)
    {
        if ($request->isMethod('get')) {
            $id = intval($request->id);
            if ($id > 0) {
                $donvi = DB::table('donvi')->where('id', $id)->first();
                $listdonvi = DB::table('donvi')->get();

                return view('donvi.add', ['donvi' => $donvi, 'listdonvi' => $listdonvi]);
            } else {
                $request->session()->flash('message', "ID Khóa học không hợp lệ.");
                return redirect()->action('DonviController@index');
            }
        } else {
            $id = intval($request->input('id'));
            if ($id > 0) {
                $messages = [
                    'ten_donvi.required' => 'Yêu cầu nhập tên đơn vị.',
                    'ten_donvi.unique' => 'Tên đơn vị đã tồn tại.',
                    'ma_donvi.required' => 'Yêu cầu nhập mã đơn vị.',
                    'ma_donvi.unique' => 'Mã đơn vị đã tồn tại.',
                    'cap_donvi.required' => 'Yêu cầu nhập cấp đơn vị.',
                ];
                $validator = Validator::make($request->all(), [
                    'cap_donvi' => 'required',
                    'ten_donvi' => 'required|unique:donvi,ten_donvi,' . $id,
                    'ma_donvi' => 'required|unique:donvi,ma_donvi,' . $id,
                ], $messages);

                if ($validator->fails()) {
                    return redirect()->action('DonviController@update', ["id" => $id])
                        ->withErrors($validator)
                        ->withInput();
                }
                $result = DB::table('donvi')
                    ->where('id', $id)
                    ->update([
                        'ten_donvi' => $request->input('ten_donvi'),
                        'ma_donvi' => $request->input('ma_donvi'),
                        'cap_donvi' => $request->input('cap_donvi'),
                        'ma_truc_thuoc' => $request->input('ma_truc_thuoc')
                    ]);

                if ($result) {
                    $request->session()->flash('message', "Cập nhật thành công.");
                } else {
                    $request->session()->flash('message', "Cập nhật không thành công.");
                }

                return redirect()->action(
                    'DonviController@index', ['update' => $result]
                );
            } else {
                $request->session()->flash('message', "ID Khóa học không tồn tại hoặc đã bị xóa.");
                return redirect()->action('DonviController@index');
            }
        }

    }

    public function remove(Request $request)
    {
        $id = intval($request->id);
        DB::table('donvi')->where('id', $id)->delete();
        $request->session()->flash('message', 'Xóa đơn vị thành công');
        return redirect(route('donvi-index'));
    }


}