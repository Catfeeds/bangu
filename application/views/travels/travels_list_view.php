<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<meta name="keywords" content="<?php echo $keyword;?>" />
<meta name="description" content="<?php echo $description;?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/common.css" />
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/travel_note.css" />
<link rel="stylesheet" href="<?php echo base_url('static/css/jquery.mCustomScrollbar.css'); ?>">
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />

<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url('static'); ?>/js/jquery.lazyload.min.js" type=text/javascript></script>
<script src="<?php echo base_url('static'); ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
<style type="text/css">
    /*滚动条隐藏*/
    .mCSB_draggerContainer{ display: block !important; }
    .mCSB_dragger_bar{ background: #2e9900 !important; }
</style>
<script type="text/javascript">
window.onscroll=function(){
	if ($(window).scrollTop() >750 ) {
		$("#search_condition").addClass("fix_title_nav");
	} else {
		$("#search_condition").removeClass("fix_title_nav");
	}
}
$(window).load(function(){
    $(".hidden_destination").mCustomScrollbar({
        snapAmount:40,
        scrollButtons:{enable:true},
        keyboard:{scrollAmount:40},
        mouseWheel:{deltaFactor:40},
        scrollInertia:400
    });
});
</script>
<!--[if IE]>

<style> 

.city_name i{ display:none;}
.return_top{ display:none;}
.search_condition ul li img{ display:none;}

</style>

<![endif]-->



</head>
<body>
<!-- 头部 -->
<?php $this->load->view('common/header'); ?>

<div class="main" style="background:#fff;">
	<div class="travels_banner w_1200"><img src="<?php echo base_url('static'); ?>/img/page/travels_banner.jpg"/></div>
    <!--头部游记 -->
    <?php if(!empty($travelEssence)):?>
	<div class="travels_show_list clear w_1200">
    	<ul class="fr">
    		<?php
    			foreach($travelEssence as $key =>$val):
    			switch($val['usertype']) {
    				case 0: //用户
    					$authorPic = $val['litpic'];
    					if (!empty($val['meid']) && $val['mestatus'] == 1) {
    						$name = '体验师：'.$val['nickname'];
    						$type = 5;
    					} else {
    						$name = '会员:'.$val['nickname'];
    						$type = 0;
    					}
    					break;
    				case 1: //管家
    					$authorPic = $val['small_photo'];
    					$name = $grade[$val['grade']].'：'.$val['nickname'];
    					$type = 1;
    					break;
    			}
    		?>
        	<li class="travels_list_content <?php if ($key == 0) echo 'current_travel';?>">
            	<a class="author_img fl" href="<?php echo base_url('youji/'.$val['id'].'-'.$type.'.html'); ?>">
            		<img src="<?php echo $authorPic?>" alt="<?php echo $name;?>"/>
            	</a>
            	<h2 style=" font-weight: normal;" title="<?php echo $val['title']?>"><a class="travels_line fl" href="<?php echo base_url('youji/'.$val['id'].'-'.$type.'.html'); ?>"><?php echo $val['title']?></a></h2>
                <span class="author_name fl"><?php echo $name;?></span>
                <img class="green_line fr" src="<?php echo base_url('static'); ?>/img/page/green_line.png"/>
                
                <div class="travels_img_show">
               	 	<a href="<?php echo base_url('youji/'.$val['id'].'-'.$type.'.html'); ?>" >
                	<img src="<?php echo $val['cover_pic']?>" alt='<?php echo $val['title']?>' />
                	<div class="travels_text_show"><?php echo $val['title']?></div></a>
                </div>
                
            </li>
            <?php endforeach;?>
        </ul>
    </div>
    <?php endif;?>
  	<!--头部游记 -->
  	
	<!--=========================浮动导航======================= -->

    <div id="search_condition" class="float_nav">
    	<div class="search_condition w_1200 clear" >
            <ul class="fl">
				<!--目的地搜索-->
                <li class="travelAll <?php if(empty($pid)){echo 'choice_this';}?>"><a href="/youji/p-1.html"><span class="top_li_click">全部</span></a></li>
                <?php foreach($destArr as $val):?>
                <li class="<?php if($pid == $val['id']){echo 'choice_this';}?>">
               		<h2 style=" font-weight: normal; font-size: 16px;"><a href="<?php echo $val['link']?>">
               			<span class="top_li_click"><?php echo $val['kindname']?></span>
            			<img src="/static/img/page/custom_list_ico1.png" />
            		</a>
            		</h2>
                    <div class="travelXian"></div>
            		<div class="hidden_destination">
            			<?php foreach($val['lower'] as $v):?>
            			<dl class="clear" style="border:none;">
            				<dt class="destination_title fl"><?php echo $v['kindname']?></dt>
            				<dd class="destination_content fl">
            					<?php foreach($v['lower'] as $item):?>
            					<a class="<?php if($destid == $item['id']){echo 'choice_click';}?>" href="<?php echo $item['link']?>">
            						<span><?php echo $item['kindname']?><em></em></span>
            					</a>
            					<?php endforeach;?>
            				</dd>
            			</dl>
            			<?php endforeach;?>
            		</div>
                </li>
                <?php endforeach;?>
            </ul>
            <h3 style=" font-weight: normal;"><a href="<?php echo base_url('base/travel/write_travels'); ?>" class="write_travels fr">写游记</a></h3>
        </div>
    </div>
    <div class="travel_list_detail w_1200 clear">
    	<div class="travels_list_left fl">
            <div class="travels_list_info">
            	<ul class="clear">
            	<?php 
            		foreach($travelData as $val):
            		switch($val['usertype']) {
            			case 0: //用户
            				$authorPic = $val['litpic'];
            				if (!empty($val['meid']) && $val['mestatus'] == 1) {
            					$name = '体验师：'.$val['truename'];
            					$type = 5;
            				} else {
            					$name = '会员'.$val['truename'];
            					$type = 0;
            				}
            				break;
            			case 1: //管家
            				$authorPic = $val['small_photo'];
            				$name = array_key_exists($val['grade'], $grade) ?$grade[$val['grade']]:'管家'.'：'.$val['nickname'];
            				$type = 1;
            				break;
            		}
            	?>
            	<li>
            		<div class="travels_info_img">
                            <a href="<?php echo site_url('youji/'.$val['id'].'-'.$type.'.html'); ?>">
            				<img data-original="<?php echo $val['cover_pic']?>" src="/static/img/loading0.gif"  alt="<?php echo $val['title']?>" />
            			</a>
            			<div class="cover_info">目的地：<?php echo $val['destName']?></div>
            		</div>
            		<div class="travels_info_txt clear">
            			<a href=" "><img class="travels_author_photo fl" src="<?php echo $authorPic;?>" /></a>
                                <h2 style=" font-weight: normal; "title="<?php echo $val['title']?>"><a href="<?php echo site_url('youji/'.$val['id'].'-'.$type.'.html'); ?>" class="travels_info_line fl"><?php echo $val['title']?></a></h2>
            			<span class="travels_author_name fl"><?php echo $name;?></span>
            			<span class="comment_num fr"><i></i><?php echo $val['comment_count']?></span>
            			<span class="attention_num fr">
            				<?php if(empty($val['tnpid'])):?>
            				<i class="travelPraise" data-val="<?php echo $val['id']?>" style="background:url(/static/img/page/gray_heart.png)"></i>
            				<?php else:?>
            				<i class="travelPraise" data-val="<?php echo $val['id']?>" style="background:url(/static/img/page/red_heart.png)"></i>
            				<?php endif;?>
            				<span class="praiseNumber"><?php echo $val['praise_count']?></span>
            			</span>
            		</div>
            	</li>
            	<?php endforeach;?>
            	</ul>
            </div>
            <div class="pagination fr"><?php echo $this->page->create_page();?></div>
        </div>
        <div class="travels_list_right fr">
        	<div class="travels_hot_title clear">
            	<span class="newest click_this fl"><h3 style="font-weight: normal; font-size: 16px;">最热</h3></span>
                <i class="fl"></i>
                <span class="hotest fl"><h3 style="font-weight: normal; font-size: 16px;">最新</h3></span>
            </div>
            <div style="height:730px;overflow:hidden;">
            <div class="hot_travels_list new_travels_list">
            	<ul class="clear">
            		<?php
            		foreach($travelDataHot as $val):
            		switch($val['usertype']) {
            			case 0: //用户
            				$authorPic = $val['litpic'];
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
                	<li>
                    	<a href="<?php echo site_url('youji/'.$val['id'].'-'.$type.'.html'); ?>"><img class="hotest_img fl" src="<?php echo $val['cover_pic']?>" alt="<?php echo $val['title']?>" /></a>
                        <h2 style=" font-weight: normal; "title="<?php echo $val['title']?>"><a class="hot_place hot_place_link fl" href="<?php echo site_url('youji/'.$val['id'].'-'.$type.'.html'); ?>"><?php echo $val['title']?></a></h2>
                        <span class="travels_time fl">浏览<?php echo $val['shownum']?>次</span>
                    </li>
                   <?php endforeach;?>
                </ul>
            </div>
            <div class="new_travels_list">
            	<ul class="clear">
            		<?php
            			foreach($travelDataNew as $val):
            			switch($val['usertype']) {
            				case 0: //用户
            					$authorPic = $val['litpic'];
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
            			$time = time();
            			$addtime = strtotime($val['addtime']);
            			$endtime = $time - $addtime;
            			//得到分钟
            			$minute = floor($endtime / 60);
            			//得到小时
            			$hour = floor($minute / 60);
            			//得到天数
            			$day = floor($hour / 24);
            			if ($day >= 1) {
            				$name = $day.'天前';
            			} elseif ($hour >= 1) {
            				$name = $hour.'小时前';
            			} else {
            				$name = $minute.'分钟前';
            			}
            		?>
                	<li>
                    	<a href="<?php echo site_url('youji/'.$val['id'].'-'.$type.'.html'); ?>"><img class="hotest_img fl" src="<?php echo $val['cover_pic']?>" alt="<?php echo $val['title']?>" /></a>
                        <a class="hot_place hot_place_link fl" href="<?php echo site_url('youji/'.$val['id'].'-'.$type.'.html'); ?>"><?php echo $val['title']?></a>
                        <span class="travels_time fl"><?php echo $name;?></span>
                    </li>
                   <?php endforeach;?>
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/footer'); ?>
<?php echo $this->load->view('common/login_box1');  ?>
<script type="text/javascript">
//目的地浮动效果
$(".search_condition ul li").mouseover(function(){
	$(this).find(".hidden_destination").show();
	$(this).siblings('li').find(".hidden_destination").hide();
    $(this).find(".travelXian").show();
}).mouseout(function(){
	$(this).find(".hidden_destination").hide();
    $(this).find(".travelXian").hide();
})
$(".search_condition ul li").hover(function(){
    if($(this).hasClass("travelAll")){
        $(this).addClass("allColor");
    }else{
        $(this).addClass("choice_this_hover").siblings().removeClass("choice_this_hover");
    }
},function(){
    $(".allColor").removeClass("allColor");
    $(this).removeClass("choice_this_hover");
})
$(".travels_list_info ul li").hover(function(){
    $(this).find(".travels_info_img .cover_info").animate({top:'145px'},100)
},function(){
     $(this).find(".cover_info").stop().animate({top:'175px'},100)
})

//游记点赞与取消
$(".travelPraise").click(function(){
	var thisObj = $(this);
	var id = thisObj.attr('data-val');
	var count = (thisObj.next(".praiseNumber").text())*1;
	$.post("/travels/travels_list/praise",{travel_id:id},function(json){
		var data = eval('('+json+')');
		if (data.code == 2000) {
			if (data.msg == 'praise') { //游记点赞
				thisObj.next(".praiseNumber").text(count+1);
				thisObj.css("background","url(/static/img/page/red_heart.png)")
			} else { //取消点赞
				thisObj.next(".praiseNumber").text(count-1);
				thisObj.css("background","url(/static/img/page/gray_heart.png)")
			}
		} else if (data.code == 9000) {
			$('.login_box').css("display","block");
		} else {
			alert(data.msg);
		}
	});
	
})

$('#login_form1').submit(function(){
	var username = $("#login_form1").find('.input1').val();
	var pw = $("#login_form1").find('.input2').val();
	var yzm = $("#login_form1").find('.input3').val();
	if(username.length<=0){
		$('.info span a').html("账户不能为空");
		$('.info span').show();
		return false;
	}else{
		$('.info span').hide();
	}
	if(pw.length<=0){
		$('.info span a').html("请填写密码");
		$('.info span').show();
		return false;
	}else{
		$('.info span').hide();
	}
	if(yzm.length<=0){
		$('.info span a').html("请填写验证码");
		$('.info span').show();
		return false;
	}else{
		$('.info span').hide();
	}
	$.post(
		"<?php echo site_url('login/do_login')?>",
		$('#login_form1').serialize(),
		function(data) {
			data = eval('('+data+')');
			if (data.code == 2000) {
				location.reload();
			} else {
				$('#verifycode').trigger('click');
				$('.info span a').html(data.msg);
				$('.info span').show();
			}
		}
	);
	return false;
})

$(function(){
	//轮播
	$(".travels_list_content,.hot_travels_list ul li,.new_travels_list ul li").eq(5).css("border-bottom","none");
	$(".travels_hot_title span").eq(0).addClass("click_this");
	$(".new_travels_list").css("display","block");
	//游记内容展示 鼠标移上效果
	$(".travels_list_content").hover(function(){
		var index = $(this).index();
		n=index;
		clearInterval(lb);
		$(".travels_list_content").removeClass("current_travel");
		$(".travels_list_content").eq(index).addClass("current_travel");
	},function(){
		var index = $(this).index();
		var num = $(".travels_list_content").length-1;
		if(index<num){
			n=index+1;
		}
		if(index>=num){
			n=0;
		}
		lb = setInterval(lunbo,100000);
	});
	//右侧 最新最热点击切换
	$(".travels_hot_title span").eq(0).click(function(){
		$(".travels_hot_title span").removeClass("click_this");
		$(this).addClass("click_this");
		$(".new_travels_list").css("display","none");
		$(".new_travels_list").eq(0).css("display","block");
	});
	$(".travels_hot_title span").eq(1).click(function(){
		$(".travels_hot_title span").removeClass("click_this");
		$(this).addClass("click_this");
		$(".new_travels_list").css("display","none");
		$(".new_travels_list").eq(1).css("display","block");
	});
});
//$(".travels_list_content").eq(0).addClass("current");
var n=1;  //图片自动切换 开始
function lunbo(){
	$(".travels_list_content").removeClass("current_travel");
	$(".travels_list_content").eq(n).addClass("current_travel");
	n++;
	var num = $(".travels_list_content").length-1;
	if(n>num){
		n=0;
	}
}
lb = setInterval(lunbo,3000);//图片自动切换 结束
$(function(){
	$('.close_login_box').click(function(){
		$('.bg').css("display","none");
		$('.login_box').css("display","none");
	});
	$('.input1').blur(function(){
		var username = $(this).val();
		if(username.length>0){
			$('.info span').hide();
		}
	});
	$('.input2').blur(function(){
		var pw = $(this).val();
		if(pw.length>0){
			$('.info span').hide();
		}
	});
	$('.input3').blur(function(){
		var yzm = $(this).val();
		if(yzm.length>0){
			$('.info span').hide();
		}
	});
});

</script>
<script type="text/javascript">
	$(function(){
        $(".travels_info_img img").lazyload({
            effect : "fadeIn"
        });
    })
</script>

</body>
</html>