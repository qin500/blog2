@extends("home.default")
@section("title",( \Illuminate\Support\Facades\Route::input("category")->name ?? "") . " - ")
@section('content')

    <div class="artList">
        <h2 class="title">分类: {{ \Illuminate\Support\Facades\Route::input("category")->name ?? "" }}</h2>
        <ul class="newArticle">
            @foreach($articles as $k=>$v)
                <li class="item">
                    <a target="_blank" href="{{ route('Home::article',[$v->id]) }}">
                        <i><img src="{{ $v->cover }}" alt="11111111111"></i>
                        <h2>{{ $v->title }}</h2>
                    </a>
                    <p>{!! mb_substr(strip_tags($v->strip_text),0,200) !!}</p>
                    <div class="article-lists-detail">
                        <span class="date"><i class="iconfont icon-date1"></i>{{ $v->created_at }}</span>
                        <span class="date"><i class="iconfont icon-eye"></i>{{ $v->views }}</span>
                        
                    </div>
                    <a target="_blank" href="{{ route('Home::article',[$v]) }}" class="article-lists-view">阅读更多</a>
                </li>
            @endforeach
        </ul>
    </div>

@endsection
