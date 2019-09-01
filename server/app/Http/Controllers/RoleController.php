<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleValidate;
use App\Model\Role;
use App\Model\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $r)
    {
        $role = new Role;
        $data = [
            'roles' => $role->getRoles(),
        ];
        return view('role.index', $data);
    }

    /**
     * 角色添加UI
     *
     * @param Request $r
     * @return void
     */
    public function add(Request $r)
    {
        $id = $r->input('id',0);
        
        // 如果是编辑状态，载入目标数据
        $role = null;
        if( $id ){
            $mRole = new Role;
            $role = $mRole->where('id',$id)->first();
            if(!$role){
                return redirect()->route('role')->with('msg', '目标角色不存在!');
            }
            $permission_ids = [];
            $role->permissions()->get()->each(function($v, $k)use(&$permission_ids){
                $permission_ids[] = $v->id;
            });
        }

        //用于显示表单，优先显示old，其次如果有数据库信息则显示，否则显示默认值
        $form = [
            'id'    => $id,
            'name'  => old('name', $role ? $role->name : ''),
            'input_pmts'  => old('input_pmts', $role ? $permission_ids : []),
        ];

        //模板中显示的树结构
        $pmts = new Permission();
        $data = [
            'pmts' => $pmts->tree(),
            'form'  => $form,
        ];
        return view('role.add', $data);
    }

    /**
     * 保存角色新建、编辑结果
     *
     * @param Request $r
     * @return void
     */
    public function save(RoleValidate $r)
    {   
        $r->validated();
        
        //数据写入
        try {
            $role = new Role();
            $role = $role->in($r->all());
        } catch (\Exception $e) {
            return back()->with('msg', $e->getMessage());
        }
        return redirect()->route('role')->with('msg','角色操作成功');
    }
}
