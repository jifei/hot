<div id="publishModal" class="modal fade" aria-hidden="true" role="dialog" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">发布一条热度点</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">热度点</label>
                        <div class="col-sm-10">
                            <pre class="highlighter"
              style="display: block;float: left;vertical-align: middle;height: 120px; width: 350px; border: 1px solid #fff; position: absolute;padding: 6px 12px; z-index: -1;  font-size: 14px; background:#fff;"></pre>
                            <textarea type="text" rows="4" name="title" class=" form-control input-xlarge"
                                      style="background: transparent;height:120px;"></textarea>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="link" class="col-sm-2 control-label">链接</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-xlarge" id="link" name="link"  placeholder="链接地址">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="linkSelectSection" class="col-sm-2 control-label">版块</label>
                        <div class="col-sm-10">
                            <input id="linkSelectSection" type="text" name="board" class="form-control input-xlarge"  placeholder="板块名称">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-warning">发布</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
{!! HTML::script('js/jquery.min.js')!!}
{!! HTML::script('bootstrap/js/bootstrap.min.js')!!}
{!!HTML::script('bootstrap/js/tooltip.js')!!}
{!! HTML::script('jquery-ui/jquery-ui.min.js')!!}
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
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
                                    return {label: item.name, value: item.name, code: item.code}
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
        $("#publishModal .btn-warning").click(function (e) {
            e.preventDefault();
            var title = $("#publishModal textarea[name='title']").val();
            var link = $("#publishModal input[name='link']").val();
            var board = $("#publishModal input[name='board']").val();
            if (title == '') {
                alert('热度点不能为空');
                return false;
            }
            if (board == '') {
                alert('版块不能为空');
                return false;
            }
            $.ajax({
                url: "/f/add",
                dataType: "json",
                type: 'post',
                data: {
                    title: title,
                    link: link,
                    board: board
                },
                success: function (data) {
                    if (data.code == 200) {
                        alert("发布成功");
                        $("#publishModal").modal("hide");
                        window.location.reload();
                    } else {
                        alert(data.msg);
                    }
                    return false;
                }
            });
            return false;
        });

        String.prototype.parseHashtag = function () {
            return this.replace(/([^A-Za-z0-9_\u4E00-\u9FA5]#|^#)([#A-Za-z0-9_\u4E00-\u9FA5]+)/g, function ($0, $1, $2) {
                var t = $2;
                if (t.indexOf('#') != -1) {
                    return $0;
                }
                t = '<b>#' + t + '</b>';
                //var tag = t.replace("#","%23")
                return $1.substr(0, $1.length - 1) + t;
            });
        };
        $("#publishModal textarea").keyup(function () {
            $("#publishModal pre").html($(this).val().parseHashtag());
        });
    });
</script>
