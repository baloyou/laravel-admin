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

use App\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

#Auth::routes();

//无需登陆的两个控制器
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');

//授权登陆的用户
Route::prefix(config('project.admin_path'))->middleware('auth')->group(function(){

    //所有人可见
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('home', 'HomeController@index')->name('home');

    //系统配置（超管）
    Route::prefix('setting')->group(function(){
        //基本配置
        Route::get('', 'UserController@index')->name('setting');
        //平台设置
        Route::get('platform', 'UserController@platform')->name('platform');
        //账号设置
        Route::get('account', 'UserController@account')->name('platform-account');
    });

    //用户，所有人可见
    Route::prefix('user')->group(function(){
        //用户列表（自己、旗下用户）
        Route::get('', 'UserController@index')->name('user');
        //增加用户（超管）
        Route::get('add', 'UserController@add')->name('user-add');
        //编辑用户（自己/超管）
        Route::get('modify', 'UserController@modify')->name('user-modify');
        //禁用用户（超管）
        Route::get('state', 'UserController@state')->name('user-state');
        //用户详细（自己、旗下用户）
        Route::get('detail', 'UserController@detail')->name('user-detail');
    });

    //用户组（超管权限）
    Route::prefix('group')->group(function(){
        //列表
        Route::get('', 'GroupController@index')->name('group');
        //添加
        Route::get('add', 'GroupController@add')->name('group-add');
        //编辑
        Route::get('modify', 'GroupController@modify')->name('group-modify');
        //软删除（如果旗下有用户，则不能删除）
        Route::get('remove', 'GroupController@remove')->name('group-remove');
    });

    //数据管理（稿件）
    Route::prefix('article')->group(function(){
        //列表（每个人可查看自己的文章、自己直属下级的文章）
        Route::get('', 'ArticleController@index')->name('article');
        //添加（每个人都可以加）
        Route::get('add', 'ArticleController@add')->name('article-add');
        
        /**
         * 编辑
         * 当处于草稿、返修状态时，可见人即可编辑
         * 当处于其他状态时，只有上级管理员、超级管理员可编辑
         */
        Route::get('modify', 'ArticleController@modify')->name('article-modify');
        
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
 * 1、先实现对整个文章模块的权限约束(permission:articles)
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
