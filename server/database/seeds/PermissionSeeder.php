<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        //一级权限列表
        $pmt1 = [
            'article'   => ['name'=>'article', 'pid'=>0, 'namecn'=>'稿件模块'],
            'user'      => ['name'=>'user', 'pid'=>0, 'namecn'=>'用户模块'],
            'role'      => ['name'=>'role', 'pid'=>0, 'namecn'=>'分组管理'],
            'setting'      => ['name'=>'setting', 'pid'=>0, 'namecn'=>'系统设置'],
        ];

        // 子权限列表
        $pmt2 = [];
        $pmt2['article'] = [
            ['name'=>'article-list', 'namecn'=>'稿件列表'],
            ['name'=>'article-manager', 'namecn'=>'管理稿件'],
        ];
        $pmt2['user'] = [
            ['name'=>'user-list', 'namecn'=>'用户列表'],
            ['name'=>'user-manager', 'namecn'=>'管理用户'],
        ];
        $pmt2['role'] = [
            ['name'=>'role-list', 'namecn'=>'角色列表'],
            ['name'=>'role-manager', 'namecn'=>'管理角色'],
        ];
        $pmt2['setting'] = [
            ['name'=>'setting-list', 'namecn'=>'浏览设置'],
            ['name'=>'setting-manager', 'namecn'=>'管理设置'],
        ];

        $permissions = [];
        foreach($pmt1 as $key=>$item){
            $permissions[] = $pmtModel = Permission::create( $item );
            foreach( $pmt2[$key] as $key2=>$item2 ){
                $item2['pid'] = $pmtModel->id;
                $permissions[] = Permission::create( $item2 );
            }
        }

        // 创建3个角色
        $role1 = Role::create(['name' => '作者']);
        $role2 = Role::create(['name' => '管理员']);
        $role3 = Role::create(['name' => '超级管理员']);

        // 将角色与权限关联
        $role3->givePermissionTo($permissions);

        //将用户加入角色
        $user1 = User::find(1);
        $user2 = User::find(2);
        $user1->assignRole($role3);
        $user2->assignRole($role1);
    }
}
