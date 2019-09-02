<?php
/**
 * 在各种需求下，生成下拉select表单
 */

$name = isset($data['name']) ? $data['name'] : 'select';
$id = isset($data['id']) ? $data['id'] : $name;

//更多的扩展属性，直接传字符串就好
$extra = isset($extra) ? " ".$extra : '';
?>
<select class="form-control" name='{{$name}}' id='{{$id}}'{{ $extra }}>
    @foreach($data['data'] as $key => $item)
    <?php $ed = $key == $data['default'] ? " selected" : ""?>
    <option value="{{$key}}"{{$ed}}>{{strip_tags($item)}}</option>
    @endforeach
</select>