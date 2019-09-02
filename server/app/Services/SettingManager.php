<?php
namespace App\Services;

use App\Model\Setting;

/**
 * 系统配置管理类
 */
class SettingManager{

    //解析成kv对的配置数据，避免重复读取
    protected $settings = false;

    public function __construct()
    {
        $this->all();
    }

    /**
     * 设定新值（改值）如果没有会新增
     * @param [string/array] $key   传入数组表示批量设置，否则设置单一值
     * @param [type] $value
     * @return void 不需要返回值
     */
    public function set($key, $value=''){
        if(is_array($key)){
            $this->settings = $this->settings->merge($key);
        }else{
            $this->settings = $this->settings->merge([$key=>$value]);
        }
        // $this->settings->offsetSet($key, $value);
    }

    /**
     * 保存之前 set 的结果。
     * 
     * @return void
     */
    public function save(){
        $data = [];
        $this->settings->each(function($v,$k)use(&$data){
            Setting::updateOrInsert(
                ['key'=>$k],
                ['key'=>$k, 'value'=>$v]
            );
        });
        
    }

    /**
     * 取值
     * @param [type] $key
     * @return void
     */
    public function get($key){
        return $this->settings->get($key);
    }
    /**
     * 获取所有配置的kv值
     * @return void
     */
    public function all($refresh=false){

        //如果要求刷新数据，会强行从数据库中重新读取
        if( $refresh !== false ){
            $this->settings = false;
        }

        //首次获取数据
        if( $this->settings === false ){
            $settings = [];
            $this->rawAll()->each(function($v,$k)use(&$settings){
                $settings[ $v->key ] = $v->value;
            });
            $this->settings = collect($settings);
        }
        return $this->settings;
    }

    /**
     * 原始数据
     *
     * @return void
     */
    public function rawAll(){
        return Setting::orderBy('sort','asc')->get();
    }
        
}