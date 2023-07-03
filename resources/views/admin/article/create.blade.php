@extends("admin.default")
@section('title',"编辑文章 ")
@section('content')

    <div class="title">
        新文章
    </div>
    <div class="cont">
        <div class="cont-t">
            <div class="q5input">
                <label class="lab" for="">标题</label>
                <input class="form-control" type="text">
            </div>
            <div class="q5input">
                <label class="lab" for="">分类</label>
                <select class="form-control" name="" id="">
                    <option value="0">请选择分类</option>
                    <option value="1">属性</option>
                </select>
            </div>
            <div class="q5input">
                <label class="lab" for="">内容</label>
                <div id="q5_content_edit"></div>
            </div>

            <div class="q5input">
                <label class="lab" for="">公开</label>
                <label class="q5radio"><input value="1" type="radio" checked="" name="isshow"><i
                        class="ico"></i>显示</label>
                <label class="q5radio"><input value="1" type="radio" checked="" name="isshow"><i
                        class="ico"></i>隐藏</label>
            </div>
            <div class="q5input">
                <a   class="q5button">发布</a>
                <a class="q5button btnsuccess">预览</a>
            </div>

        </div>
    </div>

@endsection


@section('script')
    <script src="/tinymce/tinymce.min.js"></script>

    <script>


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
                images_upload_url: '/uploading', // 图片上传的 URL
                images_upload_handler: function (blobInfo, success, failure) {
                    return new Promise(function (resolve, reject) {
                        Qin500.uploading(blobInfo.blob(), function (x) {
                            resolve(x.url);
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
                        Qin500.uploading(file, function (x) {
                            cb(x.url, {title: x.name})
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

    </script>

@endsection
