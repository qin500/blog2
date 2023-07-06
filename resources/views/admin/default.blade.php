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
                <a id="toggle_menubtn" class="menu_btn"><i class="iconfont icon-menu"></i></a>
                <p class="notificaion">系统信息:111</p>
            </div>

            <div class="short_right">
                <a class="item" href="{{route('Admin::article.create')}}"><i
                        class="iconfont icon-feather"></i>写文章</a>
                <a href="{{ route('Home::index') }}" target="_blank" class="item" alt="前台首页"><i
                        class="iconfont icon-home"></i></a>
                <a class="item"><i class="iconfont icon-setting"></i></a>
                <a class="item" id="fullscreenBtn"><i class="iconfont icon-fullscreen-expand"></i></a>
                <div class="user_cent">
                    <p class="i_user">
                        <a class="i_u"><span class="nick">在路上</span><img class="avatar" src="{{ $data->avatar }}"
                                                                            alt=""></a>

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




<div id="login_panel" class="login_panel">
    <div class="login_warp">
        <span class="close" title="关闭">×</span>
        <form action="/login" method="post" enctype="application/x-www-form-urlencoded">
            <h2>系统登录</h2>
            <p class="message"></p>
            <div>
                <label>账号</label>
                <input name="username" type="text" placeholder="请输入你的用户名">
            </div>
            <div>
                <label>密码</label>
                <input name="password" type="password" placeholder="请输入你的密码">
            </div>


            <input type="submit" name="submit" value="立即登录">
        </form>
    </div>
</div>
<script src="/lib/js/common.js"></script>
@section('script')
@show


<script>
    let fullscreenBtn = document.getElementById("fullscreenBtn");
    let toggle_menubtn = document.getElementById("toggle_menubtn");
    window.addEventListener('load',function () {
        let panel=document.querySelector('.panel');
        if(localStorage.getItem('admin_toggle')) {
            if(localStorage.admin_toggle === "on"){
                panel.classList.add('toggle')
            }else {
                panel.classList.remove('toggle')
            }
        }
    })
    toggle_menubtn.addEventListener('click',function (e) {
        let panel=document.querySelector('.panel');
        panel.classList.toggle('toggle')
        Array.from(panel.classList).includes('toggle') ? localStorage.setItem('admin_toggle','on'):localStorage.setItem('admin_toggle','off')

    })
    fullscreenBtn.addEventListener("click", function () {
        if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }

        }
    });


</script>
</body>
</html>
