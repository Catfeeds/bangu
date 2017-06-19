<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="/static/css/Butler_service.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('static/css/aboutus.css'); ?>" />
<link href="/static/css/common.css" rel="stylesheet" />
<script src="/static/js/jquery-1.11.1.min.js" type=text/javascript></script>
<title>会员积分规则-帮游旅行网</title>
</head>
<body>
<!--头部开始-->
<?php echo $this -> load -> view('common/article_header'); ?>
<!--头部结束--> 
        <div class="butler_main">
            <div class="butler_left">
                <ul>
                    <li><a href="/service/member_agreement">会员协议</a></li>
                    <li class="xieyi_lvs"><a href="/service/integral_agreement" class="xieyi_lvs">积分规则</a></li>
                </ul>
            </div>
           	<div class="float_right">
                <ul>           
                    <li><a href="#butle_1">积分专属</a></li>
                    <li><a href="#butle_2">积分作用</a></li>
                    <li><a href="#butle_3">积分价值</a></li>
                    <li><a href="#butle_4">积分获取规则</a></li>
                    <li><a href="#butle_5">积分有效期</a></li>
                    <li><a href="#butle_6">积分生效</a></li>   
                </ul>
            </div>
            <div class="butler_right">
                <div style=" display:block; text-align:center; height:40px; line-height:40px; font-size:24px; margin-top:10px;">会员积分规则</div>
            	<?php if(!empty($atrr)){
            		foreach ($atrr as $k=>$v){
         	    	if(!empty($v['son'])){
					foreach ($v['son'] as $key=>$val){	
            	?>
                <h2 id="butle_<?php echo $key + 1; ?>"><?php echo $key + 1; ?>.<?php echo $val['title']; ?></h2>
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