<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $web['title']?></title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/common.css" />
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/travel_note.css" />
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
window.onscroll=function(){
	if ($(window).scrollTop() >1130 ) {
		$("#fix_title").addClass("fix_title_nav");
		$(".float_right_content ").show();
	} else {
		$("#fix_title").removeClass("fix_title_nav");
		$(".float_right_content ").hide();
	}
}
</script>
</head>
<body>
<!-- 头部 -->
	<?php $this->load->view('common/header'); ?>

<div class="main">
  <div class="weizhi w_1200">
        <p>您的位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a><span class="right_jiantou">></span><a href="/expert/expert_detail">管家详情</a><span class="right_jiantou">></span><a href="/expert/expert_travelsl">管家游记</a>
        </p>
  </div>
  <div class="img_banner">
  	<div class="big_banner"><img src="<?php echo base_url('static'); ?>/img/page/expert_travel.png"/></div>
  	<div class="small_banner w_1200"><img src="<?php echo base_url('static'); ?>/img/page/expert_travel.png"/></div>
    <div class="shadow_bg"></div>
  </div>
  <!--=========================================   体验师游记信息   ===========================================-->
  <div class="travel_detail">
  	<div class="travel_detail_info">
    	<div class="w_1200 clear">
        	<div class="expert_img fl"><img src="<?php echo base_url('static'); ?>/img/page/dz_details_icon_1.png"/></div>
            <h1 class="travel_big_title fl">城市观光——深圳出发,青海9天游</h1>
            <div class="fl" style="margin-top:18px;width:1040px;">
            	<div class="fl" style="width:160px;">
            		<div class="expert_name fl">陌尘泱泱</div>
                	<div class="expert_grade fl">初级专家</div>
                </div>
                <div class="travel_line_name fl">游记线路：赛舍不尔法隆8日自助游</div>
                <div class="evaluate fr" style="margin-right:0px;">顾客评价：<span>4.2</span></div>
                <div class="turnover fr">总成交量：<span>313</span></div> 
                <a class="consult_num fr consult_num1" href="#comment_travel" style="margin-top:10px;margin-right:0px;"><i></i><span>20</span></a>
                <span class="zan_num fr" style="margin-top:10px;margin-right:20px;"><i></i><span>20</span></span> 
                <!--<a class="report_travel_note fr"></a> --><br/>
                <div class="report_time fl">发表时间：2015-04-30</div>
                <ul class="travel_type fl">
                	<li>单位包团</li>
                    <li>海岛休闲</li>
                    <li>水上运动</li>
                </ul>
                
            </div>
        </div>
    </div>
    
  <div class="w_1200">
  <div class="travels_detail clear"> 
  	<!--===========================    左侧边栏 开始  ===========================-->
  	<div class="travels_left_side fl clear">
		<div class="travel_detail_text fl">初夏，渝帆与来自全国各地的二十多位摄影、旅游大咖一起参加了三清山的采风活动，行程一共五天，我们走遍了三清山的主要景点，遇上了晴天、雨天、阴天、雾天等各种气候，也看到了三清山在各种天气下的不同面貌，这其中22号的下午的一场日落让我们印象最为深刻。</div>
    	
        <div class="travel_detail_content fl">
        	<div class="travel_content_title clear" id="fix_title">
            	<ul class="fl" id="nav">
                	<li class="current_choice"><a href="#item1" class="one">边走边拍</a></li>
                    <li><a href="#item2" class="two">酒店速写</a></li>
                    <li><a href="#item3" class="three">美食写真</a></li>
                </ul>
                <div class="float_right_content fr">
                	<a href="#comment_travel" class="consult_num fr consult_num2" style="margin-top:12px;right:15px;"><i></i><span>20</span></a>
                	<span class="zan_num fr" style="margin-top:12px;right:15px;"><i></i><span>20</span></span>
            	</div>
            </div>
            <div class="travel_content_info">
            
            <!-- =========================边走边拍============================= -->
            	<div class="take_picture item" id="item1">
                	<div class="take_picture_title title_bg">
                    	<div><i></i>边走边拍</div>
                    </div>
                    <div class="take_pricute_img">
                    	<img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                        <span>美丽的喀纳斯,建议行程4个小时</span>
                        <img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                        <img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                    </div>
                </div>
            <!-- =========================酒店速写============================= -->
                <div class="take_picture travel_live item" id="item2">
                	<div class="travel_live_title title_bg">
                    	<div><i></i>酒店速写</div>
                    </div>
                    <div class="take_pricute_img">
                    	<img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                        <span>拉萨平措康桑青年酒店</span>
                        <img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                        <img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                    </div>
                </div>
             <!-- =========================美食写真============================= -->
                <div class="take_picture find_cate item" id="item3">
                	<div class="find_cate_title title_bg">
                    	<div><i></i>美食写真</div>
                    </div>
                    <div class="take_pricute_img">
                    	<img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                        <span>千万要备干粮,要饿死的节奏</span>
                        <img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                        <img src="<?php echo base_url('static'); ?>/img/page/travel_note_img1.jpg"/>
                    </div>
                </div>
                <div class="the_end item" id="item4">
                	<div><img src="<?php echo base_url('static'); ?>/img/page/end_txt.png"/></div>
                </div>
            </div>
            
        </div>
        <div id="comment_travel" class="fl" style="width:100%;height:1px;margin-top:-15px;"></div>
        <!-- --------------         评论开始       -------------------- -->
    	<div class="personal_comment fl">
        	<form action="" method="post">
        	<div class="travel_comment">
            	<div class="comment_title"><span>评论</span>(132)</div>
                <div class="comment_content"><textarea name="" placeholder="楼主拍的照片真美..." class="comment_txt"></textarea><span><em class="font_num">0</em>/100</span></div>
                <div class="comment_button"><input type="submit" name="submit" value="发表评论"/></div>
            </div>
            </form>
        	<div class="check_comment">
            <!----------------------------评论列表  开始---------------------------->
            	<ul>
                	<li class="user_comment_list clear">
                    	<div class="user_photo fl"><img src="<?php echo base_url('static'); ?>/img/page/user_comment_1.png"/></div>
                        <div class="user_name fl">天王盖地虎</div>
                        <div class="cmment_content fl">当当当，游记已经在攻略首页第二帧置顶咯，真是华丽丽地上头条啦，感谢截图留念下，分享给更多的朋友们来围观吧~</div>
                        <div class="comment_time fl">发表于：2015-07-29 18:17:15</div>
                    </li>
                    
                    <li class="user_comment_list clear">
                    	<div class="user_photo fl"><img src="<?php echo base_url('static'); ?>/img/page/user_comment_1.png"/></div>
                        <div class="user_name fl">小鸡顿蘑菇</div>
                        <div class="cmment_content fl">有趣的活动~~ 有很多海上活动，我没做过，你查查看，香蕉船 冲浪 那些</div>
                        <div class="comment_time fl">发表于：2015-09-04  12:48:01</div>
                    </li>
                    
                    <li class="user_comment_list clear">
                    	<div class="user_photo fl"><img src="<?php echo base_url('static'); ?>/img/page/user_comment_1.png"/></div>
                        <div class="user_name fl">Mecal</div>
                        <div class="cmment_content fl">如果不是冬天有雾，一定会更迷人的。</div>
                        <div class="comment_time fl">发表于：2015-09-04  12:48:01</div>
                    </li>
                    
                    <li class="user_comment_list clear">
                    	<div class="user_photo fl"><img src="<?php echo base_url('static'); ?>/img/page/user_comment_1.png"/></div>
                        <div class="user_name fl">小鸡顿蘑菇</div>
                        <div class="cmment_content fl">有趣的活动~~ 有很多海上活动，我没做过，你查查看，香蕉船 冲浪 那些</div>
                        <div class="comment_time fl">发表于：2015-09-04  12:48:01</div>
                    </li>
                    
                    <li class="user_comment_list clear">
                    	<div class="user_photo fl"><img src="<?php echo base_url('static'); ?>/img/page/user_comment_1.png"/></div>
                        <div class="user_name fl">Mecal</div>
                        <div class="cmment_content fl">如果不是冬天有雾，一定会更迷人的。</div>
                        <div class="comment_time fl">发表于：2015-09-04  12:48:01</div>
                    </li>
                </ul>
                <div class="page fr" style="height:50px;line-height:50px;background:#f00;color:#fff;width:600px;text-align:center;font-size:20px;">此处分页</div>
            <!----------------------------评论列表  结束---------------------------->    
            </div>
        </div>
        <!--**************************      体验师个人游记信息   评论 结束     ******************************-->
    </div>
    <!--===========================   体验师个人游记 右侧边栏 结束   ===========================-->
    
    <!--===========================   体验师个人游记 右侧边栏 开始   ===========================-->
    <div class="travels_right_side">
    	<div class="travel_note_share">
        	<div class="travel_share_title clear"><span class="fl">游记推荐</span><a href="#" class="fr">更多></a></div>
            <div class="travel_recommend_list">
            	<ul>
                	<li class="clear">
                    	<div class="travel_recommend_img fl"><img src="<?php echo base_url('static'); ?>/img/page/travel_recommend1.png"/></div>
                        <div class="travel_recommend_info fl">
                        	<p class="travel_recommend_line fl">塞舌尔布法塞舌尔布法</p>
                            <span class="travel_recommend_name fl">孟夕</span>
                            <span class="travel_recommend_time fl">2015-07-30</span>
                        </div>
                    </li>
                    
                    <li class="clear">
                    	<div class="travel_recommend_img fl"><img src="<?php echo base_url('static'); ?>/img/page/travel_recommend1.png"/></div>
                        <div class="travel_recommend_info fl">
                        	<p class="travel_recommend_line fl">塞舌尔布法塞舌尔布法</p>
                            <span class="travel_recommend_name fl">孟夕</span>
                            <span class="travel_recommend_time fl">2015-07-30</span>
                        </div>
                    </li>
                    <li class="clear">
                    	<div class="travel_recommend_img fl"><img src="<?php echo base_url('static'); ?>/img/page/travel_recommend1.png"/></div>
                        <div class="travel_recommend_info fl">
                        	<p class="travel_recommend_line fl">塞舌尔布法塞舌尔布法</p>
                            <span class="travel_recommend_name fl">孟夕</span>
                            <span class="travel_recommend_time fl">2015-07-30</span>
                        </div>
                    </li>
                    <li class="clear">
                    	<div class="travel_recommend_img fl"><img src="<?php echo base_url('static'); ?>/img/page/travel_recommend1.png"/></div>
                        <div class="travel_recommend_info fl">
                        	<p class="travel_recommend_line fl">塞舌尔布法塞舌尔布法</p>
                            <span class="travel_recommend_name fl">孟夕</span>
                            <span class="travel_recommend_time fl">2015-07-30</span>
                        </div>
                    </li>
                    <li class="clear">
                    	<div class="travel_recommend_img fl"><img src="<?php echo base_url('static'); ?>/img/page/travel_recommend1.png"/></div>
                        <div class="travel_recommend_info fl">
                        	<p class="travel_recommend_line fl">塞舌尔布法塞舌尔布法</p>
                            <span class="travel_recommend_name fl">孟夕</span>
                            <span class="travel_recommend_time fl">2015-07-30</span>
                        </div>
                    </li>
                    <li class="clear">
                    	<div class="travel_recommend_img fl"><img src="<?php echo base_url('static'); ?>/img/page/travel_recommend1.png"/></div>
                        <div class="travel_recommend_info fl">
                        	<p class="travel_recommend_line fl">塞舌尔布法塞舌尔布法</p>
                            <span class="travel_recommend_name fl">孟夕</span>
                            <span class="travel_recommend_time fl">2015-07-30</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    	
        <div class="travel_product">
        	<div class="travel_share_title travel_product"><span style="margin-left:8px;">游记相关产品</span></div>
            <div class="travel_product_list">
            	<ul class="clear">
                	<li class="travel_product_detail">
                    	<a href="#"><img src="<?php echo base_url('static'); ?>/img/page/travel_product1.jpg" class="travel_product_img"/>
                        <div class="product_info clear">
                        	<div class="ranking_list fl">NO.<span>1</span></div>
                            <p class="product_name fl">[清明]<三亚5日>TUNIU...全网销量第1...</p>
                            <span class="product_price fr">¥ <i>13499</i> </span>
                        </div></a>
                    </li>
                    <li class="travel_product_detail">
                    	<a href="#"><img src="<?php echo base_url('static'); ?>/img/page/travel_product1.jpg" class="travel_product_img"/>
                        <div class="product_info clear">
                        	<div class="ranking_list fl">NO.<span>2</span></div>
                            <p class="product_name fl">[清明]<三亚5日>TUNIU...全网销量第1...</p>
                            <span class="product_price fr">¥ <i>13499</i> </span>
                        </div></a>
                    </li>
                    <li class="travel_product_detail">
                    	<a href="#"><img src="<?php echo base_url('static'); ?>/img/page/travel_product1.jpg" class="travel_product_img"/>
                        <div class="product_info clear">
                        	<div class="ranking_list fl">NO.<span>3</span></div>
                            <p class="product_name fl">[清明]<三亚5日>TUNIU...全网销量第1...</p>
                            <span class="product_price fr">¥ <i>13499</i> </span>
                        </div></a>
                    </li>
                    <li class="travel_product_detail">
                    	<a href="#"><img src="<?php echo base_url('static'); ?>/img/page/travel_product1.jpg" class="travel_product_img"/>
                        <div class="product_info clear">
                        	<div class="ranking_list fl">NO.<span>4</span></div>
                            <p class="product_name fl">[清明]<三亚5日>TUNIU...全网销量第1...</p>
                            <span class="product_price fr">¥ <i>13499</i> </span>
                        </div></a>
                    </li>
                    <li class="travel_product_detail">
                    	<a href="#"><img src="<?php echo base_url('static'); ?>/img/page/travel_product1.jpg" class="travel_product_img"/>
                        <div class="product_info clear">
                        	<div class="ranking_list fl">NO.<span>5</span></div>
                            <p class="product_name fl">[清明]<三亚5日>TUNIU...全网销量第1...</p>
                            <span class="product_price fr">¥ <i>13499</i> </span>
                        </div></a>
                    </li>
                </ul>
            </div>
        </div>
    
    
    </div>
    <!--===========================   体验师个人游记 右侧边栏 结束   ===========================-->
     
  </div>
