@include('includes.head')
@include('includes.navbar')
<div id="content">
    <div id="content-container">
        @include('component.feed',array('feed'=>$feed))
        <div class="comment-title">评论</div>
        <div class="comment" @if(!$show_comment)style="display: none" @endif>
           <textarea name="comment"></textarea><br/>
           <button class="btn">提交</button>
        </div>
    </div>
</div>
@include('includes.foot')
{!!HTML::script('js/index.js')!!}