<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>_加入我们-帮游旅行网</title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static/css/common.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('static/css/aboutus.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
<style type="text/css">
.join_us_title { height:47px;line-height:47px;border-bottom:1px solid #e1e1e1;font-size:18px;color:#444;}
.position_request { padding-bottom:10px;}
.position_request_title { height:45px;line-height:45px;font-size:18px;color:#444;position:relative;cursor:pointer;}
.position_request_title i{ margin-left:10px;width:9px;height:5px;background:url(/static/img/sanjiao_11.png) 0px 0px no-repeat;position:absolute;top:20px;}
.click_this { color:#2e9900;cursor:pointer;}
.click_this i { margin-left:10px;width:9px;height:5px;background:url(/static/img/sanjiao_2.png) 0px 0px no-repeat;position:absolute;top:20px;}
.request_content { display:none;}
.request_content dl dt { font-size:14px;color:#444;margin-bottom:14px;}
.request_content dl dd { margin-bottom:15px;}
.request_content dl dd p { font-size:14px;color:#444;margin-bottom:10px;text-indent: 2em;color:#444;}
.connection_style { margin-top:20px;}
.connection_style p { font-size:14px;color:#444;margin-bottom:15px;}
</style>
</head>
<body>
<!--头部开始-->
<?php echo $this->load->view('common/article_header'); ?>
<!--头部结束--> 

<!--左侧菜单开始-->
<div class="container" style="">
  <div class="w_1200">
    <div class="now_station">当前位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>><a href="#">加入我们</a></div>
    <div class="clear eidAside">
    <!--左侧菜单开始-->
	<?php echo $this->load->view('common/article_sidebar'); ?>
    <!--左侧菜单结束--> 
    
    <!--中间右侧内容开始-->
    <div class="aboutus_right_aside fr"> 
    	<div class="culture">
        	<div class="cultureBox">
                <div class="cultureXian"></div>
                 <div class="culture_titile">加入我们</div>
            </div>
            <div class="join_us_title"><?php if(!empty($row)){ echo $row['hire_desc'];} ?></div>
                    
            <!--===================================   招聘职位开始  ================================-->
            <div class="position_request">
            
            	<!--===================================   职位一开始  ================================-->
            	<?php if(!empty($hire)){
 						foreach ($hire as $k=>$v){
            		?>
            	<div class="position_request_detail">
					<div class="position_request_title <?php if($k<3){echo 'click_this';} ?>"><?php echo $v['title'] ;?></div>
                    <div class="request_content" style="display:block;">
                   	  <dl>
                       	<dt>主要职责:</dt>
                        <dd>
                       	  <?php echo $v['responsibility'] ;?>
                        </dd>
						<dt>岗位要求：</dt>
                        <dd>
                         <?php echo $v['requirement'] ;?>
                        </dd>
                      </dl>
                    </div>
                </div>
                <?php } }?>
     
            <!--===================================   招聘职位结束  ================================-->
            <!--===================================   招聘联系方式  ================================-->
		<!-- 	<div class="connection_style">
                <p>公司地址：<span style="text-decoration:underline;">深圳市罗湖区深南东路2019号东乐大厦5楼508号</span></p>
                <p>联系人：陈小姐</p>
                <p>联系电话：0755-25834213</p>
                <p>简历投递：51Bangu@163.com</p>                
            </div> -->
        </div>
        <div class="cultureBox">
            <div class="cultureXian"></div>
             <div class="culture_foots">加入我们</div>
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
		

		//加入我们 职位滑动效果
		$(".position_request_title").click(function(){

		  var index = $(this).index(".position_request_title");

		  $(".request_content").each(function(){  
			  if($(this).index(".request_content")==index){
				  $(this).slideDown(400); 
				  $(this).siblings().addClass("click_this");
			  }else{
				 $(this).slideUp(400); 
				 $(this).siblings().removeClass("click_this");
			  } 
		  });
	});
});

</script>

</body>
</html>

