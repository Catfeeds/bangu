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
<script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery-1.11.1.min.js"></script>
<!--  <script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery.img_silder.js"></script> -->
</head>
<body>
	<!-- 订单导航 go -->
    <div class="headingLogo clear">
    	<div class="fl logo">
        	<a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url();?>/static/img/logo.png" alt="帮游旅游网"/></a>
        </div>
        <div class="fr orderNav orderNav_2"></div>
    </div>
	<!-- 订单导航 end -->
	<!-- 确认签证材料 go -->
   <div class="orderContent"> 
    <div class="orderMian">
    	<div class="orderTwo-content">
            <?php echo $content?>
            <p class="textColor-red">我接受以上签证材料的要求作为合同要约的一部分，并已清楚了解我需要提供的签证材料，且确保我可以在截至收取材料前递交所需的签证材料到指定地址。</p>
            <div class="orderFooter"><a href="<?php echo site_url('order_from/confirm_order/confirmOrder');?>" class="btn-submit">提交订单</a>
            <a class="btn-help" href="<?php echo site_url('/article/contact_us') ?>" target=_blank>需要帮忙？点此咨询订单</a></div>
        </div>
    </div>
   </div>
	<!-- 确认签证材料 end -->
    <div class="siteInfo">Copyrigght@2014-2015帮游网</div>
</body>
</html>
