<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->leftJoin('group_permission', 'group_permission.id', '=', 'users.group_permission')
            ->select('users.id', 'users.username', 'users.email', 'users.firstname', 'users.lastname', 'group_permission.name as group_name')
            ->get();
        $groups = DB::table('group_permission')->orderBy('id', 'ASC')->get();
//        return response()->json($users);
        return view('users.index', ['users' => $users, 'groups' => $groups]);
    }

    public function update(Request $request)
    {
        $uid = intval($request->uid);
        if ($request->isMethod('get')) {
            $user = DB::table('users')
                ->where('id', $uid)
                ->first();
            $groups = DB::table('group_permission')->orderBy('id', 'ASC')->get();
            return view('users.update', ['user' => $user, 'groups' => $groups]);
        }
        $group_permission = $request->group_permission;
        DB::table('users')->where('id', $uid)->update(['group_permission' => $group_permission]);
        $request->session()->flash('message', 'Cập nhật quyền thành công');
        return redirect(route('user-index'));

    }

    public function roles(Request $request)
    {
        $groups = DB::table('group_permission')->orderBy('id', 'ASC')->get();
        return view('users.roles', ['groups' => $groups]);
    }

    public function assignRole(Request $request)
    {
        $groupid = $request->gid;

        $groupname = DB::table('group_permission')->where('id', $groupid)->value('name');

        $allRoles = Roles::treeRoles();

        $groupRoles = Roles::existRoles($groupid);

        $output = ['allRoles' => $allRoles, 'groupRole' => $groupRoles, 'groupid' => $groupid, 'groupname' => $groupname];
        return view('users.assign', $output);
    }

    public function submitRole(Request $request)
    {
        $groupid = $request->gid;
        $roles = $request->roles;

        $groupRoles = Roles::existRoles($groupid);
        $removeRoles = array();
        $insertRoles = array();
        foreach ($groupRoles as $gr) {
            if (in_array($gr, $roles)) {
                $roles = array_diff($roles, [$gr]);
            } else {
                $removeRoles[] = $gr;
            }
        }
        foreach ($roles as $role) {
            $insertRoles[] = ['group_id' => $groupid, 'permission' => $role];
        }

        if (count($removeRoles) > 0) {
            DB::table('roles_group')
                ->whereIn('permission', $removeRoles)
                ->where('group_id', $groupid)
                ->delete();
        }
        if (count($insertRoles) > 0) {
            DB::table('roles_group')->insert($insertRoles);
        }
        DB::table('group_permission')->where('id', $groupid)->update(['name' => $request->name]);
        $request->session()->flash('message', 'Cập nhật quyền thành công');
        return redirect(route('role-index'));
    }

    public function createRole(Request $request)
    {
        if ($request->isMethod('get')) {
            $allRoles = Roles::treeRoles();
            return view('users.createrole', ['allRoles' => $allRoles]);
        }
        $roles = $request->roles;
        $groupid = DB::table('group_permission')->insertGetId(['name' => $request->name]);
        $insertRoles = array();
        foreach ($roles as $role) {
            $insertRoles[] = ['group_id' => $groupid, 'permission' => $role];
        }
        if (count($insertRoles) > 0) {
            DB::table('roles_group')->insert($insertRoles);
        }
        $request->session()->flash('message', 'Thêm nhóm quyền thành công');
        return redirect(route('role-index'));
    }

    public function deleteRole(Request $request)
    {
        $groupid = $request->gid;
        DB::table('group_permission')->where('id', $groupid)->delete();
        $request->session()->flash('message', 'Xóa nhóm quyền thành công');
        return redirect(route('role-index'));
    }


    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('users.add');
        }

        $result = DB::table('users')
            ->insertGetId([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

        if ($result) {
            $request->session()->flash('message', 'Thêm học viên thành công');
            return redirect(route('user-index'));
        } else {
            $request->session()->flash('message', 'Thêm học viên thất bại');
            return redirect(route('user-add'))->withInput();
        }

    }

    public function updateuser(Request $request)
    {
        $uid = intval($request->uid);

        if ($request->isMethod('get')) {
            $user = DB::table('users')
                ->where('id', $uid)
                ->first();
            $groups = DB::table('group_permission')->orderBy('id', 'ASC')->get();
            return view('users.updateuser', ['user' => $user, 'groups' => $groups]);
        } else if ($request->isMethod('post')) {


            $dataupdate = [
                'firstname' => $request->firstname,
                'email' => $request->email,
            ];
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) $dataupdate['email'] = $request->email;

            if ($request->has("password")) $dataupdate['password'] = Hash::make($request->password);
            if ($request->has("lastname")) $dataupdate['lastname'] = $request->lastname;

            $rs = DB::table('users')->where('id', $uid)->update(
                $dataupdate
            );
            if ($rs) {
                $request->session()->flash('message', 'Cập nhật thông tin tài khoản thành công!');
                return redirect(route('user-index'));
            } else {
                $request->session()->flash('message', 'Cập nhật thông tin tài khoản không thành công!');
                return redirect(route('user-index'));
            }
        }
    }

    public function deleteUser(Request $request)
    {
        $rs = DB::table('users')->where('id', intval($request->id))->delete();
        if ($rs) {
            $request->session()->flash('message', 'Xóa tài khoản thành công!');
            return redirect(route('user-index'));
        } else {
            $request->session()->flash('message', 'Xóa tài khoản không thành công!');
            return redirect(route('user-index'));
        }
    }

}
