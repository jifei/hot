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
padding: 35px 40px 40px;
min-height: 400px;
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
.ptl {
padding-top: 20px;
}
.mhs {
margin-left: 5px;
margin-right: 5px;
}
.btn-fat {
padding-left: 30px;
padding-right: 30px;
}
.form-group {
   margin-bottom: 10px;
}
</style>
<div id="content-container" class="container">
  <div class="row row-6">
    <div class="col-md-6 col-md-offset-3 ptl">
      <div class="panel panel-default panel-page">
      @section('register_panel')
      @show
    </div><!-- /panel -->
  </div>
</div>
</div><!-- /container -->
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