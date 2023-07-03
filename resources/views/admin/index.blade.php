@extends("admin.default")
@section('title',"首页")
@section('content')


    <div class="title">
        后台首页
    </div>
    <div class="cont">
        <div class="cont-t">
            <p class="title"> </p>
            <div class="dashboard">

        <p class="title"> </p>
        <div class="dashboard">
            <p class="q5nav_title">数据统计</p>

            <div class="boat">
                <div class="item">
                    <p><i class="iconfont icon-svgwrite"></i></p>
                    <p><b>文章 <small>/</small></b> <span>{{ $data->art_count }}</span></p>
                </div>
                <div class="item">
                    <p><i class="iconfont icon-categories"></i></p>
                    <p><b>分类 <small>/</small></b> <span>{{ $data->cat_count }}</span></p>
                </div>
                <div class="item">
                    <p><i class="iconfont icon-tag"></i></p>
                    <p><b>标签 <small>/</small></b> <span>{{ count($data->all_tags) }}</span></p>
                </div>
                <div class="item">
                    <p><i class="iconfont icon-view"></i></p>
                    <p><b>浏览 <small>/</small></b> <span>35</span></p>
                </div>
            </div>

            <p class="q5nav_title">系统信息</p>
            <div class="sysinfo">
                <div class="item">
                    <span>系统信息</span>
                    <span>{{ php_uname() }}</span>
                </div>
                <div class="item">
                    <span>服务器软件</span>
                    <span>{{  $_SERVER['SERVER_SOFTWARE'] ?? '' }}</span>
                </div><div class="item">
                    <span>服务器协议</span>
                    <span>{{   $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0' }}</span>
                </div>
                <div class="item">
                    <span>系统时间</span>
                    <span>{{ date('Y-m-d H:i:s') }}</span>
                </div><div class="item">
                    <span>本机ip</span>
                    <span>{{ $_SERVER['HTTP_CF_CONNECTING_IP'] ??  $_SERVER['REMOTE_ADDR'] }}</span>
                </div>
                <div class="item">
                    <span>数据库</span>
                    <span>{{ env('DB_DATABASE') }}</span>
                </div><div class="item">
                    <span>PHP版本</span>
                    <span>{{ PHP_VERSION }}</span>
                </div>
                <div class="item">
                    <span>根目录</span>
                    <span>{{ realpath(".") }}</span>
                </div>
                <div class="item">
                    <span>运行时间</span>
                    <span>192.168.1.1</span>
                </div>
                <div class="item">
                    <span>数据库类型</span>
                    <span>{{ env('DB_CONNECTION') }}</span>
                </div>
                <div class="item">
                    <span>最大文件上传</span>
                    <span>{{ ini_get("post_max_size") }}</span>
                </div>
                <div class="item">
                    <span>连接状态</span>
                    <span>{{ $_SERVER['HTTP_CONNECTION'] }}</span>
                </div>

            </div>
        </div>
            </div>
        </div>
    </div>
    </div>
@endsection
