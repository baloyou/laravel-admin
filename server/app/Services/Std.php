<?php
namespace App\Services;
/**
 * 一个空类，用于在没有对象时输出辅助信息
 */
class Std{

    /**
     * 当赋值一个不存在的类属性
     *
     * @param [type] $name
     * @param [type] $value
     */
    function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    //当获取一个不存在的类属性
    function __get($name)
    {
        return '';
    }
}