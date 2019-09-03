<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class SettingController extends Controller
{
    public function index(Request $r){
        $data = [
            'settings'  => \Setting::rawAll()
        ];
        return view('setting.index', $data);
    }

    public function save(Request $r){
        $data = $r->input('settings',[]);

        //保存配置信息
        \Setting::set($data);
        \Setting::save();
        return back()->with('msg', '配置保存完毕');
    }
}
