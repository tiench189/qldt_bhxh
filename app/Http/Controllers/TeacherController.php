<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/20/2017
 * Time: 3:13 PM
 */

namespace App\Http\Controllers;

use App\GiangVien;
use App\Person;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = [
            'type' => 'teacher'
        ];

        $teachers = Person::select('id', 'firstname', 'lastname', 'chucdanh', 'chucvu', 'donvi')
            ->where($query)->get();

        return view('teacher.index', ['teachers' => $teachers]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            $donvi = DB::table('donvi')->orderBy('id')->get();
            $data = [
                'donvi' => $donvi
            ];
            return view('teacher.add', $data);
        }

        if ($request->isMethod('post')) {
            DB::beginTransaction();

            try {
                $data = array();
                $data['firstname'] = $request->name;
                $data['lastname'] = '';
                $data['type'] = 'teacher';
                $data['email'] = $request->email;
                $data['donvi'] = $request->donvi;
                if (isset($request->birthday))
                    $data['birthday'] = Utils::str2Date($request->birthday);
                if (isset($request->sex))
                    $data['sex'] = $request->sex;
                if (isset($request->chucdanh))
                    $data['chucdanh'] = $request->chucdanh;
                if (isset($request->chucvu))
                    $data['chucvu'] = $request->chucvu;
                $teacher_id = Person::insertLastID($data);

                if ($teacher_id && isset($request->hocham) && isset($request->chuyennganh)) {
                    $giang_vien = new GiangVien();
                    $giang_vien->user_id = $teacher_id;
                    $giang_vien->hoc_ham = $request->hocham;
                    $giang_vien->chuyen_nganh = $request->chuyennganh;
                    $giang_vien->save();
                }

                DB::commit();
                $request->session()->flash('message', 'Thêm thông tin Giảng viên thành công');
                return redirect(route('teacher-index'));
            } catch (\Exception $e) {
                DB::rollBack();
                $request->session()->flash('message', 'Thêm thông tin Giảng viên thất bại: ' . $e->getMessage());
                return redirect(route('teacher-add'));
            }
        }
    }

    public function edit(Request $request)
    {
        $teacherId = intval($request->id);
        $teacher = Person::select('id', 'firstname', 'lastname', 'chucdanh', 'chucvu', 'donvi', 'email', 'birthday', 'sex')
            ->where('id', $teacherId)->first();
        $donvi = DB::table('donvi')->orderBy('id')->get();
        $data = [
            'donvi' => $donvi,
            'teacher' => $teacher
        ];
        return view('teacher.edit', $data);
    }

    public function update(Request $request)
    {
        $teacher_id = intval($request->input('teacher_id'));

        if ($request->isMethod('post')) {
            DB::beginTransaction();

            try {
                $data = array();
                $data['firstname'] = $request->name;
                $data['lastname'] = '';
                $data['email'] = $request->email;
                $data['donvi'] = $request->donvi;
                $data['timemodified'] = time();
                if (isset($request->birthday))
                    $data['birthday'] = Utils::str2Date($request->birthday);
                if (isset($request->sex))
                    $data['sex'] = $request->sex;
                if (isset($request->chucdanh))
                    $data['chucdanh'] = $request->chucdanh;
                if (isset($request->chucvu))
                    $data['chucvu'] = $request->chucvu;
                if (!array_key_exists('username', $data))
                    $data['username'] = $data['email'];

                Person::where('id', $teacher_id)->update($data);

                if (isset($request->hocham) && isset($request->chuyennganh)) {
                    $giangvien = [
                        'hoc_ham' => $request->hocham,
                        'chuyen_nganh' => $request->chuyennganh
                    ];

                    GiangVien::where('user_id', $teacher_id)->update($giangvien);
                }

                DB::commit();
                $request->session()->flash('message', 'Cập nhật thông tin Giảng viên thành công');
                return redirect(route('teacher-index'));
            } catch (\Exception $e) {
                DB::rollBack();
                $request->session()->flash('message', 'Cập nhật thông tin Giảng viên thất bại: ' . $e->getMessage());
                return redirect(route('teacher-update'));
            }
        }
    }

    public function remove(Request $request)
    {
        $uid = intval($request->uid);
        try {
            DB::beginTransaction();

            Person::where('id', $uid)->delete();
            GiangVien::where('user_id', $uid)->delete();

            DB::commit();
            $request->session()->flash('message', 'Xóa giảng viên thành công');
            return redirect(route('teacher-index'));
        } catch (\Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}