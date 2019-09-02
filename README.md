# 全局功能文件

`/app/functions.php`    全局函数库
`/app/services/Std.php`     生成不会报属性不存在的空类
`/app/services/ViewTool.php`    视图辅助工具类（有需要的时候再添）

# 全局方法

## 权限模块

权限需要将中间件附加在路由上才能生效，如果页面中需要检查权限，请使用`@can()` 函数(该函数由laravel内置)

注意：`@can(策略)` 必须事先注册，我“怀疑”permission表中的权限列表，已经被注册过了。

```
if( !can('article-list') ){
    die('无权限')
}
```
### 数据鉴权

如果有需要对数据鉴权，可以专门定制策略，然后`can(策略,$数据模型)`，当然尚未实际应用。

### 超级管理员

目前在 `AuthServiceProvider::boot()` 中通过 `Gate::before` 定义user id = 1为超级管理员，所有权限对其不生效（包括路由定义的、can() 方法定义的）

## 提示框

```
//跳转并生成 msg 闪存session，将触发一个全局提示（3秒后自动关闭）
return back()->with('msg', '提示信息!');
```

## 用户状态常量

```
User::STATE_NORMAL
User::STATE_BAN 
```

## 抛出异常函数 

``tr($msg, $code)`` 

## 生成下拉表单

``select.balde.php`` 是一个组件。

调用方法

```
<?php
$data = [
    'default'   => '默认选中',
    'data'      => 'kv键值对',
    'name/id'   => '表单名',
    'extra'     => '扩展属性字符串'
];
?>

@component('components.select',['data'=>$data])
@endcomponent
```