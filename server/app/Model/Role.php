<?php

namespace App\Model;

use Spatie\Permission\Models\Role as SpatieRole;

/**
 * 为了方便管理，做一个自己的 Role
 */
class Role extends SpatieRole{
    
    /**
     * 增加角色
     * @param [type] $data
     * @return void
     */
    public function in($id, array $data, $pmts=[]){

        if( $id>0 ){
            $role = $this->where('id',$id)->first();
            $role->update( $data );
            //移除原有权限
            $role->permissions()->detach();
        }else{
            $role = $this->create($data);
        }

        //为角色追加权限
        $pmts = Permission::whereIn('id', $pmts)->get();
        $role->givePermissionTo($pmts);
        return $role;
    }
}