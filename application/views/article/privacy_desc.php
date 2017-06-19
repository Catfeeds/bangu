<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>_隐私声明-帮游旅行网</title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static/css/common.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('static/css/aboutus.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
<style type="text/css">

</style>
</head>
<body>
<!--头部开始-->
<?php echo $this->load->view('common/article_header'); ?>
<!--头部结束--> 

<!--左侧菜单开始-->
<div class="container" style="">
  <div class="w_1200">
    <div class="now_station">当前位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>><a href="#">隐私声明</a></div>
    <div class="clear"> 
	<!--左侧菜单开始-->        
	<?php echo $this->load->view('common/article_sidebar'); ?>
	<!--左侧菜单结束--> 
      
      <!--中间右侧内容开始-->
      <div class="aboutus_right_aside fr" >
        <div class="culture" style="padding-bottom:65px;">
        	<div class="cultureBox">
        		<div class="cultureXian"></div>
        		 <div class="culture_titile">隐私声明</div>
        	</div>
	          <div class="privacy_prompt" style="height:600px;">
            <?php if(!empty($row)){echo $row['privacy_desc'];} ?>                
          </div>
          <div class="cultureBox">
            <div class="cultureXian"></div>
             <div class="culture_foots">隐私声明</div>
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
