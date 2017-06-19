<div style="display: none" class="exper_sx" id="choiceExpertBox">
	<div class="sx_main">
		<p style="position:relative;">
			<span>选择管家</span>&nbsp;&nbsp;&nbsp;<i>旅游管家全程跟进一对一为您服务</i>
			<span class="close_expert_box">×</span>
		</p>
		<div class="itme_Screening clear">
			<form method="post" action="" id="choiceExpertForm">
			<ul class="itme_paihang">
				<li class="itme_on" data-val="1">综合排行</li>
				<li data-val="2">年满意度</li>
				<li data-val="3">年销人数</li>
				<li data-val="4">年成交额</li>
			</ul>
			<ul class="itme_input odear_lin">
				<li><span>管家昵称:</span><input type="text" name="nickname"></li>
				<li><span>所在地:</span>
					<input type="text" name="ChoiceCityName" value="<?php echo $this ->session->userdata('city_location');?>" id="ChoiceCityName" class="Live_city_name">
					<input type="hidden" name="ChoiceCityId" id="ChoiceCityId" value="<?php echo $this ->session->userdata('city_location_id')?>" >
				</li>
				<li style="position: relative;"><span>级别:</span>&nbsp;
					<div id="expertAge1">
						<div class="expertAge_box1">
							<div class="expertAge_showbox1 ">不限</div>
							<!-- 保存选择的管家级别 -->
							<input type="hidden" class="expert_grade_input" name="grade" value="0">
							<ul class="expertAge_option1">
								<li class="selected" data-val="0">不限</li>
								<li data-val="1">管家</li>
								<li data-val="2">初级专家</li>
								<li data-val="3">中级专家</li>
								<li style="border-bottom: 1px solid #ccc;" data-val="4">高级专家</li>
							</ul>
						</div>
					</div>
				</li>
				<li><input class="sck search_line_expert"  type="submit" value="搜索" style="width: 48px; height: 26px;"></li>
			</ul>
			<input type="hidden" name="page_new" value="1">
			<input type="hidden" value="" name="line_id">
			<input type="hidden" name="sort">
			</form>
		</div>
		<div class="tu_list_div clear">
			<!-- 管家列表 -->
			<ul class="tu_list" id="lineExpertList"></ul>
		</div>
		<div id="page"><ul class="pagination" id="expert-page"></ul></div>
		<div style="clear:both;"></div>
		<div class="list_btn" style="padding-bottom: 30px;">
			<span class="determine_button">确定</span>
			<span class="cancel_button">取消</span>
		</div>
	</div>
</div>
<script>
$(function(){
	$.fn.choiceExpert = function(options){
		ops = $.extend({}, $.fn.choiceExpert.defaults, options);
		getChoiceExpert($(this));
	}
	$.fn.choiceExpert.defaults = {
		type:1
	}
	function getChoiceExpert(obj) {
		$.post("/common/lineExpert/choiceExpert",$("#choiceExpertForm").serialize(),function(data){
			var data = eval('('+data+')'); 
			if (data.code != 2000) {
				$(obj).html('');
				return false;
			}
			var html = '';
			$.each(data.data , function(key ,val) {
				html += '<li data-val="'+val.eid+'"><img src="'+val.small_photo+'" >';
				html += '<div class="itme_House_xingxi clear">';
                                // 将guanj改为guanjia 魏勇编辑
				html += '<div class="Housek_name"><a href="/guanjia/'+val.eid+'.html" target="_blank">'+val.nickname+'</a></div>';
				if (val.grade == 1) {
					var grade = '管家';
				} else if (val.grade == 2){
					var grade ='初级专家';
				} else if (val.grade == 3){
					var grade ='中级专家';
				} else if (val.grade == 4){
					var grade ='高级专家';
				}
				if (ops.type == 1) {
					html += '<a class="consult_expert_link" href="<?php $memberid=$this->session->userdata('c_userid');echo $web['expert_question_url'].'/kefu_member.html?mid='.$memberid; ?>&eid='+val.eid+'" target="_blank">咨询管家</a>';
				}
                html += '<div class="weixuanzhong"></div>';
				html += '<div class="Housek_Level">'+grade+'</div>';
				html += '</div></li>';
			})
			$(obj).html(html);
			$('#expert-page').html(data.page_string);
			$('.ajax_page').click(function(){
				if ($(this).hasClass('active')) {
					return false;
				}
				var page_new = $(this).find('a').attr('page_new');
				$("#choiceExpertForm").find("input[name='page_new']").val(page_new);
				getChoiceExpert(obj);
			})

			$(".exper_sx").fadeIn();

			if ($("#choiceExpertBox").is(":hidden")) {
				$("#choiceExpertBox").show();
			}
			$.fn.choiceExpert.clickExpert();
			$.fn.choiceExpert.determine();
		})
	}
	//点击选择管家时调用函数
	$.fn.choiceExpert.clickExpert = function(){
		return false;
	}
	//点击确认时调用的函数
	$.fn.choiceExpert.determine = function(){
		return false;
	}
	$("#choiceExpertForm").submit(function(){
		getChoiceExpert($("#lineExpertList"));
		return false;
	})
	
	//点击管家级别搜索框 显示管家级别下拉
	$(".expertAge_showbox1").click(function(){
		$(".expertAge_showbox1").siblings(".expertAge_option1").hide();
	    $(this).siblings(".expertAge_option1").show();
	});
	$(".expertAge_option1 li").hover(function(){
	    $(this).addClass('hover').siblings().removeClass('hover');
	},function(){
	    $(this).removeClass('hover');
	});
	//选择管家级别
	$(".expertAge_option1 li").click(function(){
		var values=$(this).html();
	    $(this).parent().hide();
	    $(this).addClass('selected').siblings().removeClass('selected');
	    $(this).parent().siblings().html(values);
	    $("#choiceExpertForm").find("input[name='grade']").val($(this).attr("data-val"));
	});

	$(document).mouseup(function(e) {
		var _con = $('.expertAge_box1'); // 设置目标区域
	    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
	    	$(".expertAge_box1").find("ul").hide()
	    }
	})
	//管家搜索排序
	$(".itme_paihang li").click(function(){
		$(".itme_paihang li").removeClass("itme_on");
	    $(this).addClass("itme_on");
	    $("#choiceExpertForm").find("input[name='sort']").val($(this).attr("data-val"));
	    getChoiceExpert($("#lineExpertList"));
	});
	 //关闭管家弹出层
	 $(".cancel_button,.close_expert_box").click(function(){
	 	$(".exper_sx").fadeOut();
	 });

	//地区获取
	createChoicePlugin({
		data:chioceAreaJson,
		nameId:"ChoiceCityName",
		valId:"ChoiceCityId",
		blurDefault:true
	});
});

</script>
