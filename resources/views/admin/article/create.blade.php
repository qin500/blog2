@extends("admin.default")
@section('title',"创建文章 ")
@section('content')

    <div class="title">
        新文章
    </div>
    <div class="cont">
        <div class="cont-t">
            <div class="q5input">
                <label class="lab" for="">标题</label>
                <input name="title" class="form-control" type="text">
            </div>
            <div class="q5input">
                <label class="lab" for="">封面</label>
                <div class="cover" cover></div>
            </div>
            <div class="q5input">
                <label class="lab">分类 <a class="add" data-categoryadd href="{{ route('Admin::category.create') }}">添加分类</a></label>
                <select class="form-control" name="category">
                    <option value="0">请选择分类</option>
                    @foreach($cats as $k=>$v)
                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="q5input">
                <label class="lab" for="">内容</label>
                <div id="q5_content_edit"></div>
            </div>

            <div class="q5input">
                <label class="lab" for="">公开</label>
                <label class="q5radio"><input value="1" checked type="radio" name="publish"><i
                        class="ico"></i>显示</label>
                <label class="q5radio"><input value="0" type="radio" name="publish"><i
                        class="ico"></i>隐藏</label>
            </div>
            <div class="q5input">
                <a id="publish" class="q5button">发布</a>
                <a id="preview" target="_blank" style="display: none" class="q5button btnsuccess">预览</a>
            </div>

        </div>
    </div>

@endsection


