<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Roles extends Model
{
    public static function checkRole($route, $refresh = false)
    {
        return true;
        $user = Session::get('user');
        if (!isset($user)) return false;
        if (!Session::has('role-' . $user->id) || $refresh){
            $userGroup = intval($user->group_permission);
            $roles = DB::table('permission')
                ->join('roles_group', 'permission.id', '=', 'roles_group.permission')
                ->where('roles_group.group_id', '=', $userGroup)->pluck('permission.route')->toArray();
            Session::put('role-' . $user->id, $roles);
        }
        $roles = Session::get('role-' . $user->id);
        return in_array($route, $roles);
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
