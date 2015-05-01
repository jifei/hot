<header class="navbar navbar-static-top bs-docs-nav" id="top" role="banner">
    <div class="container">
        <div class="container-gap">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand navbar-brand-logo" href="http://www.redudian.com">热度点</a>
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li @if(Request::path()==''||Request::path()=='/')class="active"@endif><a href="/">首页</a></li>
                    <li><a href="/">关注</a></li>
                    <li><a href="/">话题</a></li>
                    <li><a href="/">收藏</a></li>
                    {{--@foreach($top_boards as $v)--}}
                        {{--<li @if(isset($top_board)&&$top_board==$v['bid'])class="active"@endif><a--}}
                                    {{--href="/b/{{$v['code']}}">{{$v['name']}}</a></li>--}}
                    {{--@endforeach--}}
                </ul>
                <form class="navbar-search pull-left" action="">
                    <input type="text" class="search-query" maxlength="15" placeholder="搜索">
                    <i class="icon-search"></i>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <button style="margin-right:5px;margin-top: 6px;" @if(!$user) onclick="window.location.href='/auth/login'"
                                @else  data-target="#publishModal"  data-toggle="modal"
                                @endif  class="btn btn-warning publish-btn">发布
                        </button>
                    </li>
                    @if(!$user)
                        <li><a href="/auth/login" data-toggle="modal" class="login">登录</a></li>
                        <li><a href="/auth/register" data-toggle="modal" class="register">注册</a></li>
                    @else
                        <li role ="presentation" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$user->nickname}}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="glyphicon glyphicon-home"></i>我的主页</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-cog"></i>账号设置</a></li>
                                <li class="divider"></li>
                                <li><a href="/auth/logout"><i class="icon-off"></i>退出</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.nav-collapse -->

        </div>
    </div>
</header>
