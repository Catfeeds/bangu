$(function(){
	var SwitchLiLen=$(".switch_ul li").length; // li数量
	if(SwitchLiLen>=1){
		var widthLi=$(".switch_ul li").eq(0).width();  // li宽度
		var Witch_box = $(".photoSwitch").width();    //box 宽度
		$(".switch_ul").css("width",SwitchLiLen*widthLi)  // 重新计算switch_ul宽度
		$(".switch_ul li").click(function(){      //移入事件
			var val = $(this).val();
			var onSee= $(".switch_ul .on").val();
			$(this).addClass("on").siblings().removeClass("on");
			if(onSee<val){
				animinte(1);
			}
			if(onSee>val){
				animinte(2);
			}
			//切换 方法
			function animinte(soe){
				if(soe=="1"){
					$(".photoShow ul li").eq(val).css({
						left:"500px"
					});
					$(".photoShow ul li").eq(val).addClass("Index").siblings().removeClass("Index");
					$(".photoShow ul li").eq(val).stop(true,true).animate({
						left:"0px"
					},100)
				}
				if(soe=="2"){
					$(".photoShow ul li").eq(val).css({
						left:"-500px"
					});
					$(".photoShow ul li").eq(val).addClass("Index").siblings().removeClass("Index");
					$(".photoShow ul li").eq(val).stop(true,true).animate({
						left:"0px"
					},100)
				}
			}
		})


		$(".switch_ul li").click(function(){      //移入事件
			var val = $(this).val();
			var onSee= $(".switch_ul .on").val();
			$(this).addClass("on").siblings().removeClass("on");
			if(onSee<val){
				animinte(1);
			}
			if(onSee>val){
				animinte(2);
			}
			//切换 方法
			function animinte(soe){
				if(soe=="1"){
					$(".photoShow ul li").eq(val).css({
						left:"500px"
					});
					$(".photoShow ul li").eq(val).addClass("Index").siblings().removeClass("Index");
					$(".photoShow ul li").eq(val).stop(true,true).animate({
						left:"0px"
					},100)
				}
				if(soe=="2"){
					$(".photoShow ul li").eq(val).css({
						left:"-500px"
					});
					$(".photoShow ul li").eq(val).addClass("Index").siblings().removeClass("Index");
					$(".photoShow ul li").eq(val).stop(true,true).animate({
						left:"0px"
					},100)
				}
			}
		})
	}
	//定时器 左右按钮切换
	$(".SwitchLeft").mouseover(function(){
		// clearTimeout(int2);
		var timer1 = setInterval(set1,1);
		function set1(){
			var les = $(".switch_ul").position().left;
			if(les<0){
				$(".switch_ul").css("left","+=1px");
			}
		}
		$(".SwitchLeft, .SwitchRight").mouseout(function(){
			clearInterval(timer1);
		})
	});
	$(".SwitchLeft").click(function(){
		$(".switch_ul").css("left","0");
	})
	$(".SwitchRight").mouseover(function(){
		var timer2 = setInterval(set2,1);
		function set2(){
			var les = $(".switch_ul").position().left;
			if(les>-SwitchLiLen*widthLi+420){
				$(".switch_ul").css("left","-=1px");
			}
		}
		$(".SwitchLeft, .SwitchRight").mouseout(function(){
			clearInterval(timer2);
		})
	});
	$(".SwitchRight").click(function(){
		$(".switch_ul").css("left",-SwitchLiLen*widthLi+420);
	})
})
