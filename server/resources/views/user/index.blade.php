@extends('layouts.app')

@section('content')

@component('components.subtitle')
<i class="fas fa-users fa-fw"></i> 所有用户
@slot('bnts')
<a href='{{route("user-add")}}' class='btn btn-primary'>
    <i class="fas fa-plus-square fa-fw"></i> 添加
</a>
@endslot
@endcomponent

<div class="row">
    <div class='col-md-12 mb-3'>
        <form>
            <div class="row">
                <div class="col-2">
                    <input type="text" class="form-control" placeholder="用户名">
                </div>
                <div class="col-2">
                    <input type="text" class="form-control" placeholder="用户等级">
                </div>
                <div class="col-1">
                    <input type="submit" class="form-control btn btn-outline-primary" value='搜索'>
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
                    <th scope="col">身份</th>
                    <th scope="col">登录名</th>
                    <th scope="col">email</th>
                    <th scope="col">手机号</th>
                    <th scope="col">创建日期</th>
                    <th scope="col">管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}

                    </td>
                    <td>
                    @foreach($user->roles as $role)
                        {{$role->name}}<br/>
                    @endforeach
                    </td>
                    <td>{{$user->login_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->created_at}}</td>
                    <td><a class='btn btn-sm btn-secondary' href='{{route("user-add",["id"=>$user->id])}}'>编辑</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->appends(request()->all())->links() }}
    </div>
</div>
@endsection