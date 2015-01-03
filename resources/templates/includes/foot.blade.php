<div id="loginModal" class="modal hide fade" data-keyboard="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>登录</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label">邮箱</label>

                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="text" name="email">
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">用户名</label>

                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="username">
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">密码</label>

                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" name="password">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" style="width:13px;height:13px;" checked="checked" name="remember_pwd">下次自动登录&nbsp;&nbsp;&nbsp;&nbsp;
                        <a>忘记密码</a>
                    </label>
                    <button type="submit" class="btn btn-warning" style="width:220px;*width:215px;">登录</button>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <span style="font-size:12px;color:#666;">使用其他账户登录</span> 微博、QQ
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
    </div>
</div>

<div id="registerModal" class="modal hide" data-keyboard="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>注册</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label">邮箱</label>

                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="text" name="email">
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">用户名</label>

                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="user_name">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">昵称</label>

                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-fire"></i></span>
                        <input type="text" name="nickname">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">密码</label>

                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" name="password">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-warning" style="width:220px;">注册</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
    </div>
</div>


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
                    <span style="padding-right:20px;">标题</span><textarea type="text" rows="4" name="title"
                                                                         class="input-xlarge"></textarea>
                </div>
            </div>
            <div class="control-group">
                <!--                <label class="control-label">链接</label>-->
                <div class="controls">
                    <span style="padding-right:20px;">链接</span><input type="text" name="link" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <span style="padding-right:20px;">版块</span><input id="linkSelectSection" type="text" name="link"
                                                                      class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-warning"
                            style="width:64px;margin-left:348px;height:30px;font-size:14px;">发布
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
    </div>
</div>

{{ HTML::script('js/jquery.min.js')}}
{{ HTML::script('js/bootstrap.min.js')}}
{{ HTML::script('js/bootstrap-hover-dropdown.min.js')}}
{{ HTML::script('js/tagscloud.js')}}
{{ HTML::script('jquery-ui/jquery-ui.min.js')}}
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
    })
    $(document).ready(function () {
        $('.dropdown-toggle').dropdownHover();
        var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
        ];

        $("#linkSelectSection").autocomplete(
            {
//                source: availableTags,
                source: function (request, response) {
                    var term = request.term;
                    if (term == '') {
                        response($.map(availableTags, function (item) {
                            return { label: item, value: item}
                        }));
                    } else {
                        $.ajax({
                            url: "http://demo.com/ajax/Autocomplete.ashx",
                            dataType: "json",
                            data: {
                                //top: 10,
                                key: request.term
                            },
                            success: function (data) {
                                response($.map(data.citylist, function (item) {
                                    return { label: item.city, value: item.city }
                                }));
                            }
                        });
                    }
                },
                minLength: 0,
                search: "",
                select: function (event, ui) {
                },
                autoFocus: false,
                delay: 0
            });

        $("#registerModal button[type='submit']").click(function (e) {
            e.preventDefault();
            var $user_name = $("#registerModal input[name='user_name']");
            var $nickname = $("#registerModal input[name='nickname']");
            var $email = $("#registerModal input[name='email']");
            var $password = $("#registerModal input[name='password']");
            $("#registerModal span.help-inline").remove();//清除提示
            $.ajax({
                url: "/user/add",
                dataType: "json",
                type: "post",
                data: {
                    user_name: $user_name.val(),
                    nickname: $nickname.val(),
                    email: $email.val(),
                    password: $password.val()
                },
                success: function (data) {
                    if (data.code == 1) {
                        window.location.href = "/";//注册成功跳转
                    } else {
                        if (typeof(data.msg) == 'string') {
                            alert(data.msg);
                        }
                        var user_name_info = "";
                        var nickname_info = "";
                        var email_info = "";
                        var password_info = "";
                        if (typeof(data.msg.user_name) != 'undefined') {//用户名验证
                            user_name_info = '<span class="help-inline error">' + data.msg.user_name[0] + "</span>";
                        } else {
                            user_name_info = '<span class="help-inline success"></span>';
                        }
                        $user_name.closest(".controls").append(user_name_info);

                        if (typeof(data.msg.nickname) != 'undefined') {//昵称验证
                            nickname_info = '<span class="help-inline error">' + data.msg.nickname[0] + "</span>";
                        } else {
                            nickname_info = '<span class="help-inline success"></span>';
                        }
                        $nickname.closest(".controls").append(nickname_info);

                        if (typeof(data.msg.email) != 'undefined') {//邮箱验证
                            email_info = '<span class="help-inline error">' + data.msg.email[0] + "</span>";
                        } else {
                            email_info = '<span class="help-inline success"></span>';
                        }
                        $email.closest(".controls").append(email_info);

                        if (typeof(data.msg.password) != 'undefined') {//密码验证
                            password_info = '<span class="help-inline error">' + data.msg.password[0] + "</span>";
                        } else {
                            password_info = '<span class="help-inline success"></span>';
                        }
                        $password.closest(".controls").append(password_info);
                    }
                    return false;
                }
            });
        });
    });
</script>
