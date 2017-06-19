<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $web['title']?></title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url();?>/static/css/rest.css" rel="stylesheet" />
<link href="<?php echo base_url();?>/static/css/order.css" rel="stylesheet" />
<link href="<?php echo base_url();?>/static/css/common.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery-1.11.1.min.js"></script>
<!--  <script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery.img_silder.js"></script> -->
</head>
<body style="margin:0; background:#f2f2f2">
	<!-- 订单导航 go -->

    <div class="header">
        <div  class="wid_1200">
            <a href="/index/home"><img src="<?php echo base_url('static'); ?>/img/logo.png" class="shouye_logo"></a>
            <div class="head_right">
                <div class="shoye_yelhead">
					<img src="<?php echo base_url('static'); ?>/img/shoye_dianhua.jpg">
                     <!--<span class="hover_fenx"><a href="/share/share_list">旅游分享</a></span> -->
					<?php
					$this->username=$this->session->userdata('c_username');
					if(!isset($this->username) ||empty($this->username)){  ?>
                    
					<span><a href="/login">登陆</a>丨<a href="/register/index">注册</a></span>
					<?php }else{   ?>
					<span><a href="/order_from/order/line_order" class="username">您好，<?php echo $this ->session ->userdata('c_loginname');?></a>
					<a href="/login/logout">退出</a></span>
					<?php } ?>
				</div>
                <div class="shouye_nav">
                    <ul>
                        <!-- seo需要，路径后面加/ weiy编辑 -->
                        <li><a href="<?php echo sys_constant::INDEX_URL?>">首页</a></li>
                        <li><a href="/guanjia/">旅游管家</a></li>        <!-- 将guanj改为guanjia-->
                        <li><a href="/chujing/">出境游</a></li>          <!-- 将cj改为chujing-->
                        <li><a href="/guonei/">国内游</a></li>           <!-- 将cn改为guonei-->
                        <li><a href="/zhoubian/">周边游</a></li>         <!-- 将zb改为zhoubian-->
                        <li><a href="/zhuti/">主题游</a></li>            <!-- 将zt改为主题-->
                        <li><a href="/dzy/">定制游</a></li>
                        <li><a href="/youji/">游记攻略</a></li>          <!-- 将yj改为youji-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
	<!-- 订单导航 end -->
	<!-- 预定成功 go -->
   <div class="orderContent"> 
    <div class="orderMian" style=" border:none;">
    	<div class="orderfour-content">
        	<div class="orderfour-text">
        		<div style="width: 600px;display: inline-block;">
	            	<div class="thinksTitle">感谢预定，您的订单已分配给您的专属管家，请等待管家确认</div>
	                <p>我们会尽快确认您的订单，18：00以后的订单将顺延至次日9：00后确认。</p>
	                <p>确认通过以后,我们会以短信或电话的方式提醒您登录会员中心签约付款.</p>
	                <div class="prompt">温馨提醒</div>
                </div>
                <?php if (!empty($banner)):?>
                <div style="float:right;margin-right: 100px;">
                	<a href="<?php echo $banner['url']?>" >
                		<img style="width:400px;height:200px;" src="<?php echo $banner['pic']?>">
                	</a>
                </div>
                <?php endif;?>
                <ul class="textList">
                    <li>如果您对行程有任何问题，请致电管家：<span style="color:#e46e01;"><?php echo $expert['realname']?> ：<?php echo $expert['mobile']?></li>
                	<li>请您在订单完成确认后，尽快完成付款，我们最迟会在出游前一天将出团通知（包括集合时间、地点、航班号、航站楼、紧急联系人等出游相关的明确介绍）发送给您 </li>
                	<li>订单确认后如未及时付款，将不占实际名额，帮游旅游网有权取消该次预定</li>
                	<li>付款成功后您可登录“会员中心”-“我的订单”下载旅游合同</li>
                	<li>订单提交后如需修改订单（变更线路、日期、人数等），请致电400-096-5166（免长途费）</li>
                </ul>
            </div> 
            <div class="orderFooter shuang_btn">
                <a class="btn-link btn-fanhui" href="/admin/b2/order_manage/go_order_detail?order_id=<?php echo $id?>" class="btn-fanhui">订单详情</a>
            </div>
        </div>
    </div>
   	</div>
	<!-- 预定成功 end -->
    <style>
    .foot_box{ width:100%; overflow:hidden; background:#fff; padding-bottom:160px;}
    </style>
    <div class=" foot_box">
   <div class="login-foot clear">
	<ul>
    	<li><a href="/admin/b2/login">管家登录</a><span>丨</span></li>
    	<li><a href="/admin/b1/index">供应商登录</a><span>丨</span></li>
    	<li><a href="/article/privacy_desc" target="_blank">隐私声明</a><span>丨</span></li>
        <li><a href="#">网站地图</a><span>丨</span></li>
        <li><a href="/article/index" target="_blank">常见问题</a><span>丨</span></li>
        <li><a href="/article/recruit" target="_blank">加入我们</a><span>丨</span></li>
        <li><a href="/article/contact_us" target="_blank">联系我们</a><span>丨</span></li>
        <li><a href="/article/about_us" target="_blank">关于我们</a></li>
    </ul>
    <div class="login-keep">
    	<?php echo 'Copyright © 2006-2015 ' . $web['webname'] . ' ' . $web['url'] . ' | 营业执照 | ICP证：' . $web['icp']; ?>
    </div>
</div>
</div>
</body>
</html>
