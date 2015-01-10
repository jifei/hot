@extends('layouts.login')
@section('register_panel')
<div class="panel-heading"><h2>登录</h2><hr style="border-bottom:2px solid #EC6701;margin:0px;"></div>
       <form id="registerForm" class="form-vertical" method="post" action="/auth/login">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
       @if(!empty($error))
       <div class="alert alert-error">
           <a href="#" class="close" data-dismiss="alert">&times;</a>
           <ul>
           @foreach ($error as $msg)
               <li>{{ $msg }}</li>
           @endforeach
           </ul>
       </div>
       @endif
        <div class="form-group" id="form-group-email">
          <label class="control-label required" for="email">电子邮箱</label>
          <div class="controls">
            <input type="text" id="email" name="email" value="{{Input::get('email')}}" required="required" class="form-control"  default="填写你常用的邮箱">
          </div>
        </div>

        <div class="form-group" id="form-group-password">
          <label class="control-label required" for="login_password">密码</label>
          <div class="controls">
            <input type="password"  name="password" id="login_password" class="form-control">
          </div>
        </div>
          <div class="form-group">
            <div class="controls">
              <span class="checkbox mtm pull-right">
                <label> <input type="checkbox" name="remember" value="true"> 记住密码 </label>
              </span>
              <button type="submit" class="btn btn-fat btn-primary btn-warning">登录</button>
            </div>
          </div>
      </form>
      <div class="ptl">
                <a href="/forgotPassword">找回密码</a>
                <span class="text-muted mhs">|</span>
                <span class="text-muted">还没有注册帐号？</span>
                <a href="/auth/register">立即注册</a>
              </div>
@stop

