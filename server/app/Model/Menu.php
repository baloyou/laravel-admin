<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    //所有字段都可以更新
    protected $guarded = [];

    /**
     * 获取多级菜单，会排除无权访问的菜单
     *
     * @param boolean $isFull=false 设为true则不考虑权限，全部显示
     * @return void
     */
    public function tree($isFull = false){
        $menus = $this->orderBy('sort','asc')->get();
        $result = [];
        foreach($menus as $menu){
            //权限校验，跳过无权的菜单
            if (!Auth::user()->can($menu->auth) && !$isFull){
                continue;
            }
            if( $menu->pid == 0 ){
                $result[ $menu->id ]['data'] = $menu;
            }else{
                $result[ $menu->pid ]['childs'][] = $menu;
            }
        }
        return $result;
    } 
}
