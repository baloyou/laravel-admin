<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidate;
use App\User;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $r){
        
        /**
         * 根据角色过滤
         * ->whereHas('roles',function($query){
         *       $query->where('id',1);
         *   })
         */
        $users = User::with('roles')->orderBy('id','desc')->paginate(15);

        $data = [
            'users' => $users,
        ];
        
        return view('user.index',$data);
    }

    public function add(Request $r)
    {
        $id = $r->input('id',0);
        
        // 如果是编辑状态，载入目标数据
        $user = null;
        if( $id ){
            $mUser = new User;
            $user = $mUser->where('id',$id)->first();
            if(!$user){
                return redirect()->route('user')->with('msg', '目标角色不存在!');
            }
            $role_ids = [];
            $user->roles()->get()->each(function($v, $k)use(&$role_ids){
                $role_ids[] = $v->id;
            });
        }

        //用于显示表单，优先显示old，其次如果有数据库信息则显示，否则显示默认值
        $form = [
            'id'    => $id,
            'name'  => old('name', $user ? $user->name : ''),
            'login_name'  => old('login_name', $user ? $user->login_name : ''),
            'password'  => old('password'), //密码就只考虑历史数据
            'email'  => old('email', $user ? $user->email : ''),
            'phone'  => old('phone', $user ? $user->phone : ''),
            'input_roles'  => old('input_roles', $user ? $role_ids : []),
        ];

        //模板中显示的分组
        $role = new Role();
        $roles = $role->getRoles();

        $data = [
            'roles' => $roles,
            'form'  => $form,
        ];
        return view('user.add', $data);
    }


    public function save(UserValidate $r)
    {  
        //使用验证器验证用户信息
        $r->validated();

        //数据写入
        try {
            $user = new User();
            $user = $user->in($r->all());

        } catch (\Exception $e) {
            return back()->with('msg', $e->getMessage());
        }
        return redirect()->route('user')->with('msg','用户操作成功');
    }

}
