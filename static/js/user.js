// JavaScript Document
$(function(){

	/* 我的订单页面左侧菜单折叠效果 */
		$("#user_nav_1 dt,#user_nav_3 dt,#user_nav_5 dt").bind("click",function(){
			var _self = $(this);
			  if (_self.hasClass("up")) {
				_self.removeClass("up");
				_self.next().slideDown("fast");
			  } else {
				_self.addClass("up");
				_self.next().slideUp("fast");
			  }
		})
})

	/* 我的订单页面右侧 我的分享弹出框和图片删除效果 */
$(function  () {
	 $(window).load(function(){
		 $('.share_new_window').css('display','none');
	 })
	$('.share_new_window_body li i').click(function(){
		$(this).parent().hide();
	})
	$('.share_new_window_top i').click(function(){
		$('.share_new_window').hide();
	})
	$('.cm_hd_1 ul li button').click(function(){
		$('.share_new_window').css('display','block')
	})
	$('.share_new_window_body_botton input').click(function(){
		$('.share_new_window').hide();
	})	
	$('.share_table_tbody_modify').click(function(){
		$('.share_new_window').css('display','block')
	})
})

/* 我的订单页面右侧 我的定制单表格切换效果 */

$(function(){
                
	$(".order_table_tbody_see").click(function(){
                           $('.order_new_window_confirm').show();
              });
	
})

