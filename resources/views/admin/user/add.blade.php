@extends('admin.layouts.master')
@section('content')
    <div style="width: 400px;margin: 20px auto;padding:30px;background-color:#fff;border: 1px solid #eee">
    <form method="post">
        @if(!empty($error))
            <div class="alert alert-error">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>注册失败!</strong>{{$error}}
            </div>
        @endif
            @if(!empty($success))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    注册成功
                </div>
            @endif
        <div class="form-group">
            <label for="InputName">账号</label>
            <input name="name" class="form-control" id="InputName" placeholder="输入登录账号">
        </div>
        <div class="form-group">
            <label for="InputReal_name">真实姓名</label>
            <input name="real_name" class="form-control" id="InputReal_name" placeholder="输入正式姓名">
        </div>
        <div class="form-group">
            <label for="InputEmail1">邮箱</label>
            <input name="email" class="form-control" id="InputEmail1" placeholder="输入邮箱">
        </div>
        <div class="form-group">
            <label for="InputMobile">手机号</label>
            <input name="mobile" class="form-control" id="InputMobile" placeholder="输入手机号">
        </div>
        <div class="form-group">
            <label for="InputPassword">密码</label>
            <input type="password" name="password" class="form-control" id="InputPassword" placeholder="输入密码">
        </div>
        <div class="form-group">
            <label for="password_confirmation">重复密码</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="重复输入的密码">
        </div>

        <button type="submit" class="btn btn-default">提交</button>
    </form>
    </div>
@stop