</div>

<!-----------------底部  结束----------------->
<?php $this->load->view('common/footer'); ?>
<!-----------------底部  结束----------------->

<script type="text/javascript">
$(function(){
	//浮动导航 点击效果
	$("#fix_title li").click(function(){
		$("#fix_title li").removeClass("current_choice");
		$(this).addClass("current_choice");
	});
	
	//评论列表第一条记录上边框
	$(".user_comment_list").eq(0).css("border-top","1px solid #e1e1e1");
	
	//评论字数计算
	$(".comment_txt").keyup(function(){
		var num = $(this).val().length;
		$(".font_num").text(num);
	});
	
	//点赞效果
	var foo=true;
	$(".zan_num i").click(function(){
		var num = parseInt($(".zan_num span").html());
		if(foo){
			$(".zan_num span").text(num+1);
			alert("点赞成功!");
			foo=false;
		}else{
			$(".zan_num span").text(num-1);
			alert("您已取消赞!");
			foo=true;
		}
	});
	$(".consult_num2").click(function(){
		$("#comment_travel").css("margin-top","-15px");
	});
	$(".consult_num1").click(function(){
		$("#comment_travel").css("margin-top","-125px");
	});
	
	
	$(".ranking_list").eq(0).addClass("num_one_color");
	//右侧边栏 鼠标移上效果
	$(".travel_product_detail").eq(0).css("border-top","none");
	$(".travel_product_detail").eq(0).find(".travel_product_img").fadeTo("slow", 0.99);
	$(".travel_product_detail").eq(0).find(".product_info").css("padding-top","10px");
	$(".travel_product_detail").hover(function(){
		  $(".travel_product_img").hide();
		  $(".product_info").css("padding-top","26px");
		  $(this).find(".travel_product_img").fadeTo("slow", 0.99);
		  $(this).find(".product_info").css("padding-top","10px");
	}); 
	
});

