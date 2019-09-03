@extends('layouts.app')

@section('content')

@component('components.subtitle')
<i class="fas fa-users fa-fw"></i> 所有用户
@slot('bnts')
@can('user-manager')
<a href='{{route("user-add")}}' class='btn btn-primary'>
    <i class="fas fa-plus-square fa-fw"></i> 添加
</a>
@endcan

@endslot
@endcomponent

<div class="row">
    <div class='col-md-12 mb-3'>
        <form>
            <div class="form-row">
                <div class="col-md-3 col-xs-12">
                    <input type="text" name='keyword' class="form-control" placeholder="支持昵称、手机号、email的模糊搜索" value='{{$search->keyword}}'>
                </div>
                <div class="col-auto">
                    <input type="submit" class="form-control btn btn-outline-primary" value='搜索'>
                </div>
                <div class=' col-auto ml-auto'>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @foreach($roleMenu as $role)
                        <?php $ed = $search->role_id == $role->id ? '' : '-outline'; ?>
                        <a href='{{route("user",["role_id"=>$role->id])}}' class="btn btn{{$ed}}-primary">{{$role->name}}</a>
                        @endforeach
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class='col-md-12'>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">昵称</th>
                    <th scope="col">用户组</th>
                    <th scope="col">登录名</th>
                    <th scope="col">email</th>
                    <th scope="col">手机号</th>
                    <th scope="col">状态</th>
                    <th scope="col">创建日期</th>
                    <th scope="col">管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>
                        @foreach($user->roles as $role)
                        {{$role->name}}<br />
                        @endforeach
                    </td>
                    <td>{{$user->login_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>
                    @can('user-manager')
                        <a href='#' class='btn_confirm' data-msg='你正在切换用户状态（被禁用的账号不能登陆系统）' data-href='{{route("user-state",["id"=>$user->id])}}'>{!!$user->state_text!!}</a>
                    @else 
                        {!!$user->state_text!!}
                    @endcan
                    </td>
                    <td>{{$user->created_at}}</td>
                    <td>
                    @can('user-manager')
                        <a class='btn btn-sm btn-secondary' href='{{route("user-add",["id"=>$user->id])}}'>编辑</a>
                    @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->appends(request()->all())->links() }}
    </div>
</div>
@endsection