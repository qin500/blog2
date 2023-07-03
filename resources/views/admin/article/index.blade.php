@extends("admin.default")
@section('title',"文章列表")
@section('content')

    <div class="title">
        文章列表
    </div>
    <div class="cont">
        <div class="cont-t">

            <div class="q5row">
                <a target="_blank" href="{{ route('Admin::article.create') }}" class="q5button">添加新文章</a>
            </div>
            <p class="q5nav_title">文章查询</p>
            <div>
                <form action="">
                    <div class="q5input line"><label class="lab">标题</label><input name="title" class="form-control" type="text"><input
                            type="submit" class="btn" value="搜索"></div>


                </form>
            </div>
            <p class="q5nav_title">列表</p>
            <div class="q5table">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>分类</th>
                        <th>浏览</th>
                        <th>日期</th>
                        <th>操作</th>
                    </tr>
                    @foreach($articles  as $k=>$v)
                        <tr>
                            <td>{{ $k }}</td>
                            <td><a class="link" target="_blank"
                                   href="{{ route('Home::article',[$v]) }}">{{ $v['title'] }}</a></td>
                            <td><a class="link" target="_blank"
                                   href="{{ route('Home::category',[$v->cid]) }}">{{ \App\Models\Category::find($v->cid)->name }}</a>
                            </td>
                            <td>{{ $v['views'] }}</td>
                            <td>{{ $v['updated_at'] }}</td>
                            <td>
                                <a class="btn" href="{{ route('Admin::article.edit',[$v]) }}">编辑</a>
                                <a class="btn">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>


            </div>


        </div>
    </div>

@endsection

@section('script')

    <script>


    </script>
@endsection

