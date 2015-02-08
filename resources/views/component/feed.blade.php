<div class="feed-item" data-id="{{$feed['fkey']}}">
    <div class="vote @if($feed['up_num']-$feed['down_num']>0) upmode
       @elseif($feed['up_num']-$feed['down_num']<0) downmode @endif">
        <a class="vote-up"></a>
        <div class="vote-count">{{$feed['up_num']-$feed['down_num']}}</div>
        <a class="vote-down"></a>
    </div>

    <div class="feed">
        <div class="feed-content">
           {!!$feed['title']!!}<a href="/f/{{$feed['fkey']}}" target="_blank"></a>
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
               <a data-toggle="tooltip" title="回复"class="add-feed" @if(!empty($is_detail)) href="javascript:void(0);" @else href="/f/{{$feed['fkey']}}/comment" target="_blank" @endif><i class="fa fa-reply"></i></a><span class="separator">|</span><a data-toggle="tooltip" title="分享"><i class="fa fa-share-alt"></i></a><span class="separator">|</span><a data-toggle="tooltip" title="收藏"><i  class="fa fa-star"></i></a><span class="separator">|</span><a data-toggle="tooltip" title="举报"><i class="fa fa-warning"></i></a>&nbsp;
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>