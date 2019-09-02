<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleValidate;
use App\Model\Role;
use App\Model\Permission;
use App\Services\Std;
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
        
        //创建一个空角色对象，用于兼容添加、编辑模式
        $role = new Std;
        $role->id = 0;

        //默认选中的权限
        $permission_ids = [];

        // 如果是编辑状态，载入目标数据
        if( $id ){
            $role = Role::find($id);
            if(!$role){
                return redirect()->route('role')->with('msg', '目标角色不存在!');
            }
            $role->permissions()->get()->each(function($v, $k)use(&$permission_ids){
                $permission_ids[] = $v->id;
            });
        }

        //用于显示表单，优先显示old，其次如果有数据库信息则显示，否则显示默认值
        $form = [
            'id'    => $id,
            'name'  => old('name', $role->name),
            'input_pmts'  => old('input_pmts', $permission_ids),
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

    public function remove(Request $r){
        $role = Role::find( $r->input('id',0) );
        if(!$role){
            return back()->with('msg', '角色不存在');
        }
        try{
            $role->remove();
        }catch(\Exception $e){
            return back()->with('msg', $e->getMessage());
        }
        return redirect()->route('role')->with('msg','角色删除成功');
    }
}
