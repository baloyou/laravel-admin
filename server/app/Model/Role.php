<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use League\Flysystem\Exception;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * 为了方便管理，做一个自己的 Role
 */
class Role extends SpatieRole{
    // use SoftDeletes;

    protected $fillable = [
        'name','guard_name'
    ];    
    /**
     * 添加、修改角色
     * 编辑模式下，会移除原有权限
     * 添加模式下，先创建角色，再写入权限的多对多关系
     * @param [int]     $role_id    =0 表示新建，否则编辑目标角色id
     * @param [array]   $data   角色基本信息
     * @param [array]   $pmts   选中的权限列表
     * @return object Role
     */
    public function in( array $data){
        
        $role_id = $data['id'];
        $pmts = isset($data['input_pmts']) ? $data['input_pmts'] : [];

        //创建/更新 角色基本信息
        if( $role_id>0 ){
            $role = $this->where('id',$role_id)->first();
            $role->update( $data );
            $role->permissions()->detach();
        }else{
            $role = $this->create($data);
        }

        //为角色追加权限
        $pmts = Permission::whereIn('id', $pmts)->get();
        $role->givePermissionTo($pmts);
        return $role;
    }

    /**
     * 返回所有可用分组，就是带了个排序
     *
     * @return void
     */
    public function getRoles(){
        return $this->orderBy("id",'asc')->get();
    }

    /**
     * 软删除角色（删除之前会检查旗下是否有用户）
     *
     * @return void
     */
    public function remove(){
        if( $this->users()->count() > 0 ){
            tr('旗下包含用户，不能删除');
        }
        
        return $this->delete();
    }
}