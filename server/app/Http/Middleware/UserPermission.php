<?php

namespace App\Http\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;

use Closure;

/**
 * 重写了权限验证类，定义更明确的越权提示。
 */
class UserPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {
            if (app('auth')->user()->can($permission)) {
                return $next($request);
            }
        }

        echo '权限不足';exit;
    }
}
