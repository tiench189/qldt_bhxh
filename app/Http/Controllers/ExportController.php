<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;

class ExportController extends BaseController
{
    public function export_score(Request $request)
    {
        $class_id = $request->class_id;

        //Lấy thông tin lớp
        $class = DB::table('lop')->where('id', $class_id)->first();

        //Lay danh sach ket qua
        $allResult = DB::table('lop_hocvien')
            ->join('lop', 'lop.id', '=', 'lop_hocvien.lop_id')
            ->where('lop.id', '=', $class_id)
            ->select('lop.ten_lop as ten_lop', 'lop.course_id as course_id', 'lop_hocvien.*')
            ->get();

        $uid = array();
        foreach ($allResult as $row) {
            $uid[] = $row->user_id;
        }
        $dataUser = DB::table('person')
            ->where('type', 'student')
            ->whereIn('id', $uid)
            ->select('id', 'username', 'email', 'firstname', 'lastname', 'donvi', 'birthday')
            ->get();

        $users = \App\Utils::row2Array($dataUser);

        // Lấy toàn bộ danh sách học viên
        $allUser = DB::table('person')
            ->where('type', 'student')
            ->select('id', 'username', 'email', 'firstname', 'lastname', 'donvi', 'birthday')
            ->get();
        foreach ($allUser as $u) {
            $dduser[$u->id] = $u->firstname . " " . $u->lastname . " (" . $u->username . ")";
        }

        //Lay thong tin xep loai
        $dataXeploai = DB::table('xeploai')->get();
        $xeploai = \App\Utils::row2Array($dataXeploai);
        $ddlxeploai = [];
        foreach ($dataXeploai as $x) {
            $ddlxeploai[$x->id] = $x->name;
        }
        $crow = 6;
        foreach ($allResult as $idx => $row) {

        }

        /*----------------------------------------------------------*/
        $no_qualified = 0;
        $no_total = 0;

        $fileName = base_path() . '/public/template/ketquahoctap.xlsx';
        $excelobj = \PHPExcel_IOFactory::load($fileName);
        $excelobj->setActiveSheetIndex(0);
        $excelobj->getActiveSheet()->toArray(null, true, true, true);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $crow = 6;

        foreach ($allResult as $idx => $row) {
            $no_total += 1;
            if (!isset($xeploai[$row->xeploai])) {
                continue;
            }

            if ($row->xeploai == 22) {
                continue;
            }

            $no_qualified += 1;

            $birthday = \DateTime::createFromFormat('Y-m-d H:i:s', $users[$row->user_id]->birthday);

            $excelobj->getActiveSheet()->setCellValue('A' . $crow, $idx + 1);
            $excelobj->getActiveSheet()->setCellValue('B' . $crow, $users[$row->user_id]->firstname . ' ' . $users[$row->user_id]->lastname);
            $excelobj->getActiveSheet()->setCellValue('C' . $crow, $birthday->format('d'));
            $excelobj->getActiveSheet()->setCellValue('D' . $crow, $birthday->format('m'));
            $excelobj->getActiveSheet()->setCellValue('E' . $crow, $birthday->format('Y'));
            $excelobj->getActiveSheet()->setCellValue('F' . $crow, $row->grade);
            $excelobj->getActiveSheet()->setCellValue('G' . $crow, $xeploai[$row->xeploai]->name);

            $crow++;
        }

        $excelobj->getActiveSheet()->setCellValue('C1', $no_qualified . '/' . $no_total . ' học viên được cấp chứng chỉ.');

        $excelobj->getActiveSheet()->getStyle('A6:G' . ($crow - 1))->applyFromArray($styleArray);

        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2007");
        $output_file = "/ketquahoctap/$class_id-" . date("dmyhis") . ".xlsx";
        $objWriter->save(base_path() . "/public" . $output_file);
        return redirect($output_file);
    }
}
