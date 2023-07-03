<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>系统登录</title>
    <link href="/senior/css/font_4141426_ed49km6qd9s.css" type="text/css" rel="stylesheet"/>
    <link href="/lib/css/gl.css" type="text/css" rel="stylesheet"/>
    <link href="/senior/css/style.css" type="text/css" rel="stylesheet"/>
</head>

<body>
<div class="login_alone">
    <div class="login_bin">
        <form>
            <h1>后台管理登录</h1>
            <div class="input-box">
                <span class="ico"> <i class="iconfont icon-user"></i></span>
                <input name="username" type="text" placeholder="管理员名称">
            </div>
            <div class="input-box">
                <span class="ico"> <i class="iconfont icon-3701mima"></i></span>
                <input name="password" type="password" placeholder="管理员密码">
            </div>
            <div class="input-box">
                <input name="submit" type="submit" value="登录">
            </div>
        </form>

    </div>
</div>

<script src="/lib/js/common.js"></script>
<script>
    let login_form = document.querySelector('.login_alone form'),
        username = login_form.querySelector('[name="username"]'),
        password = login_form.querySelector('[name="password"]'),
        submit = login_form.querySelector('[name="submit"]')

    login_form.addEventListener('submit', function (e) {
        e.preventDefault()
        if (username.value === "") {
            Qin500.notify("info", "请输入管理员名称")
            return;
        }
        if (password.value === "") {
            Qin500.notify("info", "请输入管理员密码")
            return;
        }

        fetch("{{ route('Auth::login')  }}", {
            method: 'post',
            headers: {
                "Content-Type": 'application/x-www-form-urlencoded',
            },
            body: `username=${username.value}&password=${password.value}`,
        }).then(res => {
            return res.json()
        }).then(x => {
            if (x.code === 200) {
                submit.setAttribute('disabled', 'disabled')
                //第三个参数,使用默认值
                Qin500.notify("success", "登录成功,正在跳转", undefined, function () {
                    let param = new URLSearchParams(location.search);
                    if (param.has('redirect')) {
                        //跳回源地址
                        location.href = decodeURIComponent(param.get('redirect'))
                    } else {
                        //进入后台首页
                        location.href = "{{ route("Admin::index") }}"
                    }
                });

            } else {
                Qin500.notify("danger", x.msg)
            }
        })

    })

</script>
</body>
</html>
