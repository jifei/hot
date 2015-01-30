@include('includes.head')
@include('includes.navbar',array('top_board'=>isset($top_board)?$top_board:0))
<div id="content">
    <div id="content-container">
        <div id="timeline">
      @foreach ($feed_list as $feed)
        @include('component.feed',array('feed'=>$feed))
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