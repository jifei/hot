@include('includes.head')
@include('includes.navbar')
<div id="content" class="container">
    <div id="content-container">
        @include('component.feed',array('feed'=>$feed,'is_detail'=>true))
        <div style="margin-left: 70px;">
            <div class="comment-title">评论</div>
            <div class="comment" @if(!$show_comment)style="display: none" @endif>
                <textarea name="comment"></textarea><br/>
                <button class="btn">提交</button>
                <span class="message-info"></span>
            </div>
        </div>
    </div>
</div>
@include('includes.foot')
{!!HTML::script('js/index.js')!!}
<script type="text/javascript">
    $(".feed-handle .add-feed").click(function () {
        $(".comment").toggle();
    });
    $(".comment button.btn").click(function () {
        var content = $(".comment textarea").val();
        if (!content) {
            $(".message-info").css('color', 'red').text('评论内容不能为空').show().fadeOut(5000);
        }
        $.ajax({
            url: '/comment/add/' + "{{$feed['fkey']}}",
            type: 'POST',
            data: {content: content},
            success: function (response) {
                if (response.code == 200) {
                    $(".comment textarea").val("");
                    $(".message-info").css('color', 'green').text('评论成功').show().fadeOut(5000);
                } else {
                    $(".message-info").css('color', 'red').text(response.msg).show().fadeOut(5000);
                }
            },
            error: function () {
                $(".message-info").css('color', 'red').text('非法操作').show().fadeOut(5000);
            }
        })
    });
</script>