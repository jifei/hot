@include('includes.head')
@include('includes.navbar')
<div id="content">
    <div id="content-container">
        <div id="timeline">
      @foreach ($feed_list as $feed)
            <div class="feed-item" data-id="{{$feed['fkey']}}">
                <div class="vote @if($feed['up_num']-$feed['down_num']>0) upmode
                   @elseif($feed['up_num']-$feed['down_num']<0) downmode @endif">
                    <a class="vote-up"></a>

                    <div class="vote-count">{{$feed['up_num']-$feed['down_num']}}</div>
                    <a class="vote-down"></a>
                </div>

                <div class="feed">
                    <div class="feed-content"><a href="http://toutiao.com/group/3460056296/">{{$feed['title']}}</a>
                    </div>
                    <div class="feed-extend">

                        <div class="feed-from"><span>{{$feed['created_at']}}</span>&nbsp;&nbsp;<a href="">{{$feed['nickname']}}</a>&nbsp;通过手机发布至&nbsp;<a
                                href="/b/{{$feed['board_code']}}">{{$feed['board_name']}}</a></div>

                        <div class="feed-handle"><a>评论</a><span class="separator">|</span><a>分享</a><span
                                class="separator">|</span><a>收藏</a><span class="separator">|</span>举报&nbsp;
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
      @endforeach


        </div>
        <div id="dashboard-right">
            <div id="tagscloud">
                <a href="http://www.17sucai.com/" class="tagc1">#搞笑视频</a>
                <a href="http://www.17sucai.com/" class="tagc2">#周末娱乐</a>
                <a href="http://www.17sucai.com/" class="tagc5">#银行贷款利率</a>
                <a href="http://www.17sucai.com/" class="tagc2">#测试</a>
                <a href="http://www.17sucai.com/" class="tagc2">#不错</a>
                <a href="http://www.17sucai.com/" class="tagc1">#热门</a>
                <a href="http://www.17sucai.com/" class="tagc2">#今日话题</a>
                <a href="http://www.17sucai.com/" class="tagc5">#银行贷款利率</a>
                <a href="http://www.17sucai.com/" class="tagc2">#银行利率</a>
                <a href="http://www.17sucai.com/" class="tagc2">#本周话题</a>
                <a href="http://www.17sucai.com/" class="tagc5">#非常不错</a>
                <a href="http://www.17sucai.com/" class="tagc2">#秀春刀</a>
                <a href="http://www.17sucai.com/" class="tagc1">#小时代</a>
                <a href="http://www.17sucai.com/" class="tagc2">#后会无期</a>
                <a href="http://www.17sucai.com/" class="tagc5">#银行贷款利率</a>
                <a href="http://www.17sucai.com/" class="tagc2">#银行存款利率</a>
                <a href="http://www.17sucai.com/" class="tagc2">#银行利率</a>
                <a href="http://www.17sucai.com/" class="tagc1">#不孕不育</a>
                <a href="http://www.17sucai.com/" class="tagc2">#银行存款利率</a>
                <a href="http://www.17sucai.com/" class="tagc5">#银行贷款利率</a>
                <a href="http://www.17sucai.com/" class="tagc2">#银行利率</a>
                <a href="http://www.17sucai.com/" class="tagc2">#房贷利率2013</a>
                <a href="http://www.17sucai.com/" class="tagc5">#银行存款利率表</a>
                <a href="http://www.17sucai.com/" class="tagc2">#银行贷款利率表</a>
            </div>
          </div>
        <div class="clear"></div>
    </div>
</div>
@include('includes.foot')
{!!HTML::script('js/index.js')!!}