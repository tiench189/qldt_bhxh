<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/21/2017
 * Time: 2:56 PM
 */

namespace app;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;

class Utils extends Model
{
    public static function listCategories()
    {
        return DB::table('course_categories')
            ->orderBy('sortorder', 'asc')
            ->get();
    }

    public static function row2Array($rows)
    {
        $arr = array();
        foreach ($rows as $r) {
            $arr[$r->id] = $r;
        }
        return $arr;
    }

    public static function formatTimestamp($time)
    {
        if ($time == null) return '';
        return date('d/m/Y', strtotime($time));
    }


    public static function toTimeFormat($time)
    {
        if ($time == null || $time == 0) return '';
//        return date('d/m/Y', $time);
        return (new \DateTime($time))->format('d/m/Y');
    }


    public static function getStatus($status)
    {
        $dict = array();
        $dict['finished'] = 'Hoàn thành';
        $dict['inprogress'] = 'Đang học';
        if (!array_key_exists($status, $dict)) return '';
        return $dict[$status];
    }

    public static function parseSessID($xml)
    {
        $openTag = '<samlp:SessionIndex>';
        $closeTag = '</samlp:SessionIndex>';

        $start = strpos($xml, $openTag);
        $end = strpos($xml, $closeTag);
        $sessID = substr($xml, $start + strlen($openTag), $end - $start - strlen($openTag));
        return $sessID;
    }

    public static function writeReport($data)
    {
        $xeploai = DB::table('xeploai')->get();
        $mapcol = ['G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];

        $fileName = base_path() . '/public/template/baocaotonghop.xlsx';
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
        $crow = 5;
        foreach ($data as $year => $rowYear) {
            $excelobj->getActiveSheet()->mergeCells('A' . $crow . ':C' . $crow);
            $excelobj->getActiveSheet()->mergeCells('F' . $crow . ':M' . $crow);
            $excelobj->getActiveSheet()->setCellValue('A' . $crow, 'Năm ' . $year);
            $excelobj->getActiveSheet()->getStyle('A' . $crow . ':M' . $crow)->getFont()->setBold(true);
            $crow++;
            $idx = 0;
            foreach ($rowYear['course'] as $course) {
                $idx++;
                $excelobj->getActiveSheet()->setCellValue('A' . $crow, $idx);
                $excelobj->getActiveSheet()->setCellValue('B' . $crow, $course['fullname']);
                $excelobj->getActiveSheet()->setCellValue('C' . $crow, $course['doi_tuong']);
                $excelobj->getActiveSheet()->setCellValue('D' . $crow, $course['so_lop']);
                $excelobj->getActiveSheet()->setCellValue('E' . $crow, $course['thoi_gian']);
                foreach ($xeploai as $idxXL => $xl) {
                    if (array_key_exists($xl->id, $course)) {
                        $excelobj->getActiveSheet()->setCellValue($mapcol[$idxXL] . $crow, round($course[$xl->id] * 100 / $course['so_hv']) . '%');
                    }
                }
                $crow++;
            }
        }
        $excelobj->getActiveSheet()->getStyle('A5:M' . ($crow - 1))->applyFromArray($styleArray);

        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2007");
        $output_file = "/baocao/BaoCaoTongHop-" . date("dmyhis") . ".xlsx";
        $objWriter->save(base_path() . "/public" . $output_file);
        return $output_file;
    }

    public static function getReportTotal($start, $end)
    {
        $dataReport = array();
        if (isset($start) || isset($end)) {
            $output['start'] = $start;
            $output['end'] = $end;
            $dataSelect = DB::select(
                'SELECT "TO_CHAR"(ml.TIME_START, \'YYYY\') AS NAM, ml.COURSE_ID, mlh.XEPLOAI, COUNT (mlh.ID) AS count, ml.ID
                FROM M_LOP ml 
                LEFT JOIN M_LOP_HOCVIEN mlh
                ON ml."ID" = mlh.LOP_ID
                WHERE mlh.STATUS LIKE \'finished\'
                AND "TO_CHAR"(ml.TIME_START, \'YYYY\') >= ?
                AND "TO_CHAR"(ml.TIME_START, \'YYYY\') <= ?
                GROUP BY "TO_CHAR"(ml.TIME_START, \'YYYY\'), mlh.XEPLOAI, ml.COURSE_ID, ml.ID
                ORDER BY "TO_CHAR"(ml.TIME_START, \'YYYY\'), ml.COURSE_ID',
                [$start, $end]);


            $courseIdArr = array();
            foreach ($dataSelect as $row) {
                if (!isset($dataReport[$row->nam])) $dataReport[$row->nam] = array();
                if (!isset($dataReport[$row->nam]['course'])) $dataReport[$row->nam]['course'] = array();
                if (!isset($dataReport[$row->nam]['course'][$row->course_id])) $dataReport[$row->nam]['course'][$row->course_id] = array();
                if (!isset($dataReport[$row->nam]['course'][$row->course_id]['so_lop'])) $dataReport[$row->nam]['course'][$row->course_id]['so_lop'] = 0;
                $dataReport[$row->nam]['course'][$row->course_id]['so_lop']++;
                if (!isset($dataReport[$row->nam]['course'][$row->course_id]['so_hv'])) $dataReport[$row->nam]['course'][$row->course_id]['so_hv'] = 0;
                $dataReport[$row->nam]['course'][$row->course_id]['so_hv'] += $row->count;
                if (!isset($dataReport[$row->nam]['course'][$row->course_id][$row->xeploai])) $dataReport[$row->nam]['course'][$row->course_id][$row->xeploai] = 0;
                $dataReport[$row->nam]['course'][$row->course_id][$row->xeploai] += $row->count;
                // Tính tổng
                if (!isset($dataReport[$row->nam]['so_lop'])) $dataReport[$row->nam]['so_lop'] = 0;
                $dataReport[$row->nam]['so_lop']++;
                if (!isset($dataReport[$row->nam]['so_hv'])) $dataReport[$row->nam]['so_hv'] = 0;
                $dataReport[$row->nam]['so_hv'] += $row->count;
                // Lấy ID
                if (!in_array($row->course_id, $courseIdArr)) $courseIdArr[] = $row->course_id;
            }

            $dataCourse = DB::table('course')
                ->whereIn('id', $courseIdArr)
                ->select('id', 'fullname', 'doi_tuong', 'thoi_gian')
                ->get();
            $dictCourse = self::row2Array($dataCourse);

            foreach ($dataReport as $year => $rowYear) {
                foreach ($rowYear['course'] as $course => $rowCourse) {
                    if (array_key_exists($course, $dictCourse))
                        $dataReport[$year]['course'][$course]['fullname'] = $dictCourse[$course]->fullname;
                    $dataReport[$year]['course'][$course]['doi_tuong'] = $dictCourse[$course]->doi_tuong;
                    $dataReport[$year]['course'][$course]['thoi_gian'] = $dictCourse[$course]->thoi_gian;
                }
            }
        }
        return $dataReport;
    }

}