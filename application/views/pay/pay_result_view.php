<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<title><?php if($status === true){echo '支付成功';}else{echo '支付失败';}?></title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/order.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
</head>
<body class="clear">
<!--  头部 -->
<div class="pay_header">
	<div class="w_1200 clear">
    	<div class="pay_logo_img fl"><a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url('static'); ?>/img/logo.png" style="margin-top:-3px;"/></a></div>
        <div class="pay_header_nav fr">
        	<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>
            <a href="/order_from/order/line_order">我的订单</a>
            <a href="#" style="border-right:none;">支付帮助</a>
        </div>
    </div>
</div>
<!--  主体内容 开始-->
<div class="main" style="height:auto;">
	<div class="main_center">
		<?php if ($status === true):?>
    	<div class="pay_success">
        	<div class="pay_success_title">
            	<img src="<?php echo base_url('static'); ?>/img/user/success_pay.png"/>
            </div>
            <div class="success_pay_txt">支付成功，我们的旅游管家稍后会联系您，感谢您对帮游的支持！祝您旅途愉快！</div>
            <div class="link_button clear">
            	<a href="<?php echo site_url('order_from/order/show_order_detail_'.$order_id.'.html')?>" class="check_order fl">查看订单详情</a>
                <a href="<?php echo sys_constant::INDEX_URL?>" class="fl">返回首页</a>
            </div>
        </div>
        <?php else:?>
        <div class="pay_fail">
        	<div class="pay_fail_txt">抱歉，支付失败！</div>
            <div class="order_center_link">支付失败,进入&nbsp;&nbsp;会员中心 -&nbsp;&nbsp;&nbsp;
            	<a href="<?php echo site_url('order_from/order/line_order')?>">订单中心</a>&nbsp;&nbsp;查看我的订单。
            </div>
            <div class="link_button clear">
            	<a href="<?php echo site_url('pay/order_pay/pay_type?oid='.$order_id)?>" class="check_order fl">重新支付</a>
                <a href="<?php echo sys_constant::INDEX_URL?>" class="fl">返回首页</a>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
<!--  主体内容   结束-->
<script type="text/javascript">
$(function(){
	//alert("支付成功/失败内容较少,所以就写在一个页面,用的时候判断一下显示哪个div 就行");
});
</script>
</body>
</html>