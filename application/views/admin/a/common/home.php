<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="/bangu.ico" type="image/x-icon"/> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<title>平台管理系统</title>
<style type="text/css">
	#main { padding-left:160px;width:100%;}
	.page-content { margin-left:0;padding:0 15px;}
</style>

</head>

<body id="page" onload="heightAuto();" style="background: #f8f8f8;">

<div class="navbar" id="top">
    <div class="navbar-inner clear">
        <div class="navbar-header fl">
            <a href="#" class="navbar-brand">
                <span>帮游平台管理系统</span>
            </a>
        </div>
        <div class="header_right fr">
            <div class="user_info">
            	<p>
                    <span style="vertical-align: top;">账户名 ：<?php echo $this ->realname;?></span>
                    <span class="logout_img" onclick="loginout();"><img src="<?php echo base_url('assets/ht/img/logout.png');?>" title="退出" /></span>
                </p>

            </div>
        </div>
    </div>
</div>


<div class="main_container" id="mainBody">
	<!--  ===========  左侧导航 start =============== -->
    <div class="aside" id="left_nav">
        <div id="asideInner" class="aside_inner  nui-scroll">
            <div class="mc">
                <dl id="user_nav_1">
                    <dt class="home_link">
                        <i class="mian_page small_ico"></i>
                        <a class="a_url" href="#">主页</a>
                    </dt>
                    <dd></dd>
                </dl>
                <!-- 导航数据开始 -->
                <?php if(!empty($nav_list)):?>
                 <?php foreach ($nav_list as $v):?>
	                   <dl style="" class="user_nav">
		                    <dt>
		                        <i class="small_ico"></i><?php echo $v['name'];?><b></b>
		                    </dt>
		                    <dd>
		                    	<?php foreach ($v['lower'] as $item):?>
			                        <div class="item"  >
			                            <a href="<?php echo $item['url']?>" target="main">
			                            	<?php
			                            		if ($item['name'] == '管家列表') {
			                            			echo $item['name'].'<span style="color:red;padding-left:5px;">('.$expertCount.')</span>';
			                            		} elseif ($item['name'] == '供应商列表') {
			                            			echo $item['name'].'<span style="color:red;padding-left:5px;">('.$supplierCount.')</span>';
			                            		} else {
			                            			echo $item['name'];
			                            		}
			                            	?>
			                            </a>
			                        </div>
		                        <?php endforeach;?>
		                    </dd>
	               		</dl>
               	<?php endforeach;?>
               	<?php endif;?>
                
                <!-- 导航数据结束 -->
            </div>
        </div>
        <div class="right_ico"><span onclick="show_left_nav(this);"><i></i></span></div>
    </div>
    <!--  ===========  左侧导航 end =============== -->

	<!--  ===========  右侧页面 start =============== -->
	<iframe name="main" id="main" class="nui-scroll" frameBorder="0" scrolling="auto"></iframe>
	<!--  ===========  右侧页面 end =============== -->
</div>

<div id="val_box" class="val_box" style="display:none;"></div>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript">
//当浏览器窗口大小改变时，设置显示内容的高度  
window.onresize=function(){ 
	var top_h = document.getElementById('top').offsetHeight;//头部的高度
	var left_h = document.getElementById('asideInner').offsetHeight;//左侧导航实际高度
	var w_h = $(window).height();// 获取窗口高度
	var w1 = $(window).width();// 获取窗口高度
	var Lh = w_h - top_h;//
	var w = w1- 160;
	document.getElementById('main').style.minHeight = Lh + "px";
	document.getElementById('left_nav').style.height = "100%";
}  

function heightAuto(){
	var top_h = document.getElementById('top').offsetHeight;//头部的高度
	var left_h = document.getElementById('asideInner').offsetHeight;//左侧导航实际高度
	var w_h = $(window).height();// 获取窗口高度
	var w1 = $(window).width();// 获取窗口高度
	var Lh = w_h - top_h;//
	var w = w1- 160;
	document.getElementById('main').style.minHeight = Lh + "px";
	document.getElementById('left_nav').style.height = "100%";

}

function openWin(settings){
	layer.open(settings);
}
//左侧导航收放
function show_left_nav(obj){
	if($(obj).hasClass("on")){
		$(".aside").animate({width:"160px"},200);	
		$("#asideInner").animate({width:"160px"},200);
		$("#asideInner").css("overflow-y","auto");
		$("#main").css("padding-left","160px");
		$(obj).removeClass("on");
	}else{
		$(".aside").animate({width:"10px"},200);
		$("#asideInner").animate({width:"0px"},200);
		$("#asideInner").css("overflow-y","hidden");
		var x = $("#main").css("padding-left");
		$("#main").css("padding-left","10px");
		$(obj).addClass("on");
	}
}
//退出登录
function loginout(){
	layer.confirm('确定要退出吗?', {btn: ['确定','取消']}, function(){
		location.href="/admin/a/login/logout";
	})
}
</script>
</body>
</html>