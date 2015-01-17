@extends('layouts.login')
@section('register_panel')
<div class="panel-heading"><h2>找回密码</h2><hr style="border-bottom:2px solid #EC6701;margin:0px;"></div>
       <form id="registerForm" class="form-vertical" method="post" action="/password/email">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
		@if (count($errors) > 0)
       <div class="alert alert-error">
           <a href="#" class="close" data-dismiss="alert">&times;</a>
           <ul>
              @foreach ($errors->all() as $error)
              		<li>{{ $error }}</li>
              @endforeach
           </ul>
       </div>
       @endif
        <div class="form-group" id="form-group-email">
          <label class="control-label required" for="email">电子邮箱</label>
          <div class="controls">
				<input type="email" class="form-control" name="email" value="{{ old('email') }}">
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary btn-warning btn-large btn-block" id="submit">提交</button>
          </div>
        </div>
      </form>
@stop
