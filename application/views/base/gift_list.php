<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的礼品_会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.SuperSlide.2.1.1.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
<link type="text/css"href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
</head>

<body>
<!-- 头部 -->
<?php $this->load->view('common/header'); ?>
<div id="user-wrapper">
    <div class="container clear"> 
        <!--左侧菜单开始-->
        <?php $this->load->view('common/user_aside');  ?>
        <!--左侧菜单结束--> 
        <!-- 右侧菜单开始 -->
        <div class="nav_right" style="position: relative;">
            <div class="user_title"><span>我的礼品</span>抽奖中的礼品到帮游手网及APP端使用</div>
            <div class="consulting_warp">
                <div class="consulting_tab">
                    <div class="hd cm_hd clear">
                        <ul>
                            <li class="<?php if(empty($type) || $type==0){ echo 'on';} ?>" data-val="0"><a href="#">全部</a></li>
                            <li class="<?php if(!empty($type)){ if($type==1){echo 'on';} } ?>" data-val="1"> <a href="#" >未使用</a></li>
                            <li class="<?php if(!empty($type)){ if($type==2){echo 'on';} } ?>"  data-val="2"><a href="#" >已使用</a></li>
                            <li class="<?php if(!empty($type)){ if($type==3){echo 'on';} } ?>" data-val="3"><a href="#" >已过期</a></li>
                        </ul>
                    </div>
                    <ul class="consulting_list">
                        <?php 
	                        if(!empty($row)){
							foreach ($row as $k=>$v){	
	                      	 if($v['lstatus']==0 && $v['lgstatus']!=2){ ?>
                        <li>
                            <div class="gift_coupon ">
                                <dl class="clear">
                                    <dt class="fl"> <img src="<?php echo  $v['logo'];?>" > </dt>
                                    <dd class=" fr">
                                        <h1><?php echo $v['gift_name']; ?>(礼品的名称)</h1>
                                        <i class="gift_icon_1"></i>
                                        <p><span><<?php echo  $v['linename'];?>></span> <?php echo  $v['linetitle'];?> </p>
                                        <div  class="gift_money fl"><span>价值</span><i>￥<?php echo  $v['worth'];?></i></div>
                                        <div class="gift_period fr"><span>有效期：</span><i><?php echo date('Y.m.d', strtotime($v['starttime'])); ?>-<?php echo date('Y.m.d', strtotime($v['endtime'])); ?></i></div>
                                    </dd>
                                </dl>
                                
                                <div class="gift_explain">
                                    <p class="fl">说明：</p>
                                    
                                    <?php echo  $v['description'];?> <i class=" gift_icon_<?php if($v['lstatus']==1){ echo 4;}else if($v['lstatus']==2 || $v['lgstatus']==2){echo 5;} ?>  gift_icon"></i> </div>
                            <div class="gift_icon_3"></div>
                            </div>
                            <div class="gift_coupon gift_sorce"> <img src="/static/img/page/office_qrcode.jpg" style="max-width:120px;">
                                <p>关注官网微信号,赢取更多礼品</p>
                                <i class="gift_icon_2 gift_icon"></i> </div>
                            <?php }else{?>
                            <div class="gift_coupon gift_noused">
                                <dl class="clear">
                                    <dt class="fl"> <img src="<?php echo  $v['logo'];?>" > </dt>
                                    <dd class=" fr">
                                        <h1><?php echo $v['gift_name']; ?>(礼品的名称)</h1>
                                        <p><span><<?php echo  $v['linename'];?>></span> <?php echo  $v['linetitle'];?> </p>
                                        <div  class="gift_money fl"><span>价值</span><i>￥<?php echo  $v['worth'];?></i></div>
                                        <div class="gift_period fr"><span>有效期：</span><i><?php echo date('Y.m.d', strtotime($v['starttime'])); ?>-<?php echo date('Y.m.d', strtotime($v['endtime'])); ?></i></div>
                                    </dd>
                                </dl>
                                <div class="gift_explain">
                                    <p class="fl">说明：</p>
                                    <?php echo  $v['description'];?> <i class=" gift_icon_<?php if($v['lstatus']==1){ echo 4;}else if($v['lstatus']==2 || $v['lgstatus']==2){echo 5;} ?>  gift_icon"></i> </div>
                            </div>
                            <?php } } }?>
                        </li>
                    </ul>
                    <div class="pagination">
                        <ul class="page">
                            <?php if(! empty ( $row )){ echo $this->page->create_c_page();}?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">
$(function(){
	$(".mc dl dt").removeClass("cur");	
	$("#user_nav_7 dt").addClass("cur");
    //tab 的切换
	$('.cm_hd').find('li').on('click', function () {
		$('.cm_hd').find('li').removeClass("on");
		$(this).addClass("on");	
		var val=$(this).attr('data-val');
		if(val==0){ //全部
			window.location.href="/base/gift/gift_list_0_1.html";
		}else if(val==1){ //未使用
			window.location.href="/base/gift/gift_list_1_1.html";
		}else if(val==2){ //已使用
			window.location.href="/base/gift/gift_list_2_1.html";
		}else if(val==3){ //已过期
			window.location.href="/base/gift/gift_list_3_1.html";
		}
	})
	$(".gift_icon_1").click(function(){
		$(this).parent().parent().parent().next().animate({
			left:0,	
		},500);
	});
	$(".gift_sorce").click(function(){
		$(this).animate({
			left:700,	
		},500)
	})
});

</script>
</body>
