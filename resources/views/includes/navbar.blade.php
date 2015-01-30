<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="http://www.redudian.com" >热度点</a>
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav">
                    <li @if(isset($top_board)&&$top_board==0)class="active"@endif><a href="/">首页</a></li>
                    @foreach($top_boards as $v)
                       <li @if(isset($top_board)&&$top_board==$v['bid'])class="active"@endif><a href="/b/{{$v['code']}}">{{$v['name']}}</a></li>
                    @endforeach
                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">版块<b class="caret"></b></a>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<li><a href="#">新闻</a></li>--}}
                            {{--<li><a href="#">自媒体</a></li>--}}
                              {{--<li class="divider"></li>--}}
                            {{--<li><a href="#">更多>></a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    <li ><a href="/more">更多>></a></li>
                </ul>
                <form class="navbar-search pull-left" action="">
                    <input  type="text" class="search-query" maxlength="15" placeholder="搜索">
                    <i class="icon-search"></i>
                </form>
                <ul class="nav pull-right">
                    <li><button style="margin-right:5px;" @if(!$user) onclick="window.location.href='/auth/login'" @else href="#publishModal"  data-toggle="modal" @endif  class="btn btn-warning publish-btn">发布</button></li>
                    @if(!$user)
                    <li><a href="/auth/login"  data-toggle="modal"  class="login">登录</a></li>
                    <li><a href="/auth/register"  data-toggle="modal"  class="register">注册</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$user->nickname}}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-home"></i>我的主页</a></li>
                            <li><a href="#"><i class="icon-cog"></i>账号设置</a></li>
                            <li class="divider"></li>
                            <li><a href="/auth/logout"><i class="icon-off"></i>退出</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div>
<div class="nav-second">
   <ul>
      <li><a>搞笑</a></li>
      <li><a>搞笑</a></li>
      <li><a>搞笑</a></li>
      <li><a>搞笑</a></li>
   </ul>
</div>