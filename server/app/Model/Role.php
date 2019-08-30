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
    public function in(array $data){
        //检查角色名是否存在
        return $this->create($data);
    }
}