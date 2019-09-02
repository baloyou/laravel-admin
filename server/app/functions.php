<?php
/**
 * 自定义抛出异常，tr 是 throw 的缩写
 *
 * @param [type] $msg
 * @param integer $code
 * @return void
 */
function tr($msg, $code=1001){
    throw new \App\Exceptions\Operation($msg, $code);
}