@extends('admin.layouts.master')
@section('content')
    <div style="width: 400px;margin: 20px auto;padding:30px;background-color:#fff;border: 1px solid #eee">
    <form method="post">
        @if(!empty($error))
            <div class="alert alert-error">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>修改失败!</strong>{{$error}}
            </div>
        @endif
            @if(!empty($success))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    修改成功
                </div>
            @endif
        <div class="form-group">
            <label for="InputName">账号</label>
            {{$login_admin_user['name']}}
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