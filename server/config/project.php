<?php

$project = [];
$project['admin_path']  = env('ADMIN_PATH', 'admin');

/**
 * user config
 */
$project['user']['state']  = [
    App\User::STATE_BAN   => '<span class="badge badge-danger">禁用</span>',
    App\User::STATE_NORMAL   => '<span class="badge badge-success">正常</span>',
];
$project['user']['state_default']  = App\User::STATE_NORMAL;

return $project;