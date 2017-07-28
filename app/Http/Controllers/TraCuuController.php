<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/27/2017
 * Time: 10:10 AM
 */

namespace App\Http\Controllers;

use App\Utils;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraCuuController extends Controller
{
    public function index(Request $request)
    {

    }

    public function donvi(Request $request)
    {
        $courses = DB::table('course')
            ->select('id', 'fullname')
            ->get();

        $donvi = array();

        if ($request->isMethod('post')) {
            $cid = $request->input('course');
            $year = $request->input('year');
            $status = $request->input('status');

//            $class = DB::table('lop')
//                ->where('course_id', $cid)
//                ->select('id', 'to_char(time_start, \'yyyy\')')
//                ->get();
            $class = DB::select("select ID, TO_CHAR(TIME_START, 'YYYY') AS START_YEAR from M_LOP where COURSE_ID = ?", [$cid]);
            if (count($class) > 0) {
                $classIds = array();
                foreach ($class as $item) {
                    if (!isset($year) || $year == $item->start_year)
                        $classIds[] = $item->id;
                }
                $lhv = DB::table('lop_hocvien')
                    ->whereIn('lop_id', $classIds)
                    ->select('*')
                    ->get();
                $userIds = array();
                foreach ($lhv as $item) {
                    $userIds[] = $item->user_id;
                }

                $users = DB::table('person')
                    ->whereIn('id', $userIds)
                    ->select('id', 'donvi')
                    ->get();
                $donviIds = array();
                if (!$users->isEmpty()) {
                    foreach ($users as $item) {
                        $donviIds[] = $item->donvi;
                    }
                }

                // Cac don vi da dao tao
                $donvidaotao = DB::table('donvi')
                    ->wherein('id', $donviIds)
                    ->select("*")
                    ->get();

                if ($status == 1) {
                    $donvi = $donvidaotao;
                } else {
                    // Cac don vi chua dao tao
                    $dvdtIds = array();
                    if (!$donvidaotao->isEmpty()) {
                        foreach ($donvidaotao as $item) {
                            $dvdtIds[] = $item->id;
                        }
                    }
                    $donvichuadaotao = DB::table('donvi')
                        ->whereNotIn('id', $dvdtIds)
                        ->select("*")
                        ->get();

                    $donvi = $donvichuadaotao;
                }

                return view('tracuu.donvi', ['courses' => $courses, 'donvi' => $donvi, 'cid' => $cid, 'year' => $year, 'status' => $status]);
            }
            if ($status == 0) {
                // chua dao tao
                $donvi = DB::table('donvi')
                    ->select("*")
                    ->get();
            }

            return view('tracuu.donvi', ['courses' => $courses, 'donvi' => $donvi, 'cid' => $cid, 'year' => $year, 'status' => $status]);
        } else {
            $output = ['courses' => $courses, 'donvi' => $donvi];
            return view('tracuu.donvi', $output);
        }
    }


}