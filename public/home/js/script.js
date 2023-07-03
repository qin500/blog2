let scrooltop = document.querySelector(".fix-evident [data-scrolltop]");
scrooltop && scrooltop.addEventListener('click', function (e) {
    document.body.scrollIntoView({behavior: 'smooth', block: 'start'})
})


Qin500.isLogin(function (bool) {
    let login_topbtn = document.querySelector('#login_topbtn'),
        login_succ = document.querySelector('.login_succ');
    if (bool) {
        login_succ.style.display = "block"
        login_topbtn.style.display = "none"
    } else {
        login_succ.style.display = "none"
        login_topbtn.style.display = "block"
    }

    login_topbtn.addEventListener('click', function (e) {
        // let login_panel=document.querySelector('#login_panel');
        // login_panel.style.display="flex"

        Qin500.login(function (e) {
            console.log(e)
        })
    })

    login_succ.querySelectorAll('.dropmenu a').forEach(function (x) {
        x.addEventListener('click', function (e) {
            switch (Object.keys(this.dataset)[0]) {

                case "dashboard":
                    window.open(this.href)
                    break;
                case "artnew":
                    console.log('呢哇1')
                    break;
                case "categoies":
                    console.log('呢哇2')
                    break
                case "updatepwd":
                    console.log('呢哇3')
                    break;
                case "logout":
                    fetch(this.getAttribute('href'), {
                        method: 'post'
                    }).then(y => {
                        return y.json()
                    }).then((response => {
                        Qin500.notify("success", '已退出系统')
                        login_succ.style.display = "none"
                        login_topbtn.style.display = "block"
                    }))

            }
            e.preventDefault()
        })
    })

})

