// JavaScript Document
var base_url="<?php echo base_url()?>";
//右侧浮动导航
var RightNavShow = function(){		
	var html = '';
		html += '<div class="right_nav clearfix" id="RightNav">';
		html += '<div class="right_nav_content">';
		html += '<a class="right_link_1" href="'+base_url+'expert/index">管家</a>';
		html += '<a class="right_link_2" href="'+base_url+'line/index">产品</a>';
		html += '<a class="right_link_3" href="'+base_url+'customize">定制</a>';
		html += '<a class="right_link_4" href="'+base_url+'login/login_Frame?islogin=1">登录</a>';
		html += '<a class="right_link_5" href="'+base_url+'login/registerFrame">注册</a>';
		html += '</div></div>';
		//alert(html);
		var text = '<div class="center_ico drag" onclick="right_nav_show(this);" id="right_nav_ico"><i></i></div>';
		$("body").append(text+html);
		
}

function right_nav_show(obj){
	
	if($("#RightNav").hasClass("on")){
		$("#RightNav").find("a").hide(500);
		$("#RightNav").fadeOut(500);	
		$("#RightNav").removeClass("on");
	}else{
		$("#RightNav").fadeIn(500);
		$("#RightNav").find("a").show(500);
		$("#RightNav").addClass("on");

	}
}
$(document).ready(function(){
	RightNavShow();

});

var isdrag=false;   
var tx,x,ty,y;
$(function(){ 
	
	document.getElementById("right_nav_ico").addEventListener('touchstart',selectmouse); 
	document.getElementById("right_nav_ico").addEventListener('touchmove',movemouse); 
	document.getElementById("right_nav_ico").addEventListener('touchend',function(){ 
		isdrag = false; 
	}); 
}); 
function movemouse(e){   
	if (isdrag){   
		e.preventDefault();//防止页面滑动
		
		//拖动后的位置 e.touches[0].pageX  e.touches[0].pageY
		
		var  //n = tx + e.touches[0].pageX - x; //移动后的left
			 m = ty + e.touches[0].pageY - y; //移动后的top
			 //r = tx - e.touches[0].pageX + x; //移动后的right
			 //b = tx - e.touches[0].pageY + y; //移动后的bottom
			 
		if(m-40<=0){  //距离顶部一定距离禁止拖动
			return false;  
		}
		var w_h = $(window).height();//获取浏览器可视高度
		if(w_h-m<=10){  //距离底部一定距离禁止拖动
			return false;  
		}
		$("#right_nav_ico").css("top",m); 
		$("#RightNav").css("top",m);   
	}   
}   
function selectmouse(e){   
	isdrag = true;   
	//对象的位置
	//tx = parseInt($("#right_nav_ico").css("right"));
	ty = parseInt($("#right_nav_ico").css("top"));
	
	//触摸开始时的位置
	//x = e.touches[0].pageX;
	y = e.touches[0].pageY; 
} 














