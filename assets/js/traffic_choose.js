// JavaScript Document

//行程安排 交通工具
var route_obj = null;
jQuery("#rout_line").on("click",'.traffic_type',function(){　
	$(".traffic_type").removeClass("check_this");
	$(this).addClass("check_this");
	$(this).find(".title_text").hide();
	$(this).find(".traffic_content").focus();
	route_obj = jQuery(this).find(".traffic_content");
	var top = route_obj.offset().top+route_obj.outerHeight();
	var left = route_obj.offset().left;
	jQuery("#route_div").css({left : left,top : top});
	jQuery("#route_div").show();
}); 

jQuery("#route_div").on("click", ".route img",function(){
	$(".check_this").find(".traffic_content").siblings(".title_text").hide();	
	var v = jQuery(this).parent().html();
	insertNodeOverSelection(route_obj[0],jQuery(this)[0]);
 	var val = $(".check_this").find(".traffic_content").html();
	$(".check_this").find(".hidden_traffic").val(val);	
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

jQuery("#rout_line").on("blur", ".traffic_content",function(){
	var me = jQuery(this);
	var val = me.html();
	var start_ptn = /<(?!img)[^>]*>/g;      //过滤标签开头      
	var end_ptn = /[ | ]*\n/g;            //过滤标签结束  
	var space_ptn = /&nbsp;/ig;          //过滤标签结尾
	var value = val.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");
	
	if(value.length<=0){
		me.siblings(".title_text").show();
	}else{
		me.siblings('.hidden_traffic').val(value); 
	}
	routeTimeout = setTimeout("hideRoute();", 300);
});  

//移入
jQuery("#rout_line").on("mouseenter", ".traffic_content",function(){
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

//移除交通工具层 隐藏
jQuery("#route_div").mouseenter(function(){
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

//移除交通工具层 隐藏
jQuery("#route_div").mouseleave(function(){
	routeTimeout = setTimeout("hideRoute();", 800);
});

//隐藏交通工具
function hideRoute(){
	jQuery("#route_div").hide();
}
var routeTimeout = null;
