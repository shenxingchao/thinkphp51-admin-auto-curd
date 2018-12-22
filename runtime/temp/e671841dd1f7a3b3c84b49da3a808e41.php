<?php /*a:1:{s:58:"E:\PHP\www\spladmin\application\admin\view\user\login.html";i:1545450170;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SplAdmin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/public/admin/plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- toastr -->
    <link rel="stylesheet" href="/public/admin/plugins/toastr/toastr.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/admin/plugins/font-awesome/css/font-awesome.min.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        body{
            background: #0a6aa1;
        }
        form{
            display: block !important;
            width: 400px;
            margin:200px auto;
            padding: 50px;
            background: rgba(0, 0, 0, 0.25);
            box-shadow: 10px 10px 2px 2px #085987;
        }
        .login_title{
            color: #ffffff;
            font-size: 20px;
            margin: auto;
            margin-bottom: 20px;
        }
        .input-group-addon{
            background: #327ab7;
            border: 1px solid #327ab7;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <form action="" method="post">
            <div class="form-group form-title">
                <div class="col-xs-12 text-center login_title">
                    Spl Admin
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 username input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" id="username" placeholder="用户名" onkeydown="loginKeyDown()">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 password input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password"  placeholder="密码" onkeydown="loginKeyDown()">
                </div>
            </div>
            <div class="form-group">
                <button type="button" id="login_btn" class="form-control btn-primary btn">登录</button>
            </div>
        </form>
    </div>
</div>
<!-- jQuery 3 -->
<script src="/public/admin/plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/public/admin/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- toastr -->
<script src="/public/admin/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
    //提交前检查登录
    $(function () {
        toastr.options.positionClass = 'toast-top-center';
        $('#login_btn').on('click',function () {
            var username = $.trim($('#username').val());
            var password = $.trim($('#password').val());
            if(username===''||password===''){
                toastr.error("用户名或密码不能为空");
            }else{
                $(this).attr('type','submit');
            }
        });
    });

    function loginKeyDown() {
        if(event.keyCode === 13){
            $('#login_btn').click();
        }
    }
</script>
</body>
</html>
