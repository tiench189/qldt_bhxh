<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    //
    public function index(Request $request){
        $groups = DB::table('group_permission')->orderBy('id', 'ASC')->get();
        return view('roles.index', ['groups' => $groups]);
    }

    public function assignRole(Request $request){
        $groupid = $request->gid;

        $selectAllRoles = DB::table('permission')
            ->orderBy('permission_root', 'DESC')
            ->orderBy('id', 'ASC')->get();
        $allRoles = array();
        foreach ($selectAllRoles as $row){
            if ($row->permission_root == null){
                $allRoles[$row->id] = $row;
                $allRoles[$row->id]->children = array();
            }else{
                $allRoles[$row->permission_root]->children[] = $row;
            }
        }

        $selectGrRole = DB::table('roles_group')
            ->where('group_id', $groupid)
            ->pluck('permission');
        $groupRoles = array();
        foreach ($selectGrRole as $role){
            $groupRoles[] = $role;
        }
        $output = ['allRoles' => $allRoles, 'groupRole' => $groupRoles];
        return view('roles.role', $output);
    }
}
