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

Route::get('/', function () {
    return view('welcome');
});

#Auth::routes();

//无需登陆的两个控制器
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');

Route::prefix(config('project.admin_path'))->group(function(){


    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('home', 'HomeController@index')->name('home');
});

/**
 * 1、先实现对整个文章模块的权限约束(permission:articles)
 */
// Route::middleware(['permission:articles'])->group(function () {
//     Route::get('/a', function () {
//         return '删除';
//     })->middleware('permission:delete articles');

//     Route::get('/b', function () {
//         return '修改';
//     });
// });

// Route::get('/home', 'HomeController@index')->name('home');
