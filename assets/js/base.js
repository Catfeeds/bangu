$(function(){

	//左侧导航
	$(".user_nav dt").click(function(){
		if ($(this).hasClass("up")) {
			$(this).removeClass("up");
			$(this).siblings().slideUp("fast");
		}else {
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
		var w1 = parseInt($(this).css("width"));
		var w2 = parseInt($(this).css("padding-left"));
		var w = w1+w2*2;
		$(this).siblings(".select_list").css("width",w+2);
		if(foo){
			$(this).siblings("ul").slideDown("fast");
			foo=false;
		}else{
			$(this).siblings("ul").slideUp("fast");
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
		var val = $(this).attr("data-val");
		$(this).parent().hide();
		foo=true;
		$(this).addClass('select').siblings().removeClass('select');
		$(this).parent().parent().siblings(".select_value").val(val);
		$(this).parent().siblings(".show_select").html(txt);
	});

	//tab 导航 切换
	jQuery(".table_content").each(function(i){
		//找到active 的li .的序号
		var li_index =  -1 ;
		$(this).find(".tab_nav li").each(function(index){
			//alert($(this).html() );
			if($(this).hasClass("active")){
				li_index=index;
				//alert ("each  li_index："+li_index);
			}
		});
		//alert (   "li_index:"+li_index);
		if(li_index<1){
			li_index=0;
		}
		$(this).find(".tab_content .table_list").eq(li_index).show();

		$(this).find(".tab_nav li").click(function(){
			var index = $(this).index();
			var nav_num = $(".tab_nav").index($(this).parent());
			$(this).parent().find("li").removeClass("active");
			$(this).addClass("active");
			$(".tab_nav").eq(nav_num).siblings(".tab_content").find(".table_list").hide();
			$(".tab_nav").eq(nav_num).siblings(".tab_content").find(".table_list").eq(index).show();
			var status = $(this).attr("status");
			//$.post(
//				"/admin/b2/home/test1",
//				{status:status},
//				function(data){
//					//$(".tab_nav").eq(nav_num).siblings(".tab_content").find(".table_list").eq(index).html(data);
//				}
//			);
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




	//复选框选择
	$(document).on("click",".check_ico .text",function(){
		if ($(this).hasClass("checked")) {
			$(this).removeClass("checked");
		} else {
			$(this).addClass("checked");
		};
	});

	//关闭当前页面
	$(".close_page").click(function(){
		window.close();
	});


});

function clear_describe(obj){
	$(obj).siblings().val("");
}


function add_travel(obj){
		var day_index = $(obj).attr('data-val');
		var html = trip_str(day_index,true);
		$(obj).before(html);
		day_index++;
		$(obj).attr('data-val',day_index);
		$(obj).html("+第<i>"+(day_index)+"</i>天");

}

function del_day(obj){
	var day_number = $(obj).attr('data-val');
	var html_div = $(obj).parent().nextAll('.travelDay');
	//console.log(html_div);
	$(html_div).each(function(){
		//var html_str = trip_str(day_number,false);

		$(this).find('.delete_day').attr('data-val',day_number);
		$(this).find('.dayNum').html('第<i>'+day_number+'</i>天');
		$(this).find("input[name^='breakfirsthas[']").attr('name','breakfirsthas['+day_number+']');
		$(this).find("input[name^='breakfirst[']").attr('name','breakfirst['+day_number+']');

		$(this).find("input[name^='lunchhas[']").attr('name','lunchhas['+day_number+']');
		$(this).find("input[name^='lunch[']").attr('name','lunch['+day_number+']');

		$(this).find("input[name^='supperhas[']").attr('name','supperhas['+day_number+']');
		$(this).find("input[name^='supper[']").attr('name','supper['+day_number+']');
		day_number++;
	});
	$(obj).parent().siblings('.btn_blue').attr('data-val',day_number).html("+第<i>"+(day_number)+"</i>天");
	$(obj).parent().remove();
}

function trip_str(day_index,is_div){
	if(is_div){
	  var html = "<div class='travelDay'>";
	}else{
	  var html = "";
	}

	html += "<span data-val='"+day_index+"' onclick='del_day(this)' class='delete_day'>×</span><div class='form_group clear'><div class='dayNum travel_content_title'>第<i>"+day_index+"</i>天</div>";
	html += "<div class='input_field'><div class='traffic_type'><div class='traffic_content' contenteditable='true'></div>";
	html += "<div class='title_text'>出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div>";
	html += "<input type='hidden' name='travel_title[]' class='hidden_traffic' value=''/></div></div></div>";
	html += "<div class='form_group clear'><div class='travel_content_title'>城市间交通:</div><div class='input_field'><input type='text' placeholder='交通方式' class='travel_describe w_705' name='traffic[]' /></div></div>";
	html += "<div class='form_group clear'><div class='travel_content_title'>用餐:</div><div class='foot'>";
	html += "<div><label class='check_ico'><input type='checkbox' name='breakfirsthas["+day_index+"]' value='1'/><span class='text'><span><i></i></span>早餐</span></label><input type='text' placeholder='15字以内' name='breakfirst["+day_index+"]' /></div>";
	html += "<div><label class='check_ico'><input type='checkbox' name='lunchhas["+day_index+"]' value='1'/><span class='text'><span><i></i></span>午餐</span></label><input type='text' placeholder='15字以内' name='lunch["+day_index+"]' /></div>";
	html += "<div><label class='check_ico'><input type='checkbox' name='supperhas["+day_index+"]' value='1'/><span class='text'><span><i></i></span>晚餐</span></label><input type='text' placeholder='15字以内' name='supper["+day_index+"]' /></div></div></div>";
	html += "<div class='form_group clear'><div class='travel_content_title'>住宿:</div><div class='input_field'><input type='text' placeholder='请输入入住酒店' class='travel_describe w_705' name='hotel[]' /></div></div>";
	html += "<div class='form_group clear'><div class='travel_content_title'><i class='important_title'>*</i>行程安排:</div><div class='input_field'><textarea  name='travel_content[]' class='text_describe noresize'></textarea></div></div>";
	html += "<div class='form_group clear'><div class='travel_content_title'>行程图片:</div><div class='input_field'><input type='hidden' class='url_val' name='pics_url[]' value=''/></div></div>";
	html += "<div class='form_group clear'><div class='travel_content_title'>&nbsp;</div><div class='input_field'><span class='btn btn_blue' onclick='change_avatar(this)'>上传图片</span></div>";
	html += "</div></div>";

	if(is_div){
	  html += "</div>";
	}

	return html;
}



