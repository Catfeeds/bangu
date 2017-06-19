/****************
 * @author   : Liujingen 
 * @date     : 2015-08-03
 ****************/
 ;(function($){	 	
	 	$(function(){
			//导航菜单
			$("header i").click(function(){
				$(".head_nav").slideToggle();
				})
			$(".head_nav li").click(function(){
				$(this).addClass("on").siblings().removeClass();
				})
			// 首页轮播	
			var mySwiper = $('.main_custom .swiper-container').swiper({
				autoplay: 6000,			
				pagination : '.swiper-pagination',
				autoplayDisableOnInteraction : false,				
			})
			//首页管家切换
			var mySwiper = $('.expert_item .swiper-container').swiper({		
				paginationClickable: true,
				nextButton: '.swiper-button-next',
				prevButton: '.swiper-button-prev',
				spaceBetween: 10,
				loop:true,				
			})
			//首页热门目的地切换1
			var mySwiper = $('.hot_des1.swiper-container').swiper({		
				paginationClickable: true,
				nextButton: '.swiper-button-next2',
				prevButton: '.swiper-button-prev2',
				spaceBetween: 0,
				loop:true,				
			})
			//首页热门目的地切换2
			var mySwiper = $('.hot_des2.swiper-container').swiper({		
				paginationClickable: true,
				spaceBetween: 0,
				loop:true,				
			})
			//首页热门目的地切换3
			var mySwiper = $('.hot_des3.swiper-container').swiper({		
				paginationClickable: true,
				spaceBetween: 0,
				loop:true,				
			})
			//首页畅销产品切换1
			var mySwiper = $('.cj_travel.swiper-container').swiper({		
				paginationClickable: true,
				nextButton: '.swiper-button-next3',
				prevButton: '.swiper-button-prev3',
				spaceBetween: 0,
				loop:true,				
			})
			//首页畅销产品切换2
			var mySwiper = $('.zb_travel.swiper-container').swiper({		
				paginationClickable: true,
				spaceBetween: 0,
				loop:true,				
			})
			//首页畅销产品切换3
			var mySwiper = $('.gn_travel.swiper-container').swiper({		
				paginationClickable: true,
				spaceBetween: 0,
				loop:true,				
			})
			//价格列表显示与隐藏
			$('.search_input input').focus(function(){
				$('.search_list').show();
				})
			$('.search_list li').click(function(){
				$('.search_list').hide();
				})
			$(document).click(function(e){
					var dom =$(".search_box"); //设置目标区域
					if(!dom.is(e.target) && dom.has(e.target).length === 0){
						$('.search_list').hide();			
					}				
				})	

			//价格搜索
			$('.search_input').on('click','b',function(){
				var data_search=$('.search_input input').val();
				if(data_search=='' || number(data_search)){
					tan('请输入要搜索的价格');
				}else{
					var price="";
					if(data_search<=500){
						price=27;
					}else if(data_search > 500 && data_search <= 1000){
						price=28;
					}else if(data_search > 1001 && data_search <= 5000){
						price=29;
					}else if(data_search > 5001 && data_search <= 10000){
						price=30;
					}else if(data_search > 10000){
						price=31;
					}
					window.location.href="/line?price="+price;
				}
			});		
		})
		
		//首页价格只能输入数字
		function number(str){
			var rel=/[^\d.]/g;
			return rel.test(str)
		}
		
	 })(jQuery)