<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $r){
        
        /**
         * 根据角色过滤
         * ->whereHas('roles',function($query){
         *       $query->where('id',1);
         *   })
         */
        $users = User::with('roles')->paginate(15);

        $data = [
            'users' => $users,
        ];
        
        return view('user.index',$data);
    }
}
