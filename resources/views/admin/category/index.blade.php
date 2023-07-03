@extends("admin.default")
@section('title',"文章列表")
@section('content')

    <div class="title">
        分类列表
    </div>
    <div class="cont">
        <div class="cont-t">
            <div class="q5row">
                <a target="_blank" date-add href="{{ route('Admin::category.create') }}" class="q5button">添加分类</a>
            </div>

            <p class="q5nav_title">列表</p>
            <div id="category_list" class="q5table">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>文章总数</th>
                        <th>日期</th>
                        <th>操作</th>
                    </tr>
                    @foreach($categorys  as $k=>$v)
                        <tr>
                            <td>{{ $k }}</td>
                            <td><a class="link" target="_blank"
                                   href="">{{ $v['name'] }}</a></td>
                            <td>{{ $v['total'] }}</td>
                            <td>{{ $v['updated_at'] }}</td>
                            <td>
                                <a class="btn" date-edit href="{{ route('Admin::category.edit',[$v]) }}">编辑</a>
                                <a class="btn" data-del href="{{ route('Admin::category.destroy',[$v]) }}">删除</a>
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

        let addbtn = document.querySelector('[date-add]'),
            category_list = document.querySelector('#category_list'),
            editbtn = document.querySelectorAll('[date-edit]'),
            delbtn = document.querySelectorAll('[data-del]')

        editbtn.forEach((el) => {
            el.addEventListener('click', editData)
        })
        delbtn.forEach((el) => {
            el.addEventListener('click', delData)
        })
        addbtn.addEventListener('click', addData)

        function delData(e) {
            e.preventDefault()

            let link=e.target.href;
            fetch(link,{
                method:'post',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body:'_method=DELETE'
            }).then(res=>{
                return res.json()
            }).then(o=>{
                if(o.code == 200){
                    Qin500.notify("success",'删除成功');
                    e.target.closest('tr').remove()
                }else{
                    Qin500.notify('danger',o.msg)
                }
            })

        }

        function editData(e) {
            e.preventDefault()
            Qin500.popw("编辑分类", {url: e.target.getAttribute('href')}, function (o) {
                if(o.code == 200){

                    Qin500.notify("success",'更新成功',1000,function () {
                        location.reload()
                    });
                }else{
                    Qin500.notify('danger',o.msg)
                }
            })
        }

        function addData(e) {
            e.preventDefault()
            Qin500.popw("添加分类", {url: "{{ route('Admin::category.create') }}"}, function (o) {
                if(o.code == 200){
                    Qin500.notify("success",'添加成功')
                }else{
                    Qin500.notify('danger',o.msg)
                }
            })
        }


    </script>
@endsection

