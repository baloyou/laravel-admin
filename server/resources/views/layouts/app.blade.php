<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'admin panel') }}</title>

    <!-- Scripts -->
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src='https://cdn.bootcss.com/twitter-bootstrap/4.3.1/js/bootstrap.min.js'></script>
    <script src="{{ asset('js/sb-admin.min.js') }}?<?php echo microtime();?>" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/blackrockdigital.css') }}" rel="stylesheet">
    <link href="{{ asset('css/project.css') }}?<?php echo microtime(); ?>" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">Admin CP</a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('logout')}}">退出</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('home')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>控制中心</span>
                </a>
            </li>

            <?php
            //取菜单列表，此处可以做缓存，能够有效的提高速度
            $menu = new \App\Model\Menu;
            $data = $menu->tree();
            ?>
            @foreach($data as $item)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw {{$item['data']->icon}}"></i>
                    <span>{{$item['data']->name}}</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    @foreach($item['childs'] as $item2)
                    <a class="dropdown-item" href="{{$item2->link}}">{{$item2->name}}</a>
                    @endforeach
                </div>
            </li>
            @endforeach
            
        </ul>
        <div id="content-wrapper">
            <div class="container-fluid">
                @if (session('msg'))
                <div style="position: relative;">
                    <div class="toast bg-warning" role="alert" data-autohide='true' data-delay="2000" style="position: absolute; top: 0; left: 0;z-index:1001;max-width:none;">
                        <div class="toast-header">
                            <i class="fas fa-fw fa-exclamation-circle"></i>  
                            <strong class="mr-auto">信息提示</strong>
                        </div>
                        <div class="toast-body" style='width:400px;'>
                            {{session('msg')}}
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $(".toast").toast('show');
                    });
                </script>
                @endif
                @section('content')
                @show
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>My Project</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->
    </div>
    @component("components.alert")
    @endcomponent
</body>

</html>