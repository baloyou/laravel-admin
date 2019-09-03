<?php

use App\Model\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * \Route::getRoutes()->getByName('user')->uri()
     * @return void
     */
    public function run()
    {
        /**************** setting */
        $setting = Menu::create([
            'pid'   => 0,
            'name'  => '系统设置',
            'link'  => '',
            'auth'  => 'setting',
            'position'  => 1,
            'sort'  => 1,
        ]);
        Menu::create([
            'pid'   => $setting->id,
            'name'  => '基本设置',
            'link'  => "/".\Route::getRoutes()->getByName('setting')->uri(),
            'auth'  => 'setting',
            'position'  => 1,
            'sort'  => 1,
        ]);    
        Menu::create([
            'pid'   => $setting->id,
            'name'  => '平台设置',
            'link'  => "/".\Route::getRoutes()->getByName('setting')->uri(),
            'auth'  => 'setting',
            'position'  => 1,
            'sort'  => 2,
        ]);    

        /**************** user */
        $user = Menu::create([
            'pid'   => 0,
            'name'  => '用户管理',
            'link'  => '',
            'auth'  => 'user',
            'position'  => 1,
            'sort'  => 2,
        ]);
        Menu::create([
            'pid'   => $user->id,
            'name'  => '用户管理',
            'link'  => "/".\Route::getRoutes()->getByName('user')->uri(),
            'auth'  => 'user-list',
            'position'  => 1,
            'sort'  => 1,
        ]);
        Menu::create([
            'pid'   => $user->id,
            'name'  => '分组管理',
            'link'  => "/".\Route::getRoutes()->getByName('role')->uri(),
            'auth'  => 'role',
            'position'  => 1,
            'sort'  => 2,
        ]);

        /**************** article */
        $article = Menu::create([
            'pid'   => 0,
            'name'  => '稿件管理',
            'link'  => '',
            'auth'  => 'article',
            'position'  => 1,
            'sort'  => 3,
        ]);
        Menu::create([
            'pid'   => $article->id,
            'name'  => '所有稿件',
            'link'  => "/".\Route::getRoutes()->getByName('article')->uri(),
            'auth'  => 'article-list',
            'position'  => 1,
            'sort'  => 3,
        ]);
    }
}
