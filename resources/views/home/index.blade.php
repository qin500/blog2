@extends("home.default")
@section('content')

    <div class="artList">
        <h2 class="title">{{ request()->input('text') =="" ? '最新文章':"文章搜索" }}</h2>
        <ul class="newArticle">
            @foreach($list as $k=>$v)
                <li class="item">
                    <a target="_blank" href="{{ route('Home::article',[$v->id]) }}">
                        <i>
                            <img src="{{ $v->cover }}" alt="11111111111">
                        </i>
                        <h2>{{ $v->title }}</h2>
                    </a>
                    <p>{!! mb_substr(strip_tags($v->strip_text),0,200) !!}</p>
                    <div class="article-lists-detail">
                        <span class="date"><i class="iconfont icon-date1"></i>{{ $v->created_at }}</span>
                        <span class="date"><i class="iconfont icon-eye"></i>{{ $v->views }}</span>
                        <span class="date"><i class="iconfont icon-folder"></i><a
                                href="{{ route('Home::category',[$v->cid]) }}">{{ \App\Models\Category::find($v->cid)->name ?? '未分类' }}</a></span>
                    </div>
                    <a target="_blank" href="{{ route('Home::article',[$v->id]) }}" class="article-lists-view">
                        阅读更多
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{ $list->appends(["text"=>request()->input('text')])->links("custom.default") }}

@endsection
@section('footer')
    <script>


        // window.addEventListener('online',aaa)
        // window.addEventListener('offline',aaa)
        //
        // function aaa() {
        //     console.log("aaaaaaaaaaaaaaaaa")
        // }
        window.addEventListener('online', function () {
            // 在线状态
            console.log('在线')
        });

        window.addEventListener('offline', function () {
            // 离线状态
            console.log('离线')
        });


        let search = document.querySelector('#search'),
            text = search.querySelector('[name="text"]').value;
        let artList = document.querySelectorAll('.artList h2')
        let desc = document.querySelectorAll('.artList .item p')
        if (text !== "") {
            //判断是否为搜索的页面

            artList.forEach(function (el, key) {
                const regex = new RegExp(text, 'gi');
                const replacedText = el.innerText.toString().replace(regex, function (match) {
                    return `<span style="color:red">${match}</span>`;
                });
                el.innerHTML = replacedText;
            });

            desc.forEach(function (el, key) {
                if (el.innerText.indexOf(text) > -1) {
                    el.innerHTML = el.innerText.toString().replace(new RegExp(text, 'gi'), function (match) {
                        return `<span style="color:red">${match}</span>`;
                    })
                }
            })


        }


    </script>

@endsection
