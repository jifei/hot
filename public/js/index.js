$(document).ready(function () {

    //Responsive();
    //支持反对
    $("#content").delegate(".vote-up,.vote-down", "click", function () {
        var $vote = $(this).closest(".vote");
        var class_name = $(this).attr("class");
        var $count = $vote.find(".vote-count");
        var vote_count = $count.text();
        var default_count = vote_count;
        var add_class = "";
        var fkey = $(this).closest(".feed-item").attr("data-id");
        var url = "/f/up";
        if (class_name == "vote-down") {
            url = "/f/down";
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {fkey: fkey},
            dataType: 'json',
            success: function (response) {
                if (response.code == 200) {
                    var vote_count = response.data.up_num - response.data.down_num;
                    if(vote_count>0){
                        add_class = "upmode";
                    }else if(vote_count<0){
                        add_class = "downmode";
                    }
                    //alert(vote_count-default_count);    用户操作记录表 uid,fid value -1,0,1
                    $vote.removeClass("upmode").removeClass("downmode");
                    $count.text(vote_count);
                    if (add_class != "") {
                        $vote.addClass(add_class);
                    }
                } else {
                    alert(response.msg);
                }
            },
            error: function () {
                alert('非法操作');
            }

        });


    });

    //$(window).resize(function () {
    //    Responsive();
    //});
});

//响应式
//function Responsive() {
//    var window_width = $(window).width();
//    var window_height = $(window).height();
//    if (window_width <= 900) {
//        timeline_width = Math.max(window_width - 10, 700);
//        $("#dashboard-right").hide();
//        $("#content-container").css("width", timeline_width);
//    } else {
//        var timeline_width = Math.min(Math.max(window_width - 300, 600), 900);
//        $("#content-container").css("width", timeline_width + 300);
//        $("#dashboard-right").show();
//    }
//    $("#timeline").css("width", timeline_width);
//    $(".feed").css("width", timeline_width - 80);
//}