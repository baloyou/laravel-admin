<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

#Auth::routes();

//无需登陆的两个控制器
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');

//授权登陆的用户
Route::prefix(config('project.admin_path'))->middleware('auth','\App\Http\Middleware\CheckUserState')->group(function(){

    //所有人可见
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('home', 'HomeController@index')->name('home');

    //系统配置（超管）
    Route::prefix('setting')->middleware('permission:setting')->group(function(){
        
        //基本配置
        Route::get('', 'SettingController@index')->name('setting')
            ->middleware('permission:setting-list');

        Route::post('', 'SettingController@save')->name('setting-save')
            ->middleware('permission:setting-manager');
        
        //平台设置
        Route::get('platform', 'SettingController@platform')->name('platform');
        //账号设置
        Route::get('account', 'SettingController@account')->name('platform-account');
    });

    //用户，所有人可见
    Route::prefix('user')->middleware('permission:user')->group(function(){
        
        //用户列表（自己、旗下用户）
        Route::get('', 'UserController@index')->name('user')
            ->middleware('permission:user-list');
        
        //用户管理
        Route::middleware('permission:user-manager')->group(function(){
            Route::get('add', 'UserController@add')->name('user-add');
            Route::post('save', 'UserController@save')->name('user-save');
            Route::get('state', 'UserController@state')->name('user-state');
        });
        
        //用户详细（自己、旗下用户）
        Route::get('detail', 'UserController@detail')->name('user-detail');
    });

    //用户组（超管权限）
    Route::prefix('role')->middleware('permission:role')->group(function(){
        
        //列表
        Route::get('', 'RoleController@index')->name('role')
            ->middleware('permission:role-list');

        //管理
        Route::middleware('permission:role-manager')->group(function(){
            Route::get('add', 'RoleController@add')->name('role-add');
            Route::post('save', 'RoleController@save')->name('role-save');
            Route::get('remove', 'RoleController@remove')->name('role-remove');
        });

    });

    //数据管理（稿件）
    Route::prefix('article')->middleware('permission:article')->group(function(){
        //列表（每个人可查看自己的文章、自己直属下级的文章）
        Route::get('', 'ArticleController@index')->name('article')->middleware('permission:article-list');
        //添加和编辑（每个人都可以加）
        Route::get('add', 'ArticleController@add')->name('article-add')->middleware('permission:article-manager');
        
        /**
         * 编辑
         * 当处于草稿、返修状态时，可见人即可编辑
         * 当处于其他状态时，只有上级管理员、超级管理员可编辑
         */
        // Route::get('modify', 'ArticleController@modify')->name('article-modify');
        
        /**
         * 状态流转
         * 草稿/返修->待审：作者操作
         * 待审->通过/返修：上级管理员、超级管理员可操作
         */
        Route::get('state', 'ArticleController@state')->name('article-state');
        //稿件外发(管理员/超级管理员)
        Route::get('publish', 'ArticleController@publish')->name('article-publish');
    });
});

/**
 * 用来调试权限的路由
 */
Route::middleware(['permission:articles'])->group(function () {
    Route::get('/a', function () {
        $user = Auth::user();
        dump($user->id, $user->can('articles'));
        return '删除';
    })->middleware('permission:delete articles');

    Route::get('/b', function () {
        $user = Auth::user();
        dump($user->id, $user->can('test'));
        return '修改';
    });
});

// Route::get('/home', 'HomeController@index')->name('home');
