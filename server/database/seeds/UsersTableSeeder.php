<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 目标id = 1
        App\User::create([
            'name'  => '管理员',
            'login_name'  => 'admin',
            'email'  => 'admin2@qq.com',
            'password'  => '$2y$10$9LX2HvwNQeEGY9k30YDZR.r75bFYh8u7JWag2QboYMISPDnJkidUq',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        // 目标id = 2
        App\User::create([
            'name'  => '普通人',
            'login_name'  => 'test',
            'email'  => 'test@qq.com',
            'password'  => '$2y$10$9LX2HvwNQeEGY9k30YDZR.r75bFYh8u7JWag2QboYMISPDnJkidUq',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }
}
