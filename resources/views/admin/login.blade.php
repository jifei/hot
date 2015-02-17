<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>AdminLTE 2 | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/assets/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">
<div class="form-box" id="login-box">
    <div class="header">管理后台</div>
    <form action="" method="post">
        <div class="body bg-gray">
            @if(!empty($error))
                <div class="alert alert-error">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>登录失败!</strong>{{$error}}
                </div>
            @endif
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="账号"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码"/>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember_me" checked/>记住密码
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block">登录</button>

            <p><a href="#">忘记密码</a></p>

            <a href="register.html" class="text-center">注册新账号</a>
        </div>
    </form>

</div>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>