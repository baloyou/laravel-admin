<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //定义超级管理员
        Gate::before(function ($user, $ability) {
            //id = 1的用户为超级管理员，所有权限验证对他不生效。
            return $user->id == 1 ? true : null;
        });
        // 自定义一个动作，可以用 can 去检查的那种
        // 注意：如果是超级管理员，会先触发 before()，所以这个无效
        // 触发方法：$user->can('test') 因为这个方法永远返回true，所以验证永远都是通过的
        Gate::define('test', function($user){
            echo '你触发了test 权限';
            return true;
        });
    }
}
