<?php

// use anlutro\LaravelSettings\SettingsManager;

use App\Model\Setting;
use Illuminate\Database\Seeder;
// use anlutro\LaravelSettings\Facade as Setting;
// use anlutro\LaravelSettings\SettingStore as Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key'   => 'webname',
            'value' => '默认网站',
            'sort'  => 1,
            'name'  => '网站标题',
            'desc'  => '将显示在标题蓝',
        ]);
        
        Setting::create([
            'key'   => 'pagenum',
            'value' => 20,
            'sort'  => 2,
            'name'  => '每页显示数',
            'desc'  => '所有带分页的数据列表，每页显示多少条数据',
        ]);
    }
}
