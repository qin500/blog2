<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title") - 后台管理</title>
    <link href="/senior/css/font_4141426_ed49km6qd9s.css" type="text/css" rel="stylesheet"/>
    <link href="/lib/css/gl.css" type="text/css" rel="stylesheet"/>
    <link href="/senior/css/style.css" type="text/css" rel="stylesheet"/>

</head>
<body>

<div class="panel">
    <div class="panel_left">
            @include("admin.aside")
    </div>
    <div class="panel_right">
        <div class="top">
            <div class="short_left">
                <a class="menu_btn"><i class="iconfont icon-menu"></i></a>
                <p class="notificaion">系统信息:111</p>
            </div>

            <div class="short_right">
                <a class="item"><i class="iconfont icon-feather"></i>写文章</a>
                <a href="{{ route('Home::index') }}" target="_blank" class="item" alt="前台首页"><i class="iconfont icon-home"></i></a>
                <a class="item"><i class="iconfont icon-setting"></i></a>
                <a class="item"><i class="iconfont icon-fullscreen-expand"></i></a>
                <div class="user_cent">
                    <p class="i_user">
                        <a class="i_u"><span class="nick">在路上</span><img class="avatar" src="{{ $data->avatar }}" alt=""></a>

                    </p>
                </div>
            </div>
        </div>
        <div class="main">
            @section("content")
            @show

        </div>
    </div>
</div>
<script src="/lib/js/common.js"></script>
@section('script')
@show
</body>
</html>
