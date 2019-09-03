@extends('layouts.app')

@section('content')

@component('components.subtitle')
<i class="fas fa-users fa-fw"></i> 用户分组
@slot('bnts')
@can('role-manager')
<a href='{{route("role-add")}}' class='btn btn-primary'>
    <i class="fas fa-plus-square fa-fw"></i> 添加
</a>
@endcan
@endslot
@endcomponent

<div class="row">
    <div class='col-md-12'>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">昵称</th>
                    <th scope="col">创建日期</th>
                    <th scope="col">管理</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <th scope="row">{{$role->id}}</th>
                    <td>{{$role->name}}
                    </td>
                    <td>{{$role->created_at}}</td>
                    <td>
                    @can('role-manager')
                        <a class='btn btn-sm btn-secondary' href='{{route("role-add",["id"=>$role->id])}}'>编辑</a>
                        <a data-msg='你将删除分组（组内包含用户则不能删除）' class='btn btn-sm btn-warning btn_confirm' data-href='{{route("role-remove",["id"=>$role->id])}}' href='#'>删除</a>
                    @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection