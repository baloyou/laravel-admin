<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public function index(Request $r)
    {
        $roles = Role::get();
        $data = [
            'roles' => $roles,
        ];
        return view('role.index', $data);
    }

    public function add(Request $r)
    {

        $form = [
            'name'  => old('name', ''),
            'input_pmts'  => old('input_pmts', []),
        ];

        $pmts = new Permission();
        $data = [
            'pmts' => $pmts->tree(),
            'form'  => $form,
        ];
        return view('role.add', $data);
    }

    public function save(Request $r)
    {
        Validator::make($r->all(), [
            'name'  => ['required', 'unique:roles', 'max:255'],
            'input_pmts'  => ['required'],
        ])->validate();

        $name = $r->input('name','');
        $input_pmts = $r->input('input_pmts',[]);
        $role = new Role();

        //创建角色
        try {
            $role = $role->in(['name' => $name]);

            //为角色追加权限
            $pmts = Permission::whereIn('id', $input_pmts)->get();
            $role->givePermissionTo($pmts);
        } catch (\Exception $e) {
            return back()->with('msg', $e->getMessage());
        }
        return redirect()->route('role')->with('msg','角色创建完毕！');
    }
}
