<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>_联系我们-帮游旅行网</title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static/css/common.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('static/css/aboutus.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
<style type="text/css">
.connect_web{ padding-top:15px; font-size:14px; line-height:24px; padding-bottom:20px;}
.connect_web ul li { margin-bottom:8px;color:#444;font-size:14px;}
.connect_style { margin-top:15px;margin-bottom:80px;}
.connect_style p { margin-bottom:10px;color:#444;font-size:14px;}
</style>
</head>
<body>
<!--头部开始-->
<?php echo $this->load->view('common/article_header'); ?>
<!--头部结束--> 

<!--左侧菜单开始-->
<div class="container" style="">
  <div class="w_1200">
    <div class="now_station">当前位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>><a href="#">联系我们</a></div>
    <div class="clear">
    <!--左侧菜单开始-->    
	<?php echo $this->load->view('common/article_sidebar'); ?>
    <!--左侧菜单结束--> 
    
    <!--中间右侧内容开始-->
    <div class="aboutus_right_aside fr"> 
    	<div class="culture">
        	<div class="cultureBox">
        		<div class="cultureXian"></div>
        		 <div class="culture_titile">联系我们</div>
        	</div>
            <div class="connect_web">
                <?php if(!empty($row)){echo $row['contactus'];} ?>
                
            </div>
            <div class="cultureBox">
            <div class="cultureXian"></div>
             <div class="culture_foots">联系我们</div>
        </div>
        </div>
    </div>
    <!--中间右侧内容结束--> 
    </div>
  </div>
</div>
<!--底部开始-->
<?php echo $this->load->view('common/article_footer'); ?>
<!--底部结束-->


<script type="text/javascript">
$(function(){
	$(".nav_left dt:gt(0)").click(function(){
		  $("#aboutus_nav_1 dd").slideUp("fast");
		  $(".nav_left dt").removeClass("this_url");
		  $(this).addClass("this_url");
	});
	$(".nav_left dt:eq(0)").click(function(){
		$(this).siblings().slideToggle("fast");
		$(".nav_left dt").removeClass("this_url");
		$("#this_page").html(''); 
	}); 
	$("#show").siblings().css("display","block");
	//$(".nav_left dt").removeClass("this_url");
	$("#this_page").html(''); 
		
	$(".item").click(function(){
		$(this).addClass("this_url").siblings().removeClass("this_url");
		$(".nav_left dt").removeClass("this_url");
		$("#this_page").html($(this).html());
	});
		
});

</script>

</body>
</html>

