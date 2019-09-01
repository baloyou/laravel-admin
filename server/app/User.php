<?php

namespace App;

use App\Model\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

/**
 * 这个模型换文件夹太麻烦，就懒得换了。
 */

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     * 想使用 $r->all() 简洁插入，这个设置必不可少（不在此列的字段不允许更新和写入）
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','login_name','phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * (新建/编辑)用户信息
     *
     * @param [type] $user_id
     * @param array $data
     * @param array $roles
     * @return void
     */
    public function in(array $data){

        $user_id = $data['id'];
        $roles = is_array($data['input_roles']) ? $data['input_roles'] : [];

        //如果处于编辑模式，并且密码字段为空，密码保持原样
        if( $data['password'] == '' ){
            unset($data['password']);
        }else{
            $data['password'] = Hash::make($data['password']);
        }
        
        //创建/更新 用户基本信息
        if( $user_id>0 ){
            $user = $this->where('id',$user_id)->first();
            $user->update( $data );
            $user->roles()->detach();
        }else{
            $user = $this->create($data);
        }

        //为用户追加角色
        $roles = Role::whereIn('id', $roles)->get();
        $user->assignRole($roles);
        return $user;
    }
}

