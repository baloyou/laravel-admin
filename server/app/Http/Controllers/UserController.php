<?php

namespace App\Http\Controllers;

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


    public function save(Request $r)
    {   
        $id = $r->input('id',0);
        $name = $r->input('name','');
        $login_name = $r->input('login_name','');
        $password = $r->input('password','');
        $email = $r->input('email','');
        $phone = $r->input('phone','');
        $input_roles = $r->input('input_roles',[]);

        /**
         * 数据验证，包含名称唯一性的验证，
         * 注意：编辑模式下允许与自身原名重复。
         */
        $rules = [
            'name'  => ['required', 'max:255'],
            'login_name'  => ['required', 'max:255'],
            // 'password'  => ['required', 'max:255'], （只有新增情况才验证密码字段）
            'email'  => ['required', 'max:255'],
            'phone'  => ['required', 'max:255'],
            'input_roles'  => ['required'],
        ];

        //there are edit mode to ignore  itself’s name
        $login_name_unique = Rule::unique('users');
        $email_unique = Rule::unique('users');
        $phone_unique = Rule::unique('users');

        if( $id>0 ){
            $login_name_unique = $login_name_unique->ignore($id);
            $email_unique = $email_unique->ignore($id);
            $phone_unique = $phone_unique->ignore($id);
        }else{
            //只有新增模式，才有密码验证
            $rules['password'] = ['required', 'max:60'];
        }
        $rules['login_name'][] = $login_name_unique;
        $rules['email'][] = $email_unique;
        $rules['phone'][] = $phone_unique;

        //验证（同时验证了关键字段的唯一性）
        Validator::make($r->all(), $rules)->validate();
        
        //数据写入
        try {
            $userdata = [
                'name' => $name,
                'login_name' => $login_name,
                'password' => $password,
                'email' => $email,
                'phone' => $phone,
            ];
            
            //如果处于编辑模式，并且密码字段为空，密码保持原样
            if( $password == '' && $id>0 ){
                unset($userdata['password']);
            }

            $user = new User();
            //in方法，包含了赋权
            $user = $user->in($id, $userdata, $input_roles);

        } catch (\Exception $e) {
            return back()->with('msg', $e->getMessage());
        }
        return redirect()->route('user')->with('msg','用户操作成功');
    }
}
