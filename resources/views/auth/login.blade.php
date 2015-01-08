<form method="post" action="/auth/login">
   <input name="email">
   {{--<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />--}}
   <input name="password">
   <input name="remember" value="1" type="checkbox">
   <input type="submit">
</form>