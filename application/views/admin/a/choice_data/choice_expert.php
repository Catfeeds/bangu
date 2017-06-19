<style>
	#choice_expert{top:28px;z-index:9999;left:27%;min-height:580px;}
	.eject_experience_pic > img{width:134px;height:134px;}
	.expert_active{filter:progid:DXImageTransform.Microsoft.Shadow(color=#909090,direction=120,strength=4);/*ie*/
-moz-box-shadow: 2px 2px 10px #909090;/*firefox*/
-webkit-box-shadow: 2px 2px 10px #909090;/*safari或chrome*/
box-shadow:2px 2px 10px #909090;/*opera或ie9*/}
</style>
<div class="eject_body">
	<div class="eject_colse colse_expert_box">X</div>
	<div class="eject_title">选择管家</div>
	<div class="search_travel_input">
		<form action="" id="searchChoiceExpert" method="post">
			<input class="search_travel_condition" style="width:150px;background: #f9f9f9;" type="text" name="city_name"  disabled="disabled" />
			<input type="hidden" name="city_id" />
			<input class="search_travel_condition" type="text" placeholder="关键字" name="keyword">
			<span id="choiceStartplace"></span>
			<input type="hidden" name="page_new" />
			<input class="search_button" type="submit" style="margin: 0px 20px;background: #fff;" value="搜索" />
		</form>
	</div>
	<div class="eject_content">
		<div class="choice_experience">
			<div class="eject_experience_pic"><img src='' ></div>
			<div class="eject_experience_info">
				<div class="experience_detailed">
					<div class="experience_nickname">姓&nbsp;&nbsp;&nbsp;名:</div>
					<div class="experience_content">中华人民共和国</div>
				</div>
				<div class="experience_detailed">
					<div class="experience_nickname">昵&nbsp;&nbsp;&nbsp;称:</div>
					<div class="experience_content">中华人民共和国</div>
				</div>
				<div class="experience_detailed">
					<div class="experience_nickname">手机号:</div>
					<div class="experience_content">18682327560</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="pagination"></div>
	</div>	
	<div class="pagination page_experience"></div>
	<div style="clear:both;"></div>
	<div class="eject_botton">
		<div class="eject_fefuse colse_expert_box">取消</div>
		<div class="eject_through submit_choice">选择</div>
	</div>					
</div>
<script>
	function createExpertHtml() {
		$.post("/admin/commonData/getExpertData" ,$("#searchChoiceExpert").serialize(),function(json){
			var data = eval("("+json+")");
			var html = '';
			
			$.each(data.list ,function(key ,val){
				html += '<div class="choice_experience" onclick="choice_data(this);" data-val="'+val.id+'" data-name="'+val.realname+'">';
				html += '<div class="eject_experience_pic">';
				html += '<img src="'+val.small_photo+'" ></div>';
				html += '<div class="eject_experience_info">';
				
				html += '<div class="experience_detailed">';
				html += '<div class="experience_nickname">姓&nbsp;&nbsp;&nbsp;名:</div>';
				html += '<div class="experience_content">'+val.realname+'</div>';	
				html += '</div>';
				
				html += '<div class="experience_detailed">';
				html += '<div class="experience_nickname">昵&nbsp;&nbsp;&nbsp;称:</div>';
				html += '<div class="experience_content">'+val.nickname+'</div>';
				html += '</div>';	

				html += '<div class="experience_detailed">';
				html += '<div class="experience_nickname">所在地:</div>';
				if (typeof val.cityname == 'object') {
					html += '<div class="experience_content">待完善</div>';	
				} else {
					html += '<div class="experience_content">'+val.cityname+'</div>';	
				}
				html += '</div></div></div>';		
			})
			if (html.length == 0) {
				html = '没有管家，换个条件试试';
			} else {
				html += '<div class="clear"></div>';
				html += '<div class="pagination" style="float: right;margin: 10px 34px;">'+data.page_string+'</div>';
			}
			
			$(".eject_content").html(html);
			$("#choice_expert,.modal-backdrop").show();
			
			$(".ajax_page").click(function(){
				if (!$(this).hasClass('active')) {
					var page_new = $(this).find("a").attr("page_new");
					$("#searchChoiceExpert").find("input[name='page_new']").val(page_new);
					createExpertHtml();
				}
			})
		})
		$('html,body').animate({scrollTop:0}, 'slow');
	}

	function choice_data(obj) {
		if ($(obj).hasClass("expert_active") ){
			$(obj).removeClass("expert_active").css("border","1px solid #ccc");
		} else {
			$(obj).addClass("expert_active").css("border","1px solid #2DC3E8").siblings(".choice_experience").removeClass("expert_active").css("border","1px solid #ccc");
		}
	}
	$("#searchChoiceExpert").submit(function(){
		$("#searchChoiceExpert").find("input[name='page_new']").val(1);
		createExpertHtml();
		return false;
	})
	
	$(".colse_expert_box").click(function(){
		$("#choice_expert").hide();
	})
</script>