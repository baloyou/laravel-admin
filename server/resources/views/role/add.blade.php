@extends('layouts.app')

@section('content')

@component('components.subtitle')
<i class="fas fa-users fa-fw"></i> 用户分组
@slot('bnts')
<a href='{{route("role")}}' class='btn btn-primary'>
    <i class="fas fa-undo-alt fa-fw"></i> 返回
</a>
@endslot
@endcomponent

<div class="row">
    <div class='col-xl-6 col-md-12'>
        <form action='{{route("role-save")}}' method='post'>
            @csrf
            <input type='hidden' name='id' value='{{$form["id"]}}' />
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">分组名称</label>
                <div class="col-sm-10">
                    <input name='name' type="text" class="form-control" id="name" placeholder="请注意，分组名称不能重复" value='{{$form["name"]}}'>

                    @if($errors->has('name'))
                    <span class='text-danger form-error'>{{$errors->first('name')}}</span>
                    @endif

                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">分组权限</label>
                <div class='col-sm-10 pmt_checkbox'>
                    <div class="form-check form-check-inline">
                        <input name='pmts' class="form-check-input" type="checkbox" id="box_all">
                        <label class="form-check-label" for="box_all">全选</label>
                        @if($errors->has('input_pmts'))
                         <span class='text-danger form-error'>{{$errors->first('input_pmts')}}</span>
                        @endif
                    </div>
                    <hr />
                    @foreach($pmts as $id=>$pmt)
                    <?php
                        //控制checkbox 的选中状态
                        $checked = array_search( $id, $form['input_pmts'] ) !== false ? ' checked' : '';
                    ?>

                    <div class="form-check form-check-inline">
                        <input name='input_pmts[]' class="form-check-input" type="checkbox" id="box{{$id}}" data-id='{{$id}}' data-pid='0' value="{{$id}}"{{$checked}}>
                        <label class="form-check-label" for="box{{$id}}">
                            <span class="font-weight-bold">{{$pmt['data']->namecn}}</span>
                        </label>
                    </div>

                    <div id='item_{{$id}}' style='display:inline'>
                        @foreach($pmt['childs'] as $item)
                        <?php
                        //控制checkbox 的选中状态
                        $child_checked = array_search( $item->id, $form['input_pmts'] ) !== false ? ' checked' : '';
                        ?>                        
                        <div class="form-check form-check-inline">
                            <input name='input_pmts[]' class="form-check-input" type="checkbox" id="box{{$item->id}}" data-id='{{$item->id}}' data-pid='{{$item->pid}}' value="{{$item->id}}"{{$child_checked}}>
                            <label class="form-check-label" for="box{{$item->id}}">{{$item->namecn}}</label>
                        </div>
                        @endforeach
                    </div>
                    <hr />

                    @endforeach
                </div>
                <script>
                    /**
                     * 1、选中父，选中所有子
                     * 2、取消父，取消所有子
                     * 3、选中子，自动选中父
                     * 4、取消子，如果所有子都没了，就自动取消父；否则保留父
                     */
                    var boxs = $(".pmt_checkbox .form-check-input");

                    $("#box_all").click(function() {
                        $(".form-check-input").prop('checked', $(this).prop('checked'));
                    });

                    boxs.click(function() {
                        var id = $(this).attr('data-id');
                        var pid = $(this).attr('data-pid');
                        var state = $(this).prop('checked');
                        //父带子
                        if (pid == 0) {
                            $("#item_" + id + " .form-check-input").prop('checked', state);
                        }

                        //子带父
                        if (pid > 0) {
                            $("#box" + pid).prop('checked', false);
                            $("#item_" + pid + " .form-check-input").each(function() {
                                //任意一个为true，则父为 true
                                if ($(this).prop('checked')) {
                                    $("#box" + pid).prop('checked', true);
                                }
                            });
                        }
                    });
                </script>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection