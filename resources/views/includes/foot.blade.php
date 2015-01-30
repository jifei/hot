<div id="publishModal" class="modal hide" tabindex="-1" aria-hidden="true" role="dialog" data-keyboard="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>发布一条热度点</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="control-group">
                <!--                <label class="control-label">标题</label>-->
                <div class="controls">
                    <span style="padding-right:20px;">热度点</span>
                    <pre class="highlighter" style="display:inline-block;vertical-align: middle;height: 120px; width: 350px; border: 1px solid #fff; margin: 0px 0px 0px -15px; padding: 4px 6px; z-index: -1;  font-size: 14px; white-space: pre-wrap; word-wrap: break-word; background:#fff;"></pre>
                    <textarea type="text" rows="4" name="title" class="input-xlarge" style="background: transparent;margin-top: -152px;height:120px;margin-left: 52px;"></textarea>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <span style="padding-right:20px;">链接</span>
                    <input type="text" name="link" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <span style="padding-right:20px;">版块</span>
                    <input id="linkSelectSection" type="text" name="board" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-warning"
                            style="width:64px;margin-left:348px;height:30px;font-size:14px;">发布
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
    </div>
</div>
{!! HTML::script('js/jquery.min.js')!!}
{!! HTML::script('js/bootstrap.min.js')!!}
{!! HTML::script('js/bootstrap-hover-dropdown.min.js')!!}
{!! HTML::script('js/tagscloud.js')!!}
{!! HTML::script('jquery-ui/jquery-ui.min.js')!!}
<script type="text/javascript">
    $(function () {
        if ($.browser.msie && parseInt($.browser.version, 10) === 6) {
            $('.row div[class^="span"]:last-child').addClass("last-child");
            $('[class*="span"]').addClass("margin-left-20");
            $(':button[class="btn"], :reset[class="btn"], :submit[class="btn"], input[type="button"]').addClass("button-reset");
            $(":checkbox").addClass("input-checkbox");
            $('[class^="icon-"], [class*=" icon-"]').addClass("icon-sprite");
            $(".pagination li:first-child a").addClass("pagination-first-child")
        }
        $('.dropdown-toggle').dropdownHover();
        $("#linkSelectSection").autocomplete(
        {
                source: function (request, response) {
                        $.ajax({
                            url: "/b/search",
                            dataType: "json",
                            data: {
                                //top: 10,
                                q: request.term
                            },
                            success: function (data) {
                                response($.map(data['data'], function (item) {
                                    return { label: item.name, value: item.name,code:item.code}
                                }));
                            }
                        });
                },
                minLength: 0,
                search: "",
                select: function (event, ui) {
                    //alert(ui.item.code);
                },
                autoFocus: false,
                delay: 0
        });

       //publish
       $("#publishModal .btn-warning").click(function(e){
         e.preventDefault();
         var title = $("#publishModal textarea[name='title']").val();
         var link = $("#publishModal input[name='link']").val();
         var board = $("#publishModal input[name='board']").val();
         if(title==''){
            alert('热度点不能为空');
            return false;
         }
         if(board==''){
            alert('版块不能为空');
            return false;
         }
         $.ajax({
               url: "/f/add",
               dataType: "json",
               type:'post',
               data: {
                 title: title,
                 link: link,
                 board: board
               },
               success: function (data) {
                  if(data.code==200){
                     alert("发布成功");
                    $("#publishModal").modal("hide");
                  }else{
                    alert(data.msg);
                  }
                  return false;
               }
           });
          return false;
       });

        String.prototype.parseHashtag = function() {
            return this.replace(/([^A-Za-z0-9_\u4E00-\u9FA5]#|^#)([#A-Za-z0-9_\u4E00-\u9FA5]+)/g, function($0,$1,$2) {
                var t =$2;
                if(t.indexOf('#')!=-1){
                   return $0;
                }
                t = '<b>#'+t+'</b>';
                //var tag = t.replace("#","%23")
                return $1.substr(0,$1.length-1)+t;
            });
        };
       $("#publishModal textarea").keyup(function(){
            $("#publishModal pre").html($(this).val().parseHashtag());
       });
    });
</script>