//浮动导航滚动切换
$(document).ready(function(){
    $(window).scroll(function(){
        var top = $(document).scrollTop();          //定义变量，获取滚动条的高度
        var menu = $("#nav");                      //定义变量，抓取#nav
        var items = $(".travel_content_info").find(".item");
        var curId = "";                             //定义变量，当前所在的楼层item #id
        items.each(function(){
            var m = $(this);                        //定义变量，获取当前类
            var itemsTop = m.offset().top;        //定义变量，获取当前类的top偏移量
            if(top > itemsTop-10){
                curId = "#" + m.attr("id");
            }else{
                return false;
            }
        });

        //给相应的楼层设置cur,取消其他楼层的cur
        var curLink = menu.find(".current_choice a");
        if( curId && curLink.attr("href") != curId ){
            curLink.parent().removeClass("current_choice");
            menu.find( "[href=" + curId + "]" ).parent().addClass("current_choice");
        }
        // console.log(top);
    });
	$(".one").click(function(){
	   $("html,body").animate({scrollTop:$("#item1").offset().top},600);
	})
	$(".two").click(function(){
	   $("html,body").animate({scrollTop:$("#item2").offset().top},600);
	})
	$(".three").click(function(){
	   $("html,body").animate({scrollTop:$("#item3").offset().top},600);
	})
    
});
</script>
</body>
</html>
