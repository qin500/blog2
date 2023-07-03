@extends("home.default")
@section("title",$article->title . " - ")
@section('content')

    <div class="article">
        <h1>{{ $article->title }}</h1>
        <p class="state"><span class="dd"><b>日期:</b> {{ $article->created_at }}</span> <span
                class="dd"><b>浏览:</b> {{ $article->views }}</span>
            <span><b>分类:</b> <a href="{{ route('Home::category',[$article->cid]) }}">{{ \App\Models\Category::find($article->cid)->name ?? '未分类' }}</a> </span>

        </p>
        <div class="article_detail">{!! $article->log_text !!}</div>
        <p class="tags">
            <span class="lab">标签 : </span>
            <a href="#">PHP</a>
            <a href="#">laravel</a>
            <a href="#">分页</a>
        </p></div>
        <div class="neighbor">
            @if($article_prev)
                <p>上一篇 : <a
                        href="{{ route("Home::article",[$article_prev['id']]) }}">{{ $article_prev['title'] }}</a></p>
            @else
                <p>上一篇 : <a>没有了</a></p>
            @endif

            @if($article_next)
                <p>下一篇 : <a
                        href="{{ route("Home::article",[$article_next['id']]) }}">{{ $article_next['title'] }}</a></p>
            @else
                <p>下一篇 : <a>没有了</a></p>
            @endif
        </div>

        <div class="post-my">

            <div class="avatar">
                <a href="#"><img src="{{ $data->avatar }}" alt=""></a>
            </div>
            <div class="dt">
                <h3>{{ $data->username }}</h3>
                <p class="xd">{{ $data->say }}!</p>
            </div>
            <div class="qr">
                <img src="{{ $data->avatar }}" alt="">
            </div>

        </div>

        <div class="randpost">
            <h3 class="title">随机图文</h3>
            <ul class="randpost_warp">
                <li><a href="/p/1053">/var/log/mysqld.log 中找不到临时密码</a></li>
                <li><a href="/p/1078">mysql常用命令</a></li>
                <li><a href="/p/1068">js Document 对象属性和方法</a></li>
                <li><a href="/p/1062">电脑安全常用命令</a></li>
                <li><a href="/p/1115">2222</a></li>
                <li><a href="/p/1064">centos安装php+mysql+nginx</a></li>
                <li><a href="/p/1061">Wget快速扒网站源码</a></li>
                <li><a href="/p/1121">11111111111</a></li>
            </ul>
        </div>

@endsection
@section("footer")
    <script>







    </script>
@endsection
