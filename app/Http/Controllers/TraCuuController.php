<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/27/2017
 * Time: 10:10 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraCuuController extends Controller
{
    public function index(Request $request){

        $courses = DB::table('course')
            ->select('id', 'fullname')
            ->get();

        $output = ['courses' => $courses];
        return view('tracuu.index', $output);
    }
}