<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<title>旅行社管理系统</title>
<script type="text/javascript">	
$(function(){
    var isIE=!!window.ActiveXObject;
    var isIE8=isIE&&!!document.documentMode;
if(navigator.userAgent.indexOf("MSIE")>0){
      if(navigator.userAgent.indexOf("MSIE 6.0")>0){
        location.href('/admin/update');
      }
      if(navigator.userAgent.indexOf("MSIE 7.0")>0){
        location.href('/admin/update');
      }

      if(navigator.userAgent.indexOf("MSIE 9.0")>0){

        return false;
      }
      if(navigator.userAgent.indexOf("MSIE 10.0")>0){

        return false;
      }
      if(navigator.userAgent.indexOf("MSIE 11.0")>0){

        return false;
      }
      if(isIE8){//这里是重点，你懂的
	  	return false;
        location.href('/admin/update');
      }
    }
})	
function heightAuto(){
	var top_h = document.getElementById('top').offsetHeight;//头部的高度
	var left_h = document.getElementById('asideInner').offsetHeight;//左侧导航实际高度
	var w_h = $(window).height();// 获取窗口高度
	var w1 = $(window).width();// 获取窗口高度
	var Lh = w_h - top_h;//
	var w = w1- 160;
	//document.getElementById('main').style.width = w + "px";
	//alert(w_h);
	document.getElementById('main').style.height = Lh + "px";
	document.getElementById('left_nav').style.height = "100%";
	
	window.frames["main"].document.getElementById("bodyMsg").style.minWidth = "1200px";
}

</script>

</head>

<body id="page" onload="heightAuto();" style="background: #eaedf1;">

<!--  ===========  头部内容  start=============== -->
<?php $this->load->view('admin/t33/common/head_view');?>
<!--  ===========  头部内容 end =============== -->



<div class="main_container" id="mainBody">
	<!--  ===========  左侧导航 start =============== -->
    <div class="aside" id="left_nav">
        <div id="asideInner" class="aside_inner nui-scroll">
            <div class="mc">
                <dl id="user_nav_1">
                    <dt class="home_link">
                        <i class="mian_page small_ico"></i>
                        <a class="a_url" href="/admin/t33/home/index">主页</a>
                    </dt>
                    <dd></dd>
                </dl>
                <!-- 导航数据开始 -->
                <?php if(!empty($menu)):?>
                 <?php foreach ($menu as $key=>$value):?>
                   <?php if($value['pid']=="0"):?>
	                   <dl style="" class="user_nav">
		                    <dt>
		                        <i class="small_ico"></i><?php echo $value['name'];?><b></b>
		                    </dt>
		                    <dd>
		                    	<?php foreach ($menu as $k=>$v):?>
			                       <?php if($v['pid']==$value['directory_id']):?>
			                        <div class="item"  >
			                          <?php if($v['name']=="消息提醒"): ?>
			                             <a href="<?php echo base_url().$v['url'].'?employee_id='.$user['id'];?>" target="main"><?php echo $v['name'];?></a>
			                            <?php else:?>
			                             <a href="<?php echo base_url().$v['url']?>" target="main"><?php echo $v['name'];?></a>
			                          <?php endif;?>
			                        </div>
			                        <?php endif;?>
		                        <?php endforeach;?>
		                    </dd>
	               		</dl>
	               	<?php endif;?>
               	<?php endforeach;?>
               	<?php endif;?>
                    <dl class="user_nav" style="display:none;">
		                    <dt>
		                        <i class="small_ico"></i>菜单管理<b></b>
		                    </dt>
		                    <dd>
			                        <div class="item"  >
			                            <a href="<?php echo base_url('admin/t33/role/menu_list')?>" target="main">菜单管理</a>
			                        </div>
			                       
		                    </dd>
	                 </dl>
                <!-- 导航数据结束 -->

                
    
            </div>            
        </div>
        <div class="right_ico"><span onclick="show_left_nav(this);"><i></i></span></div>
    </div>
    <!--  ===========  左侧导航 end =============== -->

	<!--  ===========  右侧页面 start =============== -->
	<iframe name="main" id="main" src="content" class="" frameBorder="0" scrolling="auto" height="auto"></iframe>
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
	//document.getElementById('main').style.width = w + "px";
	document.getElementById('main').style.minHeight = Lh + "px";
	document.getElementById('left_nav').style.height = "100%";
}  

function openWin(settings){

	var idx = layer.open(settings);
	if(settings.full==true){
		layer.full(idx);
	}
}
var data;
function passData(){
	/*var val = $("#val_box").html();
	data = val;*/
	//console.log(data); 
	 //document.getElementById("main").contentWindow.getValue();
    //$("#main")[0].contentWindow.getValue(); //用jquery调用需要加一个[0]
}

$(function(){
	//头部状态切换
	var fo=true;
	$(".choose_static").click(function(){
		if(fo){
			$(this).find('ul').show();
			fo=false;
		}else{
			$(this).find('ul').hide();
			fo=true;
		}
	});
	
	$(".hide_static li").click(function(){
		var txt = $(this).text();
		$("#online_txt").text(txt);
	});


});
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

</script>
</body>
</html>