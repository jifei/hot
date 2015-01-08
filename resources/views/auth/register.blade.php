<form method="post" action="/auth/register">
   <input name="name">
   <input name="email">
   {{--<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />--}}
   <input name="password">
   <input type="submit">
</form>