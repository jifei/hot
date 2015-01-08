/**
 * Created by jifei on 15/1/8.
 */
$.validation = {
    tip: function(test_ok, input, msg){
        var status = input.parent().find(".input_status");
        if (!test_ok) {
            status.html(msg);
            status.removeClass("success").addClass("failed");
            input.attr("valid_fail", 1);
            input.addClass("error");
        } else {
            status.html(input.attr("success"));
            status.removeClass("failed").addClass("success");
            input.removeAttr("valid_fail");
            input.removeClass("error");
        }
    }
}


$('input').focus(function(){
    var input = $(this);
    var status = input.parent().find(".input_status");
    status.html(input.attr("default"));
    status.removeClass("failed").removeClass("success");
    input.removeClass("failed");
    input.removeClass("error");
});


$.fn.validation = function(){
    function isFunction( fn ) {
        return !!fn && !fn.nodeName && fn.constructor != String &&
        fn.constructor != RegExp && fn.constructor != Array &&
        /function/i.test( fn + "" );
    }

    return this.each(function(){

        var attr_config = {
            "require":/^.+$/,
            "number":/^(-?\d+)(\.\d+)?$/,
            "idcode":[function(number){
                if (!(/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])[\dx]{4}$/i.test(number))) {
                    return false;
                }
                var check_code = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                var result_code = [1, 0, "x", 9, 8, 7, 6, 5, 4, 3, 2];
                var sum = 0;
                for (var i in check_code){
                    sum += number.charAt(i) * check_code[i];
                }
                if (result_code[sum%11]==number.charAt(number.length-1)){
                    return true;
                }
                return false;
            }, /^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])[\dx]{3}$/i],
            "mobile":/^[0-9]{11}$/,
            "phone":/^[0-9\- ]+$/,
            "email":/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/,
            "date":/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/,
            "datetime":/^[0-9]{4}\-[0-9]{2}\-[0-9]{2} [0-9]{2}\:[0-9]{2}\:[0-9]{2}$/,
            "chinese":/^[\u4e00-\u9fa5]+$/,
            "url":/^[htps]+\:\/\/([a-z0-9\-]+\.[a-z0-9\-]+)+[a-z]+$/
        };

        $(this).find("input.valid,select.valid,textarea.valid").each(function(){

            var input = $(this);
            var status = input.parent().find(".input_status");
            input.attr("default", status.text());

            var handler = function(event){
                var input = $(this);
                for (var i in attr_config){
                    if (input.attr(i)) {
                        if (!(event.data && event.data.isvalid)) {
                            if (!input.val() || input.val()==input.attr("default_value")) {
                                status.html($(this).attr("default"));
                                status.removeClass("failed").removeClass("success");
                                status.removeClass(i);
                                input.removeClass("error");
                                return false;
                            }
                        }
                        var test_ok = false;
                        $(attr_config[i]).each(function(){
                            if ((isFunction(this) && this(input.val())) || (!isFunction(this) && this.test(input.val()))) {
                                test_ok = true;
                                return false;
                            } else {
                                test_ok = false;
                            }
                        });
                        if (input.attr("type")=="checkbox" && input.attr("require")){
                            if (input[0].checked){
                                test_ok = true;
                            } else {
                                test_ok = false;
                            }
                        }
                        $.validation.tip(test_ok, input, input.attr(i));
                    }
                }
            }
            input.bind("blur.valid", handler).trigger("blur");
            input.bind("_valid.valid", {isvalid:true}, handler);
            if (input.attr("checker")){
                eval('input.bind("blur.valid_checker", '+input.attr("checker")+');');
            }
        });

        $(this).bind("valid.valid", function(){
            $(this).find("input,textarea,select").trigger("_valid");
            $(this).find("input,textarea,select").trigger("blur.valid_checker");
        });

        $(this).bind("submit.valid", function(){
            $(this).trigger("valid");
            var isvalid = true;
            $(this).find("input,textarea,select").each(function(){
                if ($(this).attr("valid_fail")) {
                    isvalid = false;
                    return false;
                }
            });
            return isvalid;
        });
    });
};

$.checker = {
    passwd : function(){
        var input = $(this);
        if (!input.val()) {
            $.validation.tip(false, input, input.attr("require"));
            return;
        }
        if(($(this).val().length)<6){
            $.validation.tip(false, input, "密码长度必须大于等于6位");
        }
        if(($(this).val().length)>20){
            $.validation.tip(false, input, "密码长度必须小于等于20位");
        }

        var passwds = [];
        var valid = true;
        $("form input.valid[type=password]").each(function(){
            passwds.push($(this));
        });
        if (passwds[0].val()&&passwds[1].val()){
            if (passwds[0].val()==passwds[1].val()){
                $.validation.tip(true, passwds[0], input.attr("success"));
                $.validation.tip(true, passwds[1], input.attr("success"));
            } else {
                $.validation.tip(false, input, "密码不匹配");
            }
        }
    },
    //
    //
    //username : function(){
    //    var input = $(this);
    //    if (!input.val()) {
    //        $.validation.tip(false, input, input.attr("require"));
    //        return;
    //    }
    //    if(($(this).val().replace(/[^\x00-\xff]/g,"**").length )>14){
    //        $.validation.tip(false, input, "长度必须小于等于14位");
    //        return;
    //    }
    //    if(!$(this).val().match(/^[a-zA-Z0-9_]{0,}$/)){
    //        $.validation.tip(false, input, "只允许英文字母、数字、下划线！");
    //        return;
    //    }else{
    //        $.validation.tip(true, '', input.attr("success"));
    //    }
    //},

    nickname : function(){
        var input = $(this);
        if (!input.val()) {
            $.validation.tip(false, input, input.attr("require"));
            return;
        }
        if(($(this).val().replace(/[^\x00-\xff]/g,"**").length )>14){
            $.validation.tip(false, input, "长度必须小于等于14位");
            return;
        }
        $.validation.tip(true, input, input.attr("success"));
    }

}
