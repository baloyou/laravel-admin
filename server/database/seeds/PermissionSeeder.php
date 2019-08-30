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
        // 创建3个角色
        $role1 = Role::create(['name' => '作者']);
        $role2 = Role::create(['name' => '管理员']);
        $role3 = Role::create(['name' => '超级管理员']);
        // 创建3个权限
        $p1 = Permission::create([
            'name'  => 'article',
            'pid'   => 0,
            'namecn'=> '文章模块',
        ]);
        $p2 = Permission::create([
            'name'  => 'article-list',
            'pid'   => $p1->id,
            'namecn'=> '文章列表',
        ]);
        $p3 = Permission::create([
            'name'  => 'article-add',
            'pid'   => $p1->id,
            'namecn'=> '添加文章',
        ]);

        // 创建3个权限
        $p4 = Permission::create([
            'name'  => 'user',
            'pid'   => 0,
            'namecn'=> '用户模块',
        ]);
        $p5 = Permission::create([
            'name'  => 'user-list',
            'pid'   => $p4->id,
            'namecn'=> '用户列表',
        ]);
        $p6 = Permission::create([
            'name'  => 'user-add',
            'pid'   => $p4->id,
            'namecn'=> '角色管理',
        ]);
        // 将角色与权限关联
        $role1->givePermissionTo($p1,$p2);
        $role2->givePermissionTo($p1,$p3);
        $role3->givePermissionTo($p1,$p2,$p3);

        //将用户加入角色
        $user1 = User::find(1);
        $user2 = User::find(2);
        $user1->assignRole($role3);
        $user2->assignRole($role1);
    }
}
