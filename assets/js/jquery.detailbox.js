(function($) {
	/*
	 * 简版数据格式
	 * 	data = {
	 * 			"姓名":{content:"显示内容",type:"text",width:"50%",formatter:function(item){return false;}}
	 *			"姓名":{content:"显示内容",type:"text",width:"50%",formatter:function(item){return false;}}
	 * 		}
	 *  type参数值：text or img or func
	 *  
	 * 
	 * 
	 */
	$.fn.detailbox = function(options) {
		detailboxParam = $.extend($.fn.detailbox.defaults,options);
		detailboxObj = $(this);
		if (!detailboxObj.children("div").hasClass(detailboxParam.boxClass.bodyBox)) {
			createBoxStructure();	
		} else {
			detailboxObj.find("."+detailboxParam.boxClass.titleClass).text(detailboxParam.titleName);
		}
		detailboxObj.find("."+detailboxParam.boxClass.bodyBox).fadeIn(500);
		createMaskLayer();
		if (detailboxParam.isSimpleVersion == true) {
			showData();
		}
		//
		$.fn.detailbox.createButton();
		$.fn.detailbox.buttonClick();
		colseBox();
	};
	$.fn.detailbox.defaults = {
		titleName:"xx详情",//标题
		data:{},//显示数据
		isSimpleVersion:true,//是否简版
		width:"800px",//盒子的宽度 800px
		zindex:100,
		boxClass:{
			bodyBox:"detail-box",
			titleClass:"deatil-title",
			colseClass:"detail-colse",
			contentClass:"detail-content"
		}
	};
	function showData() {
		var html = "<ul class='dc-list'>";
		$.each(detailboxParam.data ,function(key ,val){
			if (typeof val.width != 'undefined') {
				html += "<li style='width:"+val.width+"'>";
			} else {
				html += "<li>";
			}
			if (typeof val.type == 'undefined' || val.type == 'text') {
				if (typeof val.content == 'object') {
					var content = '';
				} else {
					var content = val.content;
				}
				html += "<div class='dc-title'>"+key+"：</div><div class='dc-content'>"+content+"</div></li>";
			} else if (val.type == 'img') {
				if (typeof val.content == 'object' || val.content.length == 0) {
					html += "<div class='dc-title'>"+key+"：</div><div class='dc-content'></div></li>";
				} else {
					html += "<div class='dc-title'>"+key+"：</div><div class='dc-content'><a href='"+val.content+"' target='_blank'><img src='"+val.content+"' style='width:80px;'></a></div></li>";
				}
			}
		})
		html += "</ul><div class='clear'></div>";
		detailboxObj.find("."+detailboxParam.boxClass.contentClass).html(html);
	}
	//关闭浮层
	function colseBox() {
		$("."+detailboxParam.boxClass.colseClass+",.colse-detail-box").click(function(){
			detailboxObj.find("."+detailboxParam.boxClass.bodyBox).fadeOut(500);
			$(".mask-layer").fadeOut(500);
		})
	}
	//生成弹出层的结构
	function createBoxStructure() {
		var html = "<div class='"+detailboxParam.boxClass.bodyBox+"' style='z-index:"+detailboxParam.zindex+"'><h4 class='"+detailboxParam.boxClass.titleClass+"'>"+detailboxParam.titleName+"</h4>";
		html += "<div class='"+detailboxParam.boxClass.colseClass+"'>X</div><div class='"+detailboxParam.boxClass.contentClass+"'></div>";
		html += "<div class='button-list'><div class='colse-detail-box'>关闭</div></div></div>";
		detailboxObj.html(html);
	}
	//生成遮罩层
	function createMaskLayer() {
		if($("body").children(".mask-layer").length == 0) {
			$("body").append("<div class='mask-layer' style='z-index:"+Math.round(detailboxParam.zindex-1)+"'></div>");
		}
		$(".mask-layer").fadeIn(500);
	}
	//自定义按钮
	$.fn.detailbox.createButton = function(){
		return false;
	}
	//按钮点击事件
	$.fn.detailbox.buttonClick = function(){
		return false;
	}
})(jQuery); 