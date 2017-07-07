<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Roles extends Model
{
    public static function checkRole($route)
    {
        $user = Session::get('user');
        if (!isset($user)) return false;
        $userGroup = intval(Session::get('user')->group_permission);
        $check = DB::table('permission')
            ->join('roles_group', 'permission.id', '=', 'roles_group.permission')
            ->where([
                ['roles_group.group_id', '=', $userGroup],
                ['permission.route', '=', $route]
            ])->get();
        return count($check) > 0;
    }

    public static function treeRoles(){
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
        return $allRoles;
    }

    public static function existRoles($groupid){
        return DB::table('roles_group')
            ->where('group_id', $groupid)
            ->pluck('permission')->toArray();
    }
}
