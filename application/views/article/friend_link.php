<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>_友情链接-帮游旅行网</title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static/css/common.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('static/css/aboutus.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
<style type="text/css">
.apply_link {
	margin-top:12px;
	padding-bottom:12px;
	color:#838383;
	font-size:14px;
	line-height:200%;
	border-bottom:1px solid #e1e1e1;
}
.apply_link span {
	color:#444;
	font-size:18px;
}
.connect_type {
	color:#4c8704;
}
.connect_type b {
	color:#f00;
}
.link_type { border-bottom:1px solid #e1e1e1;}
.link_type_title { height:60px;line-height:60px;font-size:18px;color:#4c8704;}
.link_type_img li { width:88px;margin-right:50px;margin-bottom:15px;float:left;font-size:14px;color:#5f5f5f;}
.link_type_img li img { width:88px;height:31px;}
.link_type_web li { margin-right:160px;height:18px;overflow:hidden;margin-bottom:15px;float:left;font-size:14px;color:#5f5f5f;}
.link_type_word li { width:173px;height:18px;overflow:hidden;float:left;font-size:14px;color:#444;margin-bottom:12px;}
</style>
</head>
<body>
<!--头部开始-->
<?php echo $this->load->view('common/article_header'); ?>
<!--头部结束--> 

<!--左侧菜单开始-->
<div class="container" style="">
  <div class="w_1200">
    <div class="now_station">当前位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>><a href="#">友情链接</a></div>
    <div class="clear"> 
    
 	<!--左侧菜单开始-->        
	<?php echo $this->load->view('common/article_sidebar'); ?>
    <!--左侧菜单结束--> 
      
      <!--中间右侧内容开始-->
      <div class="aboutus_right_aside fr">
        <div class="culture" style="padding-bottom:65px;">
          <div class="cultureBox">
            <div class="cultureXian"></div>
             <div class="culture_titile">友情链接</div>
          </div>
          <div class="apply_link"> 
          <?php if(!empty($row)){ echo $row['friendlink_desc'];} ?>
          </div>
        <?php if(!empty($friend_link1)){ ?>  
          <div class="link_type">
          	<div class="link_type_title">图片链接</div>
          	<div class="link_type_content">
            	<ul class="link_type_img clear">
            	   <?php foreach ($friend_link1 as $k=>$v){ ?> 	
                	<li><a target="_blank" href="<?php echo $v['url']; ?>"><img src="<?php echo $v['icon'] ?>" /></a></li>  
                	<?php } ?>       
                </ul>
            </div>
          </div>
        <?php }?>
        
        <?php if($friend_link2){ ?>
          <div class="link_type">
          	<div class="link_type_title">网站合作</div>
          	<div class="link_type_content">
            	<ul class="link_type_web clear">
            	 <?php foreach ($friend_link2 as $k=>$v){ ?>
                	<li><a target="_blank" href="<?php echo $v['url']; ?>"><?php echo $v['name'] ?></a></li>
                  <?php }?>
                </ul>
            </div>
          </div>
         <?php }?>
         
          <?php if($friend_link3){ ?>
          <div class="link_type" style="border-bottom:none;">
          	<div class="link_type_title">文字链接</div>
          	<div class="link_type_content">
            	<ul class="link_type_word clear">
            	 <?php foreach ($friend_link3 as $k=>$v){ ?>
                	<li><a target="_blank" href="<?php echo $v['url']; ?>"><?php echo $v['name'] ?></a></li>
  			   <?php }?>
                </ul>
            </div>
          </div>
          <?php }?>
          <div class="cultureBox">
            <div class="cultureXian"></div>
             <div class="culture_foots">友情链接</div>
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

