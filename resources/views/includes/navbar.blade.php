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
                    <li><a href="/">首页</a></li>
                    @foreach($top_boards as $v)
                       <li><a href="/b/{{$v['code']}}">{{$v['name']}}</a></li>
                    @endforeach
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">版块<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">新闻</a></li>
                            <li><a href="#">自媒体</a></li>
                            <li><a href="#">搞笑</a></li>
                            <li><a href="#">财经</a></li>
                            <li><a href="#">娱乐</a></li>
                            <li><a href="#">电视</a></li>
                            <li><a href="#">电影</a></li>
                            <li><a href="#">体育</a></li>
                            <li><a href="#">科技</a></li>
                            <li><a href="#">汽车</a></li>
                            <li><a href="#">房产</a></li>
                            <li><a href="#">社会</a></li>
                            <li><a href="#">公益</a></li>
                            <li><a href="#">问答</a></li>
<!--                            <li><a href="#">情感</a></li>-->
<!--                            <li><a href="#">美食</a></li>-->
<!--                            <li><a href="#">旅游</a></li>-->
<!--                            <li><a href="#">读书</a></li>-->
                            <li class="divider"></li>
                            <li><a href="#">更多>></a></li>
                        </ul>
                    </li>
                    <li><a href="/more">更多>></a></li>
                </ul>
                <form class="navbar-search pull-left" action="">
                    <input  type="text" class="search-query" maxlength="15" placeholder="搜索">
                    <i class="icon-search"></i>
                </form>
                <ul class="nav pull-right">
                    <li><button style="margin-right:5px;" type="submit" href="#publishModal"  data-toggle="modal" class="btn btn-warning publish-btn">发布</button></li>
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
<!--                    <li class="divider-vertical"></li>-->
<!--                    <li class="dropdown">-->
<!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>-->
<!--                        <ul class="dropdown-menu">-->
<!--                            <li><a href="#">个人信息</a></li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li><a href="#">设置</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
                </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div>