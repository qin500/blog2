<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="世事无常个人博客网站，刘崇胡个人网站,分享原创文章,个人生活,站长圈子,个人博客">
    <meta name="description"
          content="世事无常网为您提供一个生活分享,it技术分享,前端知识与php以及最新的it前言的技术.刘崇胡个人博客">
    <title>@yield("title"){{ $data->blog_title }}</title>
    <style>
        .icon {
            width: 1em;
            height: 1em;
            vertical-align: -0.15em;
            fill: currentColor;
            overflow: hidden;
        }
    </style>
    <link href="/home/css/prism.css" type="text/css" rel="stylesheet">
    <link href="/home/css/font_2113112_ayxk7kfe5d6.css" rel="stylesheet" type="text/css">
    <link href="/lib/css/gl.css" rel="stylesheet" type="text/css">
    <script>
        document.write(`<link href="/home/css/style.css?random${Math.random()}" rel="stylesheet" type="text/css">`)
    </script>
{{--    <link href="/home/css/style.css?i=92299" rel="stylesheet" type="text/css">--}}

</head>
<body>
<header>
    <div class="tophead">
        <div class="wp">
            <div class="welcome">您好,朋友 现在是 <span class="time"></span></div>
            <div class="access">
                <a class="login" id="login_topbtn" >登录</a>
                <div class="login_succ" >
                    <a class="user" href="#"><img class="avatar" src="{{ $data->avatar }}" alt=""><span>在路上</span></a>
                    <div class="dropmenu">
                        <a target="_blank" data-dashboard href="{{ route('Admin::index') }}">后台首页</a>
                        <a data-artnew href="/p/newart">文章发布</a>
                        <a data-categoies href="/categories">分类管理</a>
                        <a data-updatepwd href="/access/update">密码修改</a>
                        <a data-logout href="{{ route('Admin::logout') }}">退出系统</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="wp">
        <div class="logo">
            <a href="/">在路上个人博客</a>
        </div>
        <ul id="topmenu">
            <li class="item active"><a href="/">网站首页</a></li>
            <li class="item"><a href="/tool">在线工具</a></li>
            <li class="item"><a href="/">给我留言</a></li>
            <li class="item"><a href="/about">关于我</a></li>
        </ul>
    </div>

</header>


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

<div id="search">
    <form action="{{ route("Home::index") }}" method="get">
    <div class="search-warp">
        <input type="text" name="text" value="{{  request()->input('text') }}" class="text" placeholder="请输入要查询的关键字">
        <button class="button"  type="submit">搜索</button>
    </div>
    </form>
</div>
<div class="container wp">
    <main>
        @section("content")
        @show


    </main>
    @if(in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ["Home::index","Home::article","Home::tag","Home::category"]))
    <aside>
        <div class="content-right">
            <div class="site-author">
                <div class="author-photo">
                    <a href="#"><img src="{{ $data->avatar }}" alt=""></a>
                </div>
                <p class="author-name">在路上</p>
                <div class="author-more">
                    <dl class="data-count">
                        <dt>
                            文章
                        </dt>
                        <dd>{{ $data->art_count }}</dd>
                    </dl>
                    <dl class="data-count">
                        <dt>
                            标签
                        </dt>
                        <dd>{{ $data->cat_count }}</dd>
                    </dl>
                    <dl class="data-count">
                        <dt>
                            分类
                        </dt>
                        <dd>{{ $data->cat_count }}</dd>
                    </dl>

                </div>
            </div>
            <div class="widget">
                <h3 class="title">
                    热门文章
                </h3>
                <div class="cont">
                    <ul class="newarts">
                        @foreach($data->hot_art10 as $k=>$v)
{{--                            dd($data->art_art10[0]->title);--}}
                            <li><a href="{{ route('Home::article',[$v->id]) }}">{{ $v->title }}</a></li>

                        @endforeach


                    </ul>
                </div>
            </div>
            <div class="widget">
                <h3 class="title">
                    标签云
                </h3>
                <div class="cont">
                    <div class="tagcloud clx">
                        @foreach($data->all_tags as $k=>$v)
                            <a href="{{ route('Home::tag',[$v->name]) }}">{{ $v->name }}</a>
                        @endforeach

                </div>
            </div>
        </div>
        </div>
    </aside>
    @endif
</div>
<footer>
    <div class="ftnav wp">
        <a href="#">网站地图</a>
        <a href="#">标签集合</a>
        <a href="#">所有文章</a>
        <a href="#">在线工具</a>
        <a href="#">关于我们</a>
    </div>
    <div class="ft-desc wp ">
        <p>在路上个人博客网站 版权所有2023</p>
        <p>程序设计:刘崇胡</p>
        <p data-copyright=""></p>
        <p>大脑用时: <span class="special">{{ microtime(true) - $data->starttime }}</span> (s)</p>
    </div>
</footer>
<div class="fix-evident">
    @if(\Illuminate\Support\Facades\Route::currentRouteName() == "Home::article")
        <span class="item" >
        <a href="{{ route('Admin::article.edit',[$article]) }}" data-editarticle="">
            <i class="iconfont icon-edit"></i>
        </a>
    </span>
    @endif

    <span class="item">
        <a data-scrolltop="">
            <i class="iconfont icon-zhiding"></i>
        </a>
    </span>
</div>
<script src="/home/js/prism.js"></script>
<script src="/tinymce/tinymce.min.js"></script>
<script src="/lib/js/common.js"></script>
<script src="/home/js/script.js?rand=999"></script>
@section("footer")
@show
</body>
</html>
