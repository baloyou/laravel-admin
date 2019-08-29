<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use Vyuldashev\NovaPermission\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $role = Role::create(['name'=>'writer']);
        // $role = Role::find(1);
        // $permission = Permission::find(5);
        // $role->givePermissionTo( $permission );

        $user = User::find(1);
        $pms = $user->getAllPermissions();
        // dump($pms);
        // $user->assignRole('writer');

        // $users = User::role('writer')->get();
        // dump($users);
        // $permission = Permission::create(['name'=>'edit articles']);

        return view('home');
    }
}
