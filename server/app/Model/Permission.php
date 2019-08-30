<?php

namespace App\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * 为了方便管理，做一个自己的 permission model
 */
class Permission extends SpatiePermission{

    /**
     * 将结果转为多维数组
     * $data = [
     *      id => ['model'=>$model,'childs'=>[]]
     * ]
     * @return void
     */
    public function tree(){
        $pmts = $this->get();
        $result = [];
        foreach($pmts as $pmt){
            if( $pmt->pid == 0 ){
                $result[ $pmt->id ]['data'] = $pmt;
            }else{
                $result[ $pmt->pid ]['childs'][] = $pmt;
            }
        }
        return $result;
    }  
}