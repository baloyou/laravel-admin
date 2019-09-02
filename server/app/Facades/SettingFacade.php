<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade{
    static public function getFacadeAccessor(){
        return 'App\Services\SettingManager';
    }
}