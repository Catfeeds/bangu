<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link href="/static/css/Butler_service.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('static/css/aboutus.css'); ?>" />
<link href="/static/css/common.css" rel="stylesheet" />
<script src="/static/js/jquery-1.11.1.min.js" type=text/javascript></script>
<title>管家服务总则-帮游旅行网</title>
</head>
<body>
<!--头部开始-->
<?php echo $this -> load -> view('common/article_header'); ?>
<!--头部结束--> 
        <div class="butler_main">
            <div class="butler_left">
                <ul>
                    <li><a href="/service/expert_service" >管家服务总则</a></li>
                    <li><a href="/service/member_service">会员协议</a></li>
                    <li><a href="Integral.html">积分规则</a></li>
                </ul>
            </div>
           	<div class="float_right">
                <ul>
                <?php if(!empty($atrr)){
						foreach ($atrr as $k=>$v){
						foreach ($v['son'] as $key=>$val){
                	?>
                	 <li><a href="#butle_<?php echo $key + 1; ?>"><?php echo $val['title'] ?></a></li>
                <?php } }} ?>
            	<!-- <li><a href="#butle_1">旅游管家服务总则</a></li>
                    <li><a href="#butle_2">抢单规则</a></li>
                    <li><a href="#butle_3">设计旅游方案</a></li>
                    <li><a href="#butle_4">支付与退款</a></li>
                    <li><a href="#butle_5">旅游服务规则</a></li>
                    <li><a href="#butle_6">佣金奖励</a></li>
                    <li><a href="#butle_7">管家等级规则</a></li>
                    <li><a href="#butle_8">管家资格考核</a></li> -->
                </ul>
            </div>
            <div class="butler_right">
            <?php if(!empty($atrr)){
            	foreach ($atrr as $k=>$v){
          if(!empty($v['son'])){
				foreach ($v['son'] as $key=>$val){
            ?>
                <div class="butler_title" id="butle_<?php echo $key + 1; ?>"><span><?php echo $val['title']; ?></span></div>
                <?php echo $val['content']; ?>
              <?php }}else{ echo '<br>暂无信息'; } } }else{ echo '暂无信息';} ?>
            </div>
        </div>
	<div style="winth:100%; background: #fff;margin-top:50px; border-top:1px solid #ccc; border-bottom:1px solid #ccc;">
<?php echo $this -> load -> view('common/article_footer'); ?>
</div>
</body>
</html>
<script type="text/javascript">
$(".float_right ul li a").click(function() {
	$(".float_right ul li a").removeClass("float_on");
	$(this).addClass("float_on");
	$(".float_right ul li a").css("border-left", "3px solid #fff");
	$(this).css("border-left", "3px solid #4c8704");
});
</script>


	












	

