@extends('layouts.app')

@section('content')

@component('components.subtitle')
<i class="fas fa-users fa-fw"></i> 所有用户
@slot('bnts')
<a href='{{route("user")}}' class='btn btn-primary'>
    <i class="fas fa-undo-alt fa-fw"></i> 返回
</a>
@endslot
@endcomponent

<div class="row">
    <div class='col-xl-6 col-md-12'>
        <form action='{{route("user-save")}}' method='post'>
            @csrf
            <input type='hidden' name='id' value='{{$form["id"]}}' />

            <div class="form-group row">
                <label for="login_name" class="col-sm-2 col-form-label">登陆名</label>
                <div class="col-sm-10">
                    <input name='login_name' type="text" class="form-control" id="login_name" placeholder="请输入字母、数字、下划线组合" value='{{$form["login_name"]}}'>
                    @if($errors->has('login_name'))
                    <span class='text-danger form-error'>{{$errors->first('login_name')}}</span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">密码</label>
                <div class="col-sm-10">
                    <input name='password' type="password" class="form-control" id="password" placeholder="请输入至少8位密码" value='{{$form["password"]}}'>
                    @if($errors->has('password'))
                    <span class='text-danger form-error'>{{$errors->first('password')}}</span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">昵称</label>
                <div class="col-sm-10">
                    <input name='name' type="text" class="form-control" id="name" placeholder="" value='{{$form["name"]}}'>
                    @if($errors->has('name'))
                    <span class='text-danger form-error'>{{$errors->first('name')}}</span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">邮箱</label>
                <div class="col-sm-10">
                    <input name='email' type="text" class="form-control" id="email" placeholder="" value='{{$form["email"]}}'>
                    @if($errors->has('email'))
                    <span class='text-danger form-error'>{{$errors->first('email')}}</span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label">手机</label>
                <div class="col-sm-10">
                    <input name='phone' type="text" class="form-control" id="phone" placeholder="" value='{{$form["phone"]}}'>
                    @if($errors->has('phone'))
                    <span class='text-danger form-error'>{{$errors->first('phone')}}</span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">归属分组</label>
                <div class='col-sm-10 pmt_checkbox'>
                    @foreach($roles as $role)
                    <?php 
            $ed = array_search($role->id, $form["input_roles"]) !== false ? ' checked' : '';
                    ?>
                    <div class="form-check form-check-inline">
                        <input name='input_roles[]' class="form-check-input" type="checkbox" id="box{{$role->id}}" data-id='{{$role->id}}' value="{{$role->id}}"{{$ed}}>
                        <label class="form-check-label" for="box{{$role->id}}">
                            <span>{{$role->name}}</span>
                        </label>
                    </div>
                    @endforeach
                @if($errors->has('input_roles'))
                    <p class='text-danger form-error'>{{$errors->first('input_roles')}}</p>
                @endif
                </div>
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