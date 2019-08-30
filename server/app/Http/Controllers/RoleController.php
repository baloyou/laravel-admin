<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     * 如果是修改角色，则面临着大量的权限重组，这块要看下文档怎么处理
     *
     * @param Request $r
     * @return void
     */
    public function save(Request $r)
    {   
        $id = $r->input('id',0);
        $name = $r->input('name','');
        $input_pmts = $r->input('input_pmts',[]);

        /**
         * 数据验证，包含名称唯一性的验证，
         * 注意：编辑模式下允许与自身原名重复。
         */
        $rules = [
            'name'  => ['required', 'max:255'],
            'input_pmts'  => ['required'],
        ];

        //there are edit mode to ignore  itself’s name
        $name_unique = Rule::unique('roles');
        if( $id>0 ){
            $name_unique = $name_unique->ignore($id);
        }
        $rules['name'][] = $name_unique;

        //验证（同时验证了角色唯一性）
        Validator::make($r->all(), $rules)->validate();
        
        //数据写入
        try {
            $role = new Role();
            //in方法，包含了赋权
            $role = $role->in($id, ['name' => $name], $input_pmts);
        } catch (\Exception $e) {
            return back()->with('msg', $e->getMessage());
        }
        return redirect()->route('role')->with('msg','角色操作成功');
    }
}
