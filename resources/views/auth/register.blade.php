@include('includes.head')
@include('includes.navbar')
<style>
.input_status.failed {color:#f00;}
.input_status.success {color:#EC67010;font-family:verdana;}
input.error {border:1px solid #c33;background:#fff0f0}
#content-container {
margin-top: 20px;
}
.panel-page {
padding: 45px 50px 50px;
min-height: 550px;
}
.panel-default {
border-color: #ddd;
}
.panel {
 background:#fff;
 margin-bottom: 20px;
 border: 1px solid #ccc;
 border-radius: 0px;
 -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
 box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.col-md-offset-3 {
margin-left: 25%;
}
.col-md-6 {
width: 50%;
}
.form-control {
display: block;
width: 100%;
height: 34px;
padding: 6px 12px;
font-size: 14px;
line-height: 1.428571429;
color: #555;
vertical-align: middle;
background-color: #fff;
background-image: none;
border: 1px solid #ccc;
border-radius: 4px;
-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
-webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
input.form-control{
  height: 34px;
  line-height: 34px;
  margin-bottom: 0px;
}
.btn-block {
display: block;
width: 100%;
padding-right: 0;
padding-left: 0;
}
*, :before, :after {
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
 box-sizing: border-box;
}
#content-container form {
display: block;
margin: 0em;
}
label {
  display: inline-block;
  margin-bottom: 5px;
  font-weight: 700;
}
.panel-page .panel-heading {
background: transparent;
border-bottom: none;
margin: 0 0 30px 0;
padding: 0;
}
.panel-heading h2 {
font-size: 25px;
margin-top: 0;
}
p {
  margin: 0 0 10px;
}
.help-block {
display: block;
margin-top: 5px;
margin-bottom: 10px;
color: #737373;
}
.input_status.success {
color: #090;
font-family: verdana;
}
</style>
<div id="content-container" class="container">
  <div class="row row-6">
    <div class="col-md-6 col-md-offset-3 ptl">
      <div class="panel panel-default panel-page">
       <div id="registerStatus" class="alert alert-danger" style="display:none"></div>
       <div id="emailCheckInfo" class="alert alert-danger" style="display:none"></div>
       <div class="panel-heading"><h2>注册</h2><hr style="border-bottom:2px solid #EC6701;margin:0px;"></div>
       <form id="registerForm" class="form-vertical" method="post" action="/auth/register">
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

    </div><!-- /panel -->

  </div>

</div><!-- /container -->

</div>
{!!HTML::script('js/jquery.min.js')!!}
{!!HTML::script('js/bootstrap.min.js')!!}
{!!HTML::script('js/jquery.form.min.js')!!}
{!!HTML::script('js/bootstrapValidator.min.js')!!}
{!!HTML::script('js/valid.js')!!}
<script type="text/javascript">
    $(document).ready(function(){
         $("#registerForm").validation();
    });
</script>