<div class="choice_box" id="choiceAnchorBox">
		<div class="choice_title">选择主播<span class="colse_box colse_anchor_box">x</span></div>
		<div class="choice_body">
			<div class="choice_search search_travel_input">
				<form action="/admin/a/live/live_room_manage/getAnchors" method="post" id="searchAnchorData">
					<!-- <input class="search_travel_condition" type="text" name="keyword" placeholder="关键词"> -->
					<input type="hidden" name="page_new" value="1" />
					<!-- <input class="search_button" style="margin: 0px 20px;background: #fff;" type="submit" value="搜索" /> -->
				</form>
			</div>
			<div class="choice_content"></div>
			<div class="clear"></div>

		</div>
		<div class="pagination" style="float: right;margin: 20px 20px 30px;"></div>
		<div class="clear"></div>
		<div class="eject_botton">
			<div class="eject_fefuse colse_anchor_box">取消</div>
			<div class="eject_through submit_choice">选择</div>
		</div>
	</div>
<script>
function createDataHtml() {
	$.post("/admin/a/live/live_room_manage/getAnchors" ,$("#searchAnchorData").serialize(),function(json){
		var data = eval("("+json+")");
		var html = '';
		$.each(data.list ,function(key ,val){
			html += '<div class="choice_data" data-val="'+val.anchor_id+'" data-name="'+val.name+'" onclick="choice_data(this);">';
			html += '<div class="choice_pic mouseover">';
			html += '<ul>';
			html += '<li class="selected"><img class="cp_img" src="'+val.photo+'"/></li>';
			html += '</ul>';
			html += '<div class="clear"></div></div>';
			html += '<div class="cd_info"><span>主播名：</span>';
			html += '<span>'+val.name+'</span></div>';
			html += '<img src="/static/img/pitch_up.png" class="cl_selected" /></div>';
		})
		if (html.length == 0) {
			html = '没有主播，换个条件试试';
		}

		$(".choice_content").html(html);
		$(".pagination").html(data.page_string);
		$("#choiceAnchorBox,.modal-backdrop").show();

		$(".ajax_page").click(function(){
			if (!$(this).hasClass('active')) {
				var page_new = $(this).find("a").attr("page_new");
				$("#searchAnchorData").find("input[name='page_new']").val(page_new);
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
$("#searchAnchorData").submit(function(){
	$("#searchAnchorData").find("input[name='page_new']").val(1);
	createDataHtml();
	return false;
})

$(".colse_anchor_box").click(function(){
	$("#choiceAnchorBox").hide();
})
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