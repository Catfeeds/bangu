<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $note_detail['travel_theme']?>_<?php echo $note_detail['destName']?>_游记攻略-帮游旅行网</title>
<meta name="keywords" content="<?php echo $note_detail['destName']?>旅游,<?php echo $note_detail['destName']?>旅游攻略,地名游记攻略,攻略下载" />
<meta name="description" content="帮游旅游网<?php echo $note_detail['destName']?>攻略游记，记录了驴友们在<?php echo $note_detail['destName']?>旅游过程中的景点、线路、美食、住宿、交通、购物、风土人情等各方面的旅游攻略信息参考和下载，让您放心旅行" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/common.css" />
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/travel_note.css" />
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/pagination.css" />
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery.pagination.js"></script>
<script type="text/javascript">
window.onscroll = function() {
	if ($(window).scrollTop() > 400) {
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
	<?php $this -> load -> view('common/header'); ?>
<div class="main">
  	<div class="weizhi w_1200">
        <p>您的位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a><span class="right_jiantou">></span><a href="/travels/travels_list">游记攻略</a><span class="right_jiantou">></span><a href="###">个人游记详情</a>
        </p>
  </div>
  <!--=========================================   体验师游记信息   ===========================================-->
  <div class="travel_detail">
  	<div class="travel_detail_info">
    	<div class="w_1200 clear">
        	<div class="expert_img fl"><img src="<?php echo $note_detail['small_photo']?>"/></div>
            <h2 class="travel_big_title fl" title="<?php echo $note_detail['travel_theme']?>"><?php echo $note_detail['travel_theme']?></h2>
            <div class="travel_person_info fl">
            	<div class="fl" style="width:160px;">
                	<div class="expert_name fl"><?php echo $note_detail['e_name']?></div>
                	<div class="expert_grade fl"><?php echo $note_detail['e_grade']?></div>
                </div>
                
                <div class="travel_line_name fl">
                    <?php if(($note_detail['lineid'])): ?>
                        <a href="/line/line_detail_<?php echo $note_detail['lineid'].'.html'?>">旅游线路: <?php echo $note_detail['linename']?></a>
                    <?php endif; ?>
                </div>
                <a href="#comment_travel" class="consult_num fr consult_num1" style="right:0px;"><i></i><span><?php echo $note_detail['comment_count']?></span></a>
                <span class="zan_num fr" style="right:0px;"><i data-val="<?php echo $note_id?>" onclick="praise(this)"></i><span><?php echo $note_detail['praise_count']?></span></span>
                <!--<a href="#" class="report_travel_note fr">发表游记</a> --><br/>
                <div class="report_time fl">发表时间：<?php echo date('Y-m-d',strtotime($note_detail['publish_time']))?></div>
               <!-- <ul class="travel_type fl">
                    <?php if(isset($note_detail['line_attr_arr']) && !empty($note_detail['line_attr_arr'])):?>
                        <?php foreach($note_detail['line_attr_arr'] AS $k=>$v):?>
                            <li><?php echo $v; ?></li>
                        <?php endforeach; ?>

                <?php else: ?>
                    <li>无</li>
                <?php endif; ?>
                </ul> -->

            </div>
        </div>
    </div>

<div class="w_1200">
<div class="travels_detail clear">
  	<!--===========================    左侧边栏 开始  ===========================-->


  	<div class="travels_left_side fl clear">

    <div class="lvtu_yx">
    	<div class="yinxiag_name">旅途印象:</div>
        <span><?php echo $note_detail['travel_impress']?></span>
    </div>


		<!--<div class="travel_detail_text fl"><?php echo $note_detail['content']?></div>-->
        <div class="travel_detail_content fl">
        	<div class="travel_content_title clear" id="fix_title">
            	<ul class="fl" id="nav">
                	<li class="current_choice"><a href="#item1" class="one">边走边拍</a></li>
                    <li><a href="#item2" class="two">酒店速写</a></li>
                    <li><a href="#item3" class="three">美食写真</a></li>
                </ul>
                <div class="float_right_content fr">
                	<a href="#comment_travel" class="consult_num fr consult_num2" style="margin-top:12px;right:15px;"><i></i><span><?php echo $note_detail['comment_count']?></span></a>
                	<span class="zan_num fr" style="margin-top:12px;right:15px;"><i data-val="<?php echo $note_id?>" onclick="praise(this)"></i><span><?php echo $note_detail['praise_count']?></span></span>
            	</div>
            </div>
            <div class="travel_content_info">
            <!-- =========================边走边拍============================= -->
            	<div class="take_picture item" id="item1">
                	<div class="take_picture_title title_bg">
                    	<div><i></i>边走边拍</div>
                    </div>
                    <div class="take_pricute_img">
                    <?php if(!empty($note_pic)):?>
                    <?php foreach ($note_pic as $k => $vl):?>
                    <?php if($vl['pictype']==3):?>
                    <span><?php echo $vl['description']?></span>
                    <img src="<?php echo $vl['t_pic']; ?>"/>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            <!-- =========================酒店速写============================= -->
                <div class="take_picture travel_live item" id="item2">
                	<div class="travel_live_title title_bg">
                    	<div><i></i>酒店速写</div>
                    </div>
                    <div class="take_pricute_img">
                   	<?php if(!empty($note_pic)):?>
                   	<?php foreach ($note_pic as $k => $vl):?>
                    <?php if($vl['pictype']==2):?>
                    <span><?php echo $vl['description']?></span>
                    <img src="<?php echo $vl['t_pic']; ?>"/>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
             <!-- =========================美食写真============================= -->
                <div class="take_picture find_cate item" id="item3">
                	<div class="find_cate_title title_bg">
                    	<div><i></i>美食写真</div>
                    </div>
                    <div class="take_pricute_img">
                    <?php if(!empty($note_pic)):?>
                    <?php foreach ($note_pic as $k => $vl):?>
                    <?php if($vl['pictype']==1):?>
                    <span><?php echo $vl['description']?></span>
                    <img src="<?php echo $vl['t_pic']; ?>"/>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="the_end item" id="item4">
                	<div><img src="<?php echo base_url('static'); ?>/img/page/end_txt.png"/></div>
                </div>
            </div>
        </div>
        <div id="comment_travel" class="fl" style="width:100%;height:1px;margin-top:-125px;"></div>
        <!--          评论开始        -->
        <?php if($note_detail['is_show']==1){ ?>
    	<div class="personal_comment fl" >
        	<form  method="post" id="publish_comment">
        	<div class="travel_comment">
            	<div class="comment_title"><span>评论</span>(<?php echo $note_detail['comment_count']?>)</div>
                <div class="comment_content"><textarea  name="comment" placeholder="评论内容..." class="comment_txt"></textarea><span><em class="font_num">0</em>/100</span>
                <input type="hidden" name="note_form_id" value="<?php echo $note_id?>"/>
                </div>
                <div class="comment_button"><input type="submit" name="submit" value="发表评论"/></div>
            </div>
            </form>
        	<div class="check_comment">
            <!--评论列表  开始-->
            	<ul id="comment_data_list"></ul>
                <div id="comment_Pagination" class="pagination"></div><!--此处分页-->
                <!-- 评论列表  结束 -->
            </div>
        </div>
        <?php } ?>
        <!--**************************      体验师个人游记信息   评论 结束     ******************************-->
    </div>
    <!--===========================   体验师个人游记 右侧边栏 结束   ===========================-->

    <!--===========================   体验师个人游记 右侧边栏 开始   ===========================-->
    <div class="travels_right_side">
    	<div class="travel_note_share">
        	<div class="travel_share_title clear"><span class="fl"><h2 style=" font-weight: normal; font-size: 16px;">游记推荐</h2></span><a href="<?php echo base_url('travels/travels_list')?>" class="fr">更多></a></div>
            <div class="travel_recommend_list">
            	<ul>
                    <?php foreach($recommend_note as $k=>$v):
                                    switch($v['usertype']) {
                                    case 0: //用户
                                        if (!empty($val['meid']) && $val['mestatus'] == 1) {
                                            $type = 5;
                                        } else {
                                            $type = 0;
                                        }
                                        break;
                                    case 1: //管家
                                        $type = 1;
                                        break;
                                }

                    ?>
                    <a target="_blank" href="<?php echo base_url('youji/' . $v['note_id'] . '-' . $type . '.html'); ?>">    <!-- 将yj改为youji,添加后缀.html-->
                	<li class="clear">
                    	<div class="travel_recommend_img fl"><img src="<?php echo $v['cover_pic']?>"/></div>
                        <div class="travel_recommend_info fl">
                        	<p class="travel_recommend_line fl"><?php echo $v['title']?></p>
                            <span class="travel_recommend_name fl"><?php echo $v['publisher']?></span>
                            <span class="travel_recommend_time fl"><?php echo date('Y-m-d',strtotime($v['addtime']))?></span>
                        </div>
                    </li>
                    </a>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="travel_product">
        	<div class="travel_share_title travel_product"><span style="margin-left:8px;"><h2 style=" font-weight: normal; font-size: 16px; padding-left: 8px;">游记相关产品</h2></span></div>
            <div class="travel_product_list">
            	<ul class="clear">
                    <?php
                    	$i=1; foreach($relate_products as $key=>$item){
                        // 将cj和gn改为line,添加后缀.html
                    	//$line_url = in_array(1 ,explode(',',$item['overcity'])) ? '/cj/'.$item['line_id'] : '/gn/'.$item['line_id'];
                        $line_url = in_array(1 ,explode(',',$item['overcity'])) ? '/line/'.$item['line_id'].'.html' : '/line/'.$item['line_id'].'.html';
                    ?>
                	<li class="travel_product_detail">
                    	<a target="_blank" href="<?php echo $line_url;?>"><img src="<?php echo $item['line_pic']?>" class="travel_product_img"/>
                        <div class="product_info clear">
                        	<div class="ranking_list fl">NO.<span><?php echo $i; ?></span></div>
                            <p class="product_name fl"><?php echo mb_strlen($item['line_name'])>18 ? mb_substr($item['line_name'], 0,18).'...' : $item['line_name'];?></p>
                            <span class="product_price fr">¥ <i><?php echo $item['lineprice']?></i> </span>
                        </div></a>
                    </li>
                <?php $i++;
						}
					?>
                </ul>
            </div>
        </div>
    </div>
    <!--===========================   体验师个人游记 右侧边栏 结束   ===========================-->
  </div>
</div>
<!-- 底部  结束-->
<?php $this -> load -> view('common/footer'); ?>
<!--底部  结束-->
<script type="text/javascript">

var pageIndex = 0;
var pageSize   = 10;
var total_comment = <?php echo $total_comment?>;


$(function(){
             InitComment(0);
             if(total_comment>pageSize){
                $("#comment_Pagination").pagination(<?php echo $total_comment?>, {
                    callback: PageCallback,
                    prev_text: '上一页',
                    next_text: '下一页',
                    items_per_page: pageSize,
                    num_display_entries: 6,//连续分页主体部分分页条目数
                    current_page: pageIndex,//当前页索引
                    num_edge_entries: 2//两侧首尾分页条目数
             });
             }

             function PageCallback(index, jq) {
                 InitComment(index);
             }




	//浮动导航 点击效果
	$("#fix_title li").click(function(){
		$("#fix_title li").removeClass("current_choice");
		$(this).addClass("current_choice");
	});

	//评论字数计算
	$(".comment_txt").keyup(function(){
		var num = $(this).val().length;
		$(".font_num").text(num);
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

    $('#publish_comment').submit(function(){
         $.post(
               "<?php echo base_url('travels/travels_list/publish_comment')?>",
                $('#publish_comment').serialize(),
                function(data){
                    data = eval('('+data+')');
                    if(data.status==200){
                        alert(data.msg);
                        location.reload();
                    }else if(data.status==-400){
                         $('.login_box').css("display","block");
                    }else{
                        alert(data.msg);
                    }

                });
  return false;
});

});

 //评论分页
    function InitComment(pageIndex){

         $.post('<?php echo base_url()?>travels/travels_list/travel_comment',
                    {"note_id":<?php echo $note_id?>,"pageSize":pageSize,'pageIndex':pageIndex+1},
                    function(msg){
                        msg = eval('('+msg+')');
                       var html = "";
                        $.each(msg.result,function(key,value){
                             html += "<li class='user_comment_list clear'>";
                             html += "<div class='user_photo fl'><img src='"+value['litpic']+"'/></div>";
                             html += "<div class='user_name fl'>"+value['nickname']+"</div>";
                             html += "<div class=cmment_content fl>"+value['reply_content']+"</div>";
                             html += "<div class='comment_time fl'>"+value['publish_time']+"</div>";
                             html += "</li>";
                         });
                $('#comment_data_list').html(html);
				//评论列表第一条记录上边框
				$(".user_comment_list").eq(0).css("border-top","1px solid #e1e1e1");
    });
}
$(".user_comment_list").parent().css("border-top","1px solid #e1e1e1");
function is_login(){
    var user_id = "<?php echo $this->session->userdata('c_userid');?>";
    if(user_id==undefined || user_id==''){
        $('.login_box').css("display","block");
    }
}


function praise(obj){
    var user_id = "<?php echo $this->session->userdata('c_userid');?>";
    var note_id = $(obj).attr('data-val');
    if(user_id==undefined || user_id==''){
        $('.login_box').css("display","block");
    }else{
         $.post("<?php echo base_url('travels/travels_list/click_praise')?>",
            {'c_id':user_id,'note_id':note_id},
            function(data){
                data = eval('('+data+')');
                if(data.status==200){
                    alert(data.msg);
                     location.reload();
                }else if(data.status==-400){
                    $('.login_box').css("display","block");
                }else{
                    alert(data.msg);
                }
            });
    }
}


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