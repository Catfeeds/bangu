<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>常见问题-帮游旅行网</title>
<meta name="description" content="帮游旅行网权威、专业的问题解答及使用帮助。旅游术语、常见问题、签署旅游合同问题、付款与发票问题、出游保障问题，退款、退换货问题，优惠政策问题，旅游保险问题，出发前问题，出游中问题，护照与签证问题，会员协议，积分规则，管家服务细则等常见问题解答" />
<meta name="keywords" content="旅游答疑，旅游合同，出游保障，管家服务" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static/css/common.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('static/css/aboutus.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
<style type="text/css">
.connect_web{ padding-top:15px;border-bottom:1px solid #e1e1e1;}
.connect_web ul li { margin-bottom:8px;color:#444;font-size:14px;}
.connect_style { margin-top:15px;margin-bottom:80px;}
.connect_style p { margin-bottom:10px;color:#444;font-size:14px;}
.common_question {}
.question_title { height:55px;line-height:55px;font-size:20px;color:#f60;}
.question1,.answer1 { margin-bottom:16px;position:relative;}
.question1 i{ width:17px;height:17px;background:url(/static/img/question1.png) 0px 0px no-repeat;position:absolute;}
.question1 div { font-size:16px;color:#2e9900;position:relative;margin-left:27px;}
.answer1 i{ width:17px;height:17px;background:url(/static/img/answer1.png) 0px 0px no-repeat;position:absolute;top:5px;}
.answer1 div { font-size:16px;color:#777;position:relative;margin-left:27px;line-height:150%;}
.answer1 p{ font-size:14px;}
.right_nav {bottom: 60px; right:50%; margin-right:-660px; width: 60px; top:200px;  position: fixed;}
.right_nav_content { width:120px;border-radius:10px;}
.right_nav_content ul li { text-align:center;width:60px;height:60px;background:#2e9900;margin-bottom:5px; color: #fff;}
.right_nav_content ul li a { width:60px;height:60px;position:relative;display:block;font-size:18px;color:#fff;font-family:"微软雅黑";}
.right_nav_content ul li a span { display:block;padding-top:7px; letter-spacing:3px; line-height: 20px;}
.return_top_ico { width:30px;height:15px;background:url(../../../static/img/return_top_ico.png) 0px 0px no-repeat;position:absolute;top:22px;left:15px;}
.return_foot_ico { width:30px;height:15px;background:url(../../../static/img/return_foot_ico.png) 0px 0px no-repeat;position:absolute;top:22px;left:15px;}
.right_nav_content ul li a span:hover { filter:alpha(opacity=70); /*IE滤镜，透明度60%*/-moz-opacity:0.7; /*Firefox私有，透明度60%*/opacity:0.7;/*其他，透明度60%*/}
.butler_list h2{ font-size: 16px; }
table{ border:1px solid #000;}

@media screen and (max-width: 1350px){
.right_nav{ display:none;}
}


</style>
</head>
<body>
<!--头部开始-->

<?php echo $this->load->view('common/article_header'); ?>
<!--头部结束--> 

<div class="container" style="min-height:500px;">
  <div class="w_1200">
    <div class="now_station">当前位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>>
    <a href="#">常见问题</a></div>

  



    <div class="clear">
    <!--左侧菜单开始-->        
	<?php echo $this->load->view('common/article_sidebar'); ?>
	<!--左侧菜单结束--> 
         
         
         <!--<div class="right_nav">
			<div class="right_nav_content">
    			<ul>
        			<li><a href="#" title="返回顶部"><i class="return_top_ico"></i></a></li>
          			<li><a href="#question1"><span>预定</span><span>问题</span></a></li>
            		<li><a href="#question2"><span>付款</span><span>发票</span></a></li>
            		<li><a href="#question3"><span>旅游</span><span>合同</span></a></li>
            		<li><a href="#question4"><span>预定</span><span>优惠</span></a></li>
            		<li><a href="#question5"><span>其他</span><span>事项</span></a></li>
            		<li><a href="#foot" title="前往底部"><i class="return_foot_ico"></i></a></li>
        		</ul>
    		</div>
		</div>-->
         
         
         
         
         
         
        <div class="aboutus_right_aside fr" style=" position:relative;">
        <div class="culture" style="padding-bottom:95px;">
          <div class="cultureBox">
                <div class="cultureXian"></div>
                 <div class="culture_titile">常见问题</div>
            </div>
          
          <!--====================   常见问题一   （可循环）===================-->
          <?php if(!empty($fag)){
              foreach ($fag as $k=>$v){
          	?>
          <div class="common_question" id="question<?php echo $k+1; ?>">
          		<div class="question_title"><?php echo $v['attr_name']; ?></div>
                
                <!--====================   可循环对答  ===================-->
                <?php if(!empty($v['son'])){
					foreach ($v['son'] as $key=>$val){
                	?>
                <div class="question_content clear">
                	<div class="question1">
                    	<i></i>
                        <div  id="id<?php echo $val['id']; ?>" name="id<?php echo $val['id']; ?>"><?php echo $val['title'] ?></div>
                    </div>
                    <div class="answer1">
                    	<i></i>
                        <div><?php echo $val['content']; ?></div>
                    </div>
                </div>
              <?php } }else{ ?>
              	
                  <div class="question_content clear">
                	<div class="question1">               	
                        <div>暂无相关内容</div>
                    </div>
                    <div class="answer1">   
                        <div></div>
                    </div>
                </div>     
             <?php  }?>
          </div>
           <?php } }?>  

          </div>
          <div class="cultureBox">
            <div class="cultureXian"></div>
             <div class="culture_foots">常见问题</div>
        </div> 
          
        </div>
      </div>
    <!--中间右侧内容结束--> 
    </div>
  </div>

<!--======================右侧导航开始=======================-->
<div class="right_nav">
	<div class="right_nav_content">
    	<ul>
    
        	<li><a href="#" title="返回顶部"><i class="return_top_ico"></i></a></li>
        	<?php if(!empty($atrr)){ foreach ($atrr as $k=>$v){?>
          	<li><a href="#question<?php echo $k+1; ?>"><span><?php echo $v['shortname']; ?></span></a></li>
      			<!--<li><a href="#question2"><span>付款</span><span>发票</span></a></li>
            <li><a href="#question3"><span>旅游</span><span>合同</span></a></li>
            <li><a href="#question4"><span>预定</span><span>优惠</span></a></li>
            <li><a href="#question5"><span>其他</span><span>事项</span></a></li> -->
            <?php }  }?>
            <li><a href="#foot" title="前往底部"><i class="return_foot_ico"></i></a></li>
        </ul>
    </div>
</div>
<!--======================右侧导航结束=======================-->

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