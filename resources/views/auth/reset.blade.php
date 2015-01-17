@extends('layouts.login')
@section('register_panel')
<div class="panel-heading"><h2>找回密码</h2><hr style="border-bottom:2px solid #EC6701;margin:0px;"></div>
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

       <form id="registerForm" class="form-vertical" method="post" action="/password/reset">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="token" value="{{ $token }}">
						<div class="form-group">
							<label class="control-label">邮箱地址</label>
							<div class="controls">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label">新密码</label>
							<div class="controls">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label">确认新密码</label>
							<div class="controls">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="controls">
								<button type="submit" class="btn btn-primary btn-warning btn-large btn-block">
									重置密码
								</button>
							</div>
						</div>
      </form>
@endsection
