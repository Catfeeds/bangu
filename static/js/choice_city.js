(function($) {
    jQuery.fn.extend({
        "citypicker": function(pro_in,cities,title ,type_name) {
            return this.each(function() {
                new jQuery.CityPicker(this,pro_in,cities,title,type_name);
            });
        }
    });

    jQuery.CityPicker = function(obj,pro_in,cities,title,type_name) {
        var $input = $(obj);
        //产生一个选择器
       // $input.click(function(event) {
            setupContainer(pro_in,cities,title,type_name).remove();
            var $container = setupContainer(pro_in,cities,title,type_name);
            //设置当前不可读
            this.readOnly = true;
            //得到输入框的位置
            var offset = $input.offset();
            //得到输入框的高度,宽度
            var height = $input.outerHeight();
            var width = $input.width();
            //计算选择器的位置
            var cont_top = offset.top + height;
            var cont_left = offset.left;
            //设置选择器出现的位置
            $container.appendTo($("body")).css({
                'top': cont_top,
                'left': cont_left
            });
            if ($container.is(":hidden")) {
                //当前选择器是隐藏的
                $container.show(10);
            } else if ($container.is(":visible")) {
                //当前选择器是显示的
                //停止事件冒泡
                event.stopPropagation();
            }
       // });
		
        //点击在选择器以外，隐藏它
        /*        $(document).bind("click", function(event){
            var $target = $(event.target);
            var hideFag = $target.parents("div").attr("class");
			alert(hideFag);
            if (!(hideFag == "citypicker_container" || hideFag == "tab_head" || hideFag == "tab_content" || hideFag == "cs_box"||hideFag=="sf_box")) {
				$container.hide();
            }
        });
*/
        $(document).mouseup(function(e) {
            var _con = $('.citypicker_container'); // 设置目标区域
            if (!_con.is(e.target) && _con.has(e.target).length === 0) {
                $(".citypicker_container").hide()
            }
        })

        //初始化选择器函数
        function setupContainer(msg_in,cities_in,title,type_name) {
            var citypicker_container = "<div class='citypicker_container'></duv>"
            var tab_head = ("<div class='tab_head'><ul class='clear'><li class='on'>"+type_name+"</li><li>"+title+"</li></ul></div>");
            var tab_content = ("<div class='tab_content'><div class='cs_box'><ul class='clear'></ul></div><div class='sf_box'><ul class='clear'></ul></div></div>");
            $("body").append(citypicker_container);
            $(".citypicker_container").append(tab_head);
            $(".citypicker_container").append(tab_content);
            var $container = $(".citypicker_container");
			var $cs_box = $(".cs_box ul");
            var $city = $(".sf_box ul");
            $("<span class='colse'>X</span>").appendTo(".citypicker_container").click(function() {
                $container.slideUp(100);
            });
            $(".tab_content").children().eq(1).hide();
            $(".tab_head li").click(function() {
                var index = $(this).index();
                $(this).addClass("on").siblings().removeClass("on");
                $(".tab_content").children().eq(index).show().siblings().hide();
            })

            for (p in msg_in) {
                if (p == "0") {
                    var j = msg_in[p];
                    for (b in cities_in[j]) {
                        $("<li>" + cities_in[j][b] + "</li>").appendTo(".cs_box ul").click(function() {
                            //这里把相应的值设置到输入框当中去
                            $(obj).val($(this).text());
                            //选择以后隐藏选择器
                            $container.fadeOut("fast");
                        });
                    }

                } else {
                    $("<li>" + msg_in[p] + "</li>").appendTo(".sf_box ul").click(function() {
                        $(".tab_head .on").text("选择城市");
                        var i = $(this).text();
                        //清空城市，让另外一个省的城市显示在此处
                        $city.empty();
                        for (c in cities_in[i]) {
                            $("<li>" + cities_in[i][c] + "</li>").appendTo(".sf_box ul").click(function() {
                                //这里把相应的值设置到输入框当中去
                                $(obj).val($(this).text());
                                //选择以后隐藏选择器
                                $container.fadeOut("fast");
                            });
                        }
                    });

                }
            }
            return $container;
        }
    }
})(jQuery);