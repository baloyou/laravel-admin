@extends('layouts.app')

@section('content')

@component('components.subtitle')
<i class="fas fa-users fa-fw"></i> 系统设置
@slot('bnts')
@endslot
@endcomponent

<div class="row">
    <div class='col-xl-6 col-md-12'>
        <form action='{{route("setting-save")}}' method='post'>
            @csrf

            @foreach($settings as $item)
            <div class="form-group row">
                <label for="login_name" class="col-sm-2 col-form-label">{{$item->name}}</label>
                <div class="col-sm-10">
                    <input name='settings[{{$item->key}}]' type="text" class="form-control" value='{{$item->value}}'>
                    <span class='text-secondary form-msg'>{!! $item->desc !!}</span>
                </div>
            </div>
            @endforeach

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection