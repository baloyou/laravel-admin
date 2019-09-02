<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidate;
use App\User;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Services\Std;

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
        
        //定义一个user空对象，用于兼容在编辑、添加模式下的用户字段处理
        $user = new Std;
        $user->state = config('project.user.state_default');

        //默认选中的角色ids
        $role_ids = [];

        // 如果是编辑状态，载入目标数据
        if( $id ){
            $mUser = new User;
            $user = $mUser->where('id',$id)->first();
            if(!$user){
                return redirect()->route('user')->with('msg', '目标角色不存在!');
            }
            $user->roles()->get()->each(function($v, $k)use(&$role_ids){
                $role_ids[] = $v->id;
            });
        }

        //用于显示表单，优先显示old，其次如果有数据库信息则显示，否则显示默认值
        $form = [
            'id'    => $id,
            'name'  => old('name', $user->name),
            'login_name'  => old('login_name', $user->login_name),
            'password'  => old('password'), //密码就只考虑历史数据
            'email'  => old('email', $user->email),
            'phone'  => old('phone', $user->phone),
            'input_roles'  => old('input_roles', $role_ids),
            
            //用户状态
            'user_state'    => [
                    'default'   => old('user_state', $user->state ),
                    'data'      => config('project.user.state'),
                    'name'      => 'state',
                ]
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
            $data = $r->all();
            $user = $user->in($data);

        } catch (\Exception $e) {
            return back()->with('msg', $e->getMessage());
        }
        return redirect()->route('user')->with('msg','用户操作成功');
    }

    /**
     * 切换用户状态（在正常与禁用之间）
     *
     * @param Request $r
     * @return void
     */
    public function state(Request $r){
        $user = User::find($r->input('id',0));
        if($user){
            //翻转用户状态
            $user->trunState();
            return back()->with('msg', '操作完成');
        }else{
            return back()->with('msg', '数据不存在');
        }
    }

}
