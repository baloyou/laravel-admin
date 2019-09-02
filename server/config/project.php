<?php

$project = [];
$project['admin_path']  = env('ADMIN_PATH', 'admin');

/**
 * user 
 */
$project['user']['state']  = [
    0   => '<span class="badge badge-danger">禁用</span>',
    1   => '<span class="badge badge-success">正常</span>',
];
$project['user']['state_default']  = 1;

return $project;