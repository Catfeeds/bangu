$(function(){
	
	//左侧导航
	$(".user_nav dt").click(function(){
		
		if ($(this).hasClass("up")) {
			$(this).removeClass("up");
			$(this).siblings().slideUp("fast");
		}else {
			//$(".user_nav dt").removeClass("up");
			//$(".user_nav dd").slideUp("fast");
			$(this).addClass("up");
			$(this).siblings().slideDown("fast");
		}
	})	
	$(".mc dl dd .item").click(function(){
		$(".mc dl dd .item").removeClass("cur");
		$(this).addClass("cur");
	});
	$("#user_nav_1 dt").click(function(){
		$(".mc dl dd .item").removeClass("cur");
	});
	
	
	//点击下拉框框选择
	var foo=true;	
	$(".show_select").click(function(){	
		var obj = $(".show_select[class$='on']");
		//alert(foo);
		if(obj.length>0){
			if($(this).hasClass("on")){
				foo=false;
			}else{
				$(".show_select").siblings("ul").hide();
				$(".show_select").removeClass("on");
				foo=true;
			}			
		}						
		var w1 = parseInt($(this).css("width"));
		var w2 = parseInt($(this).css("padding-left"));
		var w = w1+w2*2;	
		$(this).siblings(".select_list").css("width",w+2);
		if(foo){
			//alert(1);
			$(this).addClass("on");
			$(this).siblings("ul").show();
			foo=false;
		}else{	
			$(this).removeClass("on");
			$(this).siblings("ul").hide();	
			foo=true;
		}	
	});
	
	$(document).mouseup(function(e) {
        var _con = $('.search_select'); // 设置目标区域
        if (!_con.is(e.target) && _con.has(e.target).length === 0) {
            $(".search_select").find("ul").hide();
			foo=true;
        }
    });
	$(".select_list li").click(function(){
        var txt=$(this).html();
		var val = parseInt($(this).attr("value"));
		$(this).parent().hide();
		$(this).addClass('select').siblings().removeClass('select');
		$(this).parent().parent().siblings(".select_value").val(val);
		$(this).parent().siblings(".show_select").html(txt).removeClass("on");	
		foo=true;
	});
	
	//tab 导航 切换
	$(".table_content").each(function(i){
		$(this).find(".tab_content .table_list").eq(0).show();
		$(this).find(".itab ul li").click(function(){
			var index = $(this).index();
			var nav_num = $(".itab").index($(this).parent());
			$(this).parent().find("a").removeClass("active");
			$(this).find("a").addClass("active");
			/*$(this).parent().parent().siblings(".tab_content").find(".table_list").hide();
			$(this).parent().parent().siblings(".tab_content").find(".table_list").eq(index).show();*/

		})
	})

	//弹框 
	$(".alert_box").click(function(){
		$("#hide_box3").show();
	});
	
	//关闭弹框
	$(".close_box").click(function(){
		$("#left_nav").css("z-index","1");
		$(".bg_box").hide();
		$(".box_content").hide();
	});
	
	//文本域字数计算
	$("textarea").keyup(function(){
		var fontNum = $(this).val().length;
		$(this).siblings(".font_num").find("i").html(fontNum);
	});
	
	//线路行程安排  删除

	//线路行程安排  增加一天
	$(".add_travel").click(function(){
		var length = $(".travelDay").length;
		var content_html = $(".travelDay").eq(0).html();
		var html = "<div class='travelDay'>";
			html += content_html;
			html += "</div>";
		$(".travel_arrange").append(html);
		$(".travelDay").eq(length).find(".dayNum i").html(length+1);
	});
	
	//复选框选择
	$(document).on("click",".check_ico .text",function(){
		if ($(this).hasClass("checked")) {
			$(this).removeClass("checked");
		} else {
			$(this).addClass("checked");
		};
	});
	
	
});

function clear_describe(obj){
	$(obj).siblings().val("");
}

function expert_loginout(){
	if(confirm('确定要退出吗?')){
		window.location="http://www.1b1u.com";
	}
}
