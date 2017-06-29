<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Roles extends Model
{
    public static function checkRole($route){
        $userGroup = intval(Session::get('user')->group_permission);
        $check = DB::table('permission')
            ->join('roles_group', 'permission.id', '=', 'roles_group.permission')
            ->where([
                ['roles_group.group_id', '=', $userGroup],
                ['permission.route', '=', $route]
            ])->get();
        return count($check) > 0;
    }
}
