<?php

namespace App\Http\Controllers;

use app\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function tonghop(Request $request)
    {
        $output = array();
        $start = $request->start;
        $end = $request->end;
        $dataReport = array();
        if (isset($start) || isset($end)) {
            $output['start'] = $start;
            $output['end'] = $end;
            $dataReport = \App\Utils::getReportTotal($start, $end);
        }

        //Xeploai
        $dataXeploai = DB::table('xeploai')->get();
        $dictXeploai = \App\Utils::row2Array($dataXeploai);
        $output['data'] = $dataReport;
        $output['xeploai'] = $dictXeploai;
//        return response()->json($output);
        return view('baocao.tonghop', $output);
    }

    public function downloadTonghop(Request $request){
        $start = $request->start;
        $end = $request->end;
        $dataReport = \App\Utils::getReportTotal($start, $end);
        $fileDowwnload = \App\Utils::writeReport($dataReport);
        return redirect($fileDowwnload);
    }
}
