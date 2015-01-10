@extends('layouts.login')
@section('register_panel')
<div class="panel-heading"><h2>注册</h2><hr style="border-bottom:2px solid #EC6701;margin:0px;"></div>
       <form id="registerForm" class="form-vertical" method="post" action="/auth/register">
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
            <input type="text" id="email" name="email" value="{{Input::get('email')}}" required="required" require="请填写邮箱地址" email="您输入的邮箱格式有误！" success="√" class="form-control valid"  default="填写你常用的邮箱">
            <p class="help-block input_status" id="help-block-email">填写你常用的邮箱作为登录帐号</p>
          </div>
        </div>

        <div class="form-group" id="form-group-nickname">
          <label class="control-label required" for="register_nickname">昵称</label>
          <div class="controls">
            <input type="text" id="register_nickname" name="nickname" value="{{Input::get('nickname')}}" required="required" require="请填写昵称" success="√" class="form-control valid"  checker="$.checker.nickname" default="该怎么称呼你？中英文均可，最长14个字符">
            <p class="help-block input_status" id="help-block-nickname">该怎么称呼你？中英文均可，最长14个字符</p>
          </div>
        </div>

        <div class="form-group" id="form-group-password">
          <label class="control-label required" for="register_password">密码</label>
          <div class="controls">
            <input type="password" id="register_password" name="password" required="required" require="请填写密码" success="√" class="form-control valid" checker="$.checker.passwd" default="6-20位英文、数字、符号，区分大小写">
            <p class="help-block input_status" id="help-block-password">6-20位英文、数字、符号，区分大小写</p>
          </div>
        </div>
        <div class="form-group" id="form-group-confirmPassword">
          <label class="control-label required" for="register_confirmPassword">确认密码</label>
          <div class="controls">
            <input type="password" id="register_confirmPassword" name="password_confirmation" required="required" require="请确认密码" success="√" class="form-control valid" checker="$.checker.passwd" default="再输入一次密码">
            <p class="help-block input_status" id="help-block-confirmPassword">再输入一次密码</p>
          </div>
        </div>

        <div class="form-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary btn-warning btn-large btn-block" id="submit">注册</button>
          </div>
        </div>

      </form>
@stop