@section('script')
    <script src="/tinymce/tinymce.min.js"></script>

    <script>

        let dataCategoryadd = document.querySelector('[data-categoryadd]');
        dataCategoryadd.addEventListener("click", addData)
        let cover = document.querySelector('[cover]')

        cover.addEventListener('click', function (e) {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click()
            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                console.log(file)
                const reader = new FileReader();
                // if ((file.size / 1024 / 1024) > 10) {
                //     Qin500.notify('danger', '文件大小超过10M');
                //     return false;
                // }

                Qin500.uploading("{{ route('Admin::qngenerate_token') }}", "{{ env("QINIU_UPURL") }}", file, function (x) {
                    cover.style.backgroundImage = 'url("' + "{{ env('QINIU_UPPREFIX') }}" + x.key + '")';
                })

            })

        })

        function addData(e) {
            e.preventDefault()
            Qin500.popw("添加分类", {url: "{{ route('Admin::category.create') }}"}, function (o) {
                if (o.code == 200) {
                    let category = document.querySelector('[name="category"]');
                    category.insertAdjacentHTML('beforeend', `<option value="${o.data.id}">${o.data.name}</option>`)
                    //关闭弹窗
                    o.closepop();
                    Qin500.notify("success", '添加成功');
                } else {
                    Qin500.notify('danger', o.msg)
                }
            })
        }

        tinymceInit()

        function tinymceInit() {
            //文章编辑和发布
            tinymce.init({
                selector: '#q5_content_edit',
                min_height: 350,
                max_height: 850,
                contextmenu: 'link image paste',
                language: 'zh-Hans',
                language_url: '/tinymce/langs/zh-Hans.js',
                menubar: false,
                setup: function (editor) {
                    // 添加自定义按钮
                    editor.ui.registry.addButton('mycustombutton', {
                        text: '立即保存',
                        onAction: function () {
                            // 在编辑器中插入文本内容
                            editor.insertContent('这是自定义按钮插入的内容！');
                        }
                    });
                },
                plugins: [
                    'codesample', 'code', 'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount',
                ],
                toolbar: 'table  image undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent link | ' +
                    ' codesample code | preview fullscreen  mycustombutton',

                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                // codesample_global_prismjs: true,
                codesample_languages: [
                    {text: 'HTML/XML', value: 'HTML'},
                    {text: 'JavaScript', value: 'javascript'},
                    {text: 'CSS', value: 'css'},
                    {text: 'PHP', value: 'php'},
                    {text: 'Python', value: 'python'},
                    {text: 'Java', value: 'java'},
                ],

                /* enable title field in the Image dialog*/
                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                paste_data_images: true, // 允许在粘贴时上传图片
                images_upload_url: '{{ route('Admin::uploading') }}', // 图片上传的 URL
                images_upload_handler: function (blobInfo, success, failure) {
                    return new Promise(function (resolve, reject) {
                        Qin500.uploading("{{ route('Admin::qngenerate_token') }}", "{{ env("QINIU_UPURL") }}", blobInfo.blob(), function (x) {
                            resolve("{{ env('QINIU_UPPREFIX') }}" + x.key);
                        }, function () {
                            reject("上传失败")
                        })
                    })


                },
                file_picker_types: 'image',
                file_picker_callback: (cb, value, meta) => {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        console.log(file)
                        const reader = new FileReader();
                        if ((file.size / 1024 / 1024) > 10) {
                            Qin500.notify('danger', '文件大小超过10M');
                            return false;
                        }
                        Qin500.uploading("{{ route('Admin::qngenerate_token') }}", "{{ env("QINIU_UPURL") }}", file, function (x) {
                            cb("{{ env('QINIU_UPPREFIX') }}" + x.key, {title: x.hash})
                        })
                    });

                    input.click();
                },
                setup: function (editor) {
                    editor.on('keydown', function (e) {
                        if (e.ctrlKey && e.key.toLowerCase() === "s") {
                            console.log('按下了组合键')
                            e.preventDefault();
                        }
                    });
                }
            })
        }

        let publish = document.querySelector('#publish');
        let preview = document.querySelector('#preview');

        publish.addEventListener('click', send)


        function send(e) {
            e.preventDefault()
            let title = document.querySelector(`[name="title"]`),
                category = document.querySelector(`[name="category"]`),
                publish = document.querySelector(`[name="publish"]`),
                editor = tinymce.get('q5_content_edit'),
                content = editor.getContent(),
                textContent = editor.getContent({format: 'text'})

            let cover = document.querySelector('[cover]')
            cover = cover.getAttribute('cover')

            if (title.value == "") {
                Qin500.notify('info', "请输入文章标题");
                title.focus()
                return;
            }

            if (category.value == 0) {
                Qin500.notify('info', "请选择分类");
                category.focus()
                return;
            }

            if (content == "") {
                Qin500.notify('info', "请输入文章内容");
                editor.focus()
                return;
            }

            let data = {
                'title': title.value,
                'cid': category.value,
                'log_text': content,
                'strip_text': textContent,
                'publish': publish.value,

            }


            //先获取主图的图片
            let imgurl = "";//如果主图和内容图片都不存在,那就后台系统随机抓取一张图片
            let computedStyle = getComputedStyle(document.querySelector('[cover]'));
            console.log(document.querySelector('[cover]'))
            let backgroundImage = computedStyle.getPropertyValue("background-image");
            if (backgroundImage != "none") {
                imgurl = backgroundImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
                imgurl = (new URL(imgurl)).href;

            } else {
                //如果主图图片不存在,就从内容里面获取一张图片
                let dom = new DOMParser()
                let domparse = dom.parseFromString(content, 'text/html');
                if (domparse.querySelector('img') && domparse.querySelector('img').src) {
                    imgurl = domparse.querySelector('img').src
                    imgurl = (new URL(imgurl)).href;
                } else {
                    imgurl = ''
                }
            }

            data.cover = imgurl;

            if (e.target.innerText == "发布") {
                $p_link = "{{ route('Admin::article.store') }}"
            } else {
                $p_link = e.target.href;
            }

            Qin500.login(function () {
                fetch($p_link, {
                    method: e.target.innerText == "发布" ? 'post' : 'put',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: Qin500.jsonToformurl(data)
                }).then(res => res.json()).then(x => {
                    if (x.code == 200) {
                        if (e.target.innerText == "发布") {
                            e.target.innerText = "保存"
                            e.target.href = x.data.link;
                            //给预览按钮也加上
                            preview.href = x.data.preview;
                            preview.style.display = "block"
                        }
                        Qin500.notify('success', x.msg);
                    } else {
                        Qin500.notify('danger', x.msg);
                    }
                })

            })

        }

    </script>

@endsection
