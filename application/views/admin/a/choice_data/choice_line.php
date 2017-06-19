<div class="choice_box" id="choiceLineBox">
		<div class="choice_title">选择线路<span class="colse_box colse_line_box">x</span></div>
		<div class="choice_body">
			<div class="choice_search search_travel_input">
				<form action="/admin/commonData/getLineData" method="post" id="searchLineData">
					<input class="search_travel_condition" type="text" name="keyword" placeholder="关键词">
					<input type="hidden" name="line_theme" value="" />
					<input type="hidden" name="line_dest" />
					<input type="hidden" name="startplaceid" />
					<span id="choiceStartplace"></span>
					<input type="hidden" name="page_new" value="1" />
					<input class="search_button" style="margin: 0px 20px;background: #fff;" type="submit" value="搜索" />
				</form>
			</div>
			<div class="choice_content">
			<div class="choice_data" data-val="lineid">
				<div class="choice_pic mouseover">
					<ul>
						<li class="selected"><img class="cp_img" src="/file/a/upload/expert_photo_1440054595.jpg"/></li>
<!-- 						<li class="cp_img_li"><img class="cp_img" src="/file/a/upload/expert_idcardpic_1440038155.jpg"/></li> -->
<!-- 						<li class="cp_img_li"><img class="cp_img" src="/file/a/upload/expert_idcardpic_1439447396.jpg"/></li> -->
<!-- 						<li class="cp_img_li"><img class="cp_img" src="/file/a/upload/expert_idcardpic_1439278630.jpg"/></li> -->
					</ul>
					<!--  <i class="top_pic" onclick="prevPic(this);"></i>
					<i class="next_pic" onclick="nextPic(this);"></i>-->
					<div class="clear"></div>
				</div>
				<div class="cd_info">
					<span>线路名：</span>
					<span><a href="/line/line_detail_511.html" target="_blank">柬埔寨暹粒吴哥窟+金边5日3晚跟团游(4钻)2晚3天游</a></span>
				</div>
				<div class="cd_info">
					<span>供应商：</span>
					<span>柬埔寨暹粒吴哥窟+金边5日3晚跟团游(4钻)2晚3天游</span>
				</div>
				<div class="cd_info">
					<span>出发地：</span>
					<span>深圳市</span>
				</div>
				<img src="/static/img/pitch_up.png" class="cl_selected" />
			</div>
			<div class="choice_data">
				<div class="choice_pic mouseover">
					<ul>
						<li class="selected"><img class="cp_img" src="/file/a/upload/expert_photo_1440054595.jpg"/></li>
						<li class="cp_img_li"><img class="cp_img" src="/file/a/upload/expert_idcardpic_1440038155.jpg"/></li>
						<li class="cp_img_li"><img class="cp_img" src="/file/a/upload/expert_idcardpic_1439447396.jpg"/></li>
						<li class="cp_img_li"><img class="cp_img" src="/file/a/upload/expert_idcardpic_1439278630.jpg"/></li>
					</ul>
					<i class="top_pic" onclick="prevPic(this);"></i>
					<i class="next_pic" onclick="nextPic(this);"></i>
					<div class="clear"></div>
				</div>
				<div class="cd_info">
					<span>线路名：</span>
					<span><a href="/line/line_detail_511.html" target="_blank">柬埔寨暹粒吴哥窟+金边5日3晚跟团游(4钻)2晚3天游</a></span>
				</div>
				<div class="cd_info">
					<span>供应商：</span>
					<span>柬埔寨暹粒吴哥窟+金边5日3晚跟团游(4钻)2晚3天游</span>
				</div>
				<img src="/static/img/pitch_up.png" class="cl_selected" />
			</div>
			</div>
			<div class="clear"></div>

		</div>
		<div class="pagination" style="float: right;margin: 20px 20px 30px;"></div>
		<div class="clear"></div>
		<div class="eject_botton">
			<div class="eject_fefuse colse_line_box">取消</div>
			<div class="eject_through submit_choice">选择</div>
		</div>
	</div>
<script>
function createDataHtml() {
	$.post("/admin/commonData/getLineJson" ,$("#searchLineData").serialize(),function(json){
		var data = eval("("+json+")");
		var html = '';

		$.each(data.list ,function(key ,val){
			html += '<div class="choice_data" data-val="'+val.lineid+'" data-name="'+val.linename+'" onclick="choice_data(this);">';
			html += '<div class="choice_pic mouseover">';
			html += '<ul>';
			html += '<li class="selected"><img class="cp_img" src="'+val.mainpic+'"/></li>';
			html += '</ul>';
			html += '<div class="clear"></div></div>';
			html += '<div class="cd_info"><span>线路名：</span>';
			html += '<span><a href="/line/line_detail_'+val.lineid+'.html" target="_blank">'+val.linename+'</a></span></div>';
			html += '<div class="cd_info"><span>供应商：</span>';
			html += '<span>'+val.company_name+'</span></div>';
			html += '<div class="cd_info"><span>出发地：</span><span>'+val.cityname+'</span></div>';
			html += '<img src="/static/img/pitch_up.png" class="cl_selected" /></div>';
		})
		if (html.length == 0) {
			html = '没有线路，换个条件试试';
		}

		$(".choice_content").html(html);
		$(".pagination").html(data.page_string);
		$("#choiceLineBox,.modal-backdrop").show();

		$(".ajax_page").click(function(){
			if (!$(this).hasClass('active')) {
				var page_new = $(this).find("a").attr("page_new");
				$("#searchLineData").find("input[name='page_new']").val(page_new);
				createDataHtml();
			}
		})
	})
	$('html,body').animate({scrollTop:0}, 'slow');
}

function choice_data(obj) {
	if ($(obj).hasClass("cl_active") ){
		$(obj).removeClass("cl_active").find(".cl_selected").hide();
	} else {
		$(".cl_selected").hide();
		$(obj).addClass("cl_active").siblings().removeClass("cl_active");
		$(obj).find(".cl_selected").show()
	}
}
$("#searchLineData").submit(function(){
	$("#searchLineData").find("input[name='page_new']").val(1);
	createDataHtml();
	return false;
})

$(".colse_line_box").click(function(){
	$("#choiceLineBox").hide();
})

// //上一页
// function prevPic(obj) {
// 	var selObj = $(obj).prevAll("ul").find(".selected");
// 	if (selObj.prevAll("li").length == 0) {
// 		return false;
// 	} else {
// 		selObj.hide().removeClass("selected");
// 		selObj.prev("li").show().addClass("selected");
// 	}
// }
// //下一页
// function nextPic(obj) {
// 	var selObj = $(obj).prevAll("ul").find(".selected");
// 	if (selObj.nextAll("li").length == 0) {
// 		return false;
// 	} else {
// 		selObj.hide().removeClass("selected");
// 		selObj.next("li").show().addClass("selected");
// 	}
// }
$(".mouseover").mouseover(function(){
	$(this).find('i').show();
}).mouseout(function(){
	$(this).find('i').hide();
})
$(".mouseover").find("ul").click(function(){
	var parentObj = $(this).parents(".choice_data");
	$(".cl_selected").hide();
	if (parentObj.hasClass("cl_active")) {
		parentObj.removeClass("cl_active");
	} else {
		parentObj.addClass("cl_active").siblings().removeClass("cl_active");
		parentObj.find(".cl_selected").show();
	}
})
</script>