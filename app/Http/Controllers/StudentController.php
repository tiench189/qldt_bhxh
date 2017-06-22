<?php
/**
 * Created by PhpStorm.
 * User: go
 * Date: 6/21/2017
 * Time: 10:20 AM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request){
        $users = DB::table('user')->get();
        return view('student.index', ['users'=>$users]);
    }
}