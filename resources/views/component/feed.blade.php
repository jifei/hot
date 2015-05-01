<div class="feed-item" data-id="{{$feed['fkey']}}">
    <div class="vote @if($feed['up_num']-$feed['down_num']>0) upmode
       @elseif($feed['up_num']-$feed['down_num']<0) downmode @endif">
        <a class="vote-up"></a>

        <div class="vote-count">{{$feed['up_num']-$feed['down_num']}}</div>
        <a class="vote-down"></a>
    </div>

    <div class="feed col-md-10">
        <div class="feed-content">
            {{strip_tags($feed['title'])}}<a href="/f/{{$feed['fkey']}}" target="_blank"></a>
            @if(!empty($feed['domain']))
                <a href="/l/{{$feed['fkey']}}" target="_blank" class="jump-link"><i
                            class="fa fa-link"></i>&nbsp;网页链接</a>
                <span class="domain">(<a>{{$feed['domain']}}</a>)</span>
            @endif
        </div>
        <p class="feed-from">
            <span>{{$feed['created_at']}}</span>&nbsp;&nbsp;
            <a href="">{!!$feed['nickname']!!}</a>&nbsp;发布&nbsp;
            <a class="tag" href="/b/111">话题</a>
            <a class="tag" href="/b/2">搞笑</a>
            <a class="tag" href="/b/cc">男神赤道九大看点</a>
            <a class="tag" href="/b/2">我为喜剧狂</a>
            <a class="tag" href="/b/d">微软新品发布会</a>
        </p>

        <p class="feed-handle">
            <a data-toggle="tooltip" title="回复" class="add-feed" @if(!empty($is_detail)) href="javascript:void(0);"
               @else href="/f/{{$feed['fkey']}}/comment" target="_blank" @endif><i class="fa fa-comment"></i>22</a>
            {{--<span class="separator">|</span>--}}
            {{--<a data-toggle="tooltip" title="分享"><i class="fa fa-share-alt"></i></a>--}}
            <span class="separator"></span>
            <a data-toggle="tooltip" title="收藏"><i class="fa fa-heart"></i>53</a>
            <span class="separator"></span>
            <a data-toggle="tooltip" title="举报"><i class="fa fa-warning"></i>12</a>&nbsp;
        </p>
    </div>
    <div class="clear"></div>
</div>