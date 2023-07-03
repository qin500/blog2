Qin500 = {
    formatDate: function (type = "default") {
        if (type === "default") {
            let date = new Date();
            let d = date.getFullYear().toString() + "-" + (date.getMonth() + 1).toString().padStart(2, "0") + "-" +
                date.getDate().toString() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds().toString().padStart(2, '0');
            return d;
        }
    },
    jsonToformurl: function (data) {
        let urlstr = ""
        for (const a in data) {
            urlstr += a + "=" + encodeURIComponent(data[a]) + "&"
        }
        return urlstr.slice(0, -1);
    },
    uploading: function (file, success, failure) {
        Qin500.login(function (x) {
            let xhr = new XMLHttpRequest(),
                form = new FormData();
            form.append('file', file);
            xhr.withCredentials = true;
            xhr.open("POST", "/uploading");
            // xhr.setRequestHeader("Content-Type", 'multipart/form-data')
            xhr.send(form);
            xhr.onload = function (e) {
                if (xhr.status === 200) {
                    let str = JSON.parse(xhr.responseText);
                    if (str.code == 1) {
                        success && success(JSON.parse(xhr.responseText))
                    } else if (str.code == 0) {
                        failure && failure()
                    }
                } else {
                    failure && failure()
                }
            }
        })

    },
    login: function (callback) {

        fetch("/login", {
            headers: {
                "Content-Type": 'application/x-www-form-urlencoded'
            },
            method: 'post',
        }).then(Response => {
            return Response.json()
        }).then(r => {
            //如果已经登录
            if (r.code == 201) {
                callback && callback(true);
            } else {

                let login_panel = document.querySelector('#login_panel');
                login_panel.querySelector('.close').addEventListener('click', function (e) {
                    login_panel.style.display = "none"
                });
                login_panel.style.display = "flex"
                login_panel.querySelector("form").addEventListener('submit', function (e) {
                    let username = login_panel.querySelector('[name = "username"]');
                    let password = login_panel.querySelector('[name = "password"]');
                    let message = login_panel.querySelector('.message');
                    if (username.value === "") {
                        Qin500.notify("info", "请输入用户名!")
                        e.preventDefault();//阻止表单提交
                        return false;//阻止程序往下执行
                    }
                    if (password.value === "") {
                        Qin500.notify("info", "请输入密码!")
                        e.preventDefault()
                        return false;
                    }

                    fetch("/login", {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `username=${username.value}&password=${password.value}`
                    }).then((response) => {
                        return response.json();
                    }).then((d) => {
                        if (d.code == 200) {
                            Qin500.notify("success", "登录成功")
                            document.querySelector("#login_topbtn").style.display = "none"
                            document.querySelector("#login_topbtn").nextElementSibling.style.display = "block"
                            login_panel.querySelector('[name="submit"]').setAttribute('disabled', 'disabled')
                            setTimeout(() => {
                                login_panel.style.display = "none"
                                username.value = ""
                                password.value = ""
                                login_panel.querySelector('[name="submit"]').removeAttribute('disabled')
                            }, 1000);
                            callback && callback()
                        } else {
                            Qin500.notify("danger", d.msg)
                        }
                    })
                    e.preventDefault()
                    return false
                })
            }
        })

    },
    isLogin: function (callback) {
        fetch("/login", {
            headers: {
                "Content-Type": 'application/x-www-form-urlencoded'
            },
            method: 'post',
        }).then(Response => {
            return Response.json()
        }).then(x => {
            if (x.code == 201) {
                callback(true)
            } else {
                callback(false)
            }
        })
    },
    maxElMax: function (property) {
        let t = document.querySelectorAll('*'), s = 0;
        t.forEach(function (el, k) {
            let zIndex = parseInt(getComputedStyle(el)[property])
            s = zIndex > s ? zIndex : s;
        })
        return s + 1;
    },

    popw: function (title, content, callback = undefined, w = "80%", h = "80%") {
        if (typeof content == "object") {
            async function fetchContent() {
                const res = await fetch(content.url, {
                    method: 'get',
                });
                const contentText = await res.text();
                return contentText;
            }

            fetchContent().then(function (contentText) {
                ee(contentText)
            })
        } else {
            ee(content)
        }

        // 在异步函数外部打印 contenta 的初始值 undefined
        function ee(contentText) {
            let str = `<div class="q5pop">
    <div class="darg-element">
        <div class="darg-handle">
            <div class="title-bar">${title}</div>
            <div class="btns">
                <span class="wcir">&cir;</span>
                <span class="close">&times;</span>
            </div>
        </div>
        <div class="drag-content">${contentText}</div>
    </div>
</div>`




            document.body.insertAdjacentHTML("afterbegin", str)

            let pop = document.querySelector('.q5pop'),
                dgel = pop.querySelector('.darg-element'),
                dargHandle = pop.querySelector('.darg-handle'),
                wcir = pop.querySelector('.wcir'),
                close = pop.querySelector('.btns .close')
            isDrag = false,
                log = {},
                offset = {}

            dgel.style.width = w
            dgel.style.height = h
            dgel.style.left = (document.body.clientWidth - dgel.getBoundingClientRect().width) / 2 + "px"
            dgel.style.top = (document.body.clientHeight - dgel.getBoundingClientRect().height) / 2 + "px"


            pop.style.zIndex = Qin500.maxElMax('zIndex');
            close.addEventListener('click', function (e) {
                document.body.removeChild(pop)
            })
            wcir.addEventListener('click', function (e) {
                if (dgel.style.width === "100%" && dgel.style.height === "100%") {
                    dgel.style.width = dgel.dataset.width + "px"
                    dgel.style.height = dgel.dataset.height + "px"
                    dgel.style.left = dgel.dataset.left + "px"
                    dgel.style.top = dgel.dataset.top + "px"
                } else {
                    dgel.dataset.width = dgel.getBoundingClientRect().width
                    dgel.dataset.height = dgel.getBoundingClientRect().height
                    dgel.dataset.left = dgel.getBoundingClientRect().left
                    dgel.dataset.top = dgel.getBoundingClientRect().top
                    dgel.style.width = "100%"
                    dgel.style.height = "100%"
                    dgel.style.left = "0"
                    dgel.style.top = "0"
                }

            })
            dargHandle.addEventListener('mousedown', function (e) {
                if (dgel.style.width === "100%" && dgel.style.height === "100%") {
                    return;
                }
                //鼠标到视口之间的距离
                log.x = e.clientX
                log.y = e.clientY

                //鼠标到当前元素,也就是title左边的距离
                offset.x = e.offsetX
                offset.y = e.offsetY

                isDrag = true;
            })
            dargHandle.addEventListener('mousemove', function (e) {
                if (isDrag) {
                    dgel.style.left = e.clientX - offset.x + "px"
                    dgel.style.top = e.clientY - offset.y + "px"
                }
            })
            dargHandle.addEventListener('mouseup', function (e) {
                isDrag = false
            })

            pop.addEventListener('submit', function (e) {
                e.preventDefault();

                let m={}
                let elements=Array.from(e.target.elements);

                //获取表单数据
                elements.forEach(function (el, key, parent) {
                    m[el.name]=el.value
                })

                fetch(pop.querySelector('form').getAttribute('action'), {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body:Qin500.jsonToformurl(m)
                }).then(res=>{
                    return res.json()
                }).then(x=>{
                    callback && callback(x)
                })
            })

        }
    }
    ,
    dialog:function () {

    },
    notify: function (type, text, time = 3000, callback) {
        let q5notify = document.querySelector('#q5notify');
        if (!q5notify) {
            div = document.createElement('div');
            div.classList.add("q5notify");
            div.setAttribute('id', 'q5notify')
            document.body.appendChild(div);
            q5notify = div;
        }
        q5notify.style.zIndex = Qin500.maxElMax("zIndex");
        let typetext, ico;
        switch (type) {
            case "info":
                typetext = "信息";
                ico = `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info-circle" class="svg-inline--fa fa-info-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path>
      </svg>`;
                break;
            case "success":
                typetext = "成功";
                ico = `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="svg-inline--fa fa-check-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
      </svg>`;
                break;
            case "danger":
                typetext = "错误";
                ico = `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="svg-inline--fa fa-check-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
      </svg>`;
                break;
            case "warning":
                typetext = "警告";
                ico = `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-circle" class="svg-inline--fa fa-exclamation-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="currentColor" d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path>
      </svg>`;
                break;
        }
        let str = `<div class="dialog  dialog_${type}">
        <div class="dialog_icon">${ico}</div>
        <div class="dialog_content">
            <h2>${typetext}</h2>
            <p>${text}</p>
        </div>
    </div>`;

        let parser = new DOMParser();
        let doc = parser.parseFromString(str, "text/html");
        let el = doc.body.firstElementChild
        q5notify.insertAdjacentElement("beforeend", el)
        setTimeout(() => {
            q5notify.removeChild(el);
            callback && callback()
        }, time)
    }
}
;
