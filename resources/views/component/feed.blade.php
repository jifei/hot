<div class="feed-item" data-id="{{$feed['fkey']}}">
    <div class="vote @if($feed['up_num']-$feed['down_num']>0) upmode
       @elseif($feed['up_num']-$feed['down_num']<0) downmode @endif">
        <a class="vote-up"></a>
        <div class="vote-count">{{$feed['up_num']-$feed['down_num']}}</div>
        <a class="vote-down"></a>
    </div>

    <div class="feed">
        <div class="feed-content">
           <a href="/f/{{$feed['fkey']}}" target="_blank">{{$feed['title']}}</a>
           @if(!empty($feed['domain']))
                <a href="/l/{{$feed['fkey']}}" target="_blank" class="jump-link"><i class="fa fa-link"></i>&nbsp;网页链接</a>
                <span class="domain">(<a>{{$feed['domain']}}</a>)</span>
           @endif
        </div>
        <div class="feed-extend">
          <div class="feed-from">
            <span>{{$feed['created_at']}}</span>&nbsp;&nbsp;
            <a href="">{!!$feed['nickname']!!}</a>&nbsp;通过手机发布至&nbsp;
            <a href="/b/{{$feed['board_code']}}">{{$feed['board_name']}}</a>
          </div>
            <div class="feed-handle">
               <a href="/f/{{$feed['fkey']}}/comment" target="_blank">评论</a><span class="separator">|</span><a>分享</a><span class="separator">|</span><a>收藏</a><span class="separator">|</span>举报&nbsp;
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>