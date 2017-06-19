<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<title>订单</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url();?>/static/css/rest.css" rel="stylesheet" />
<link href="<?php echo base_url();?>/static/css/order.css" rel="stylesheet" />
<link href="<?php echo base_url();?>/static/css/common.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery-1.11.1.min.js"></script>
<!--  <script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery.img_silder.js"></script> -->
</head>
<body>
	<!-- 订单导航 go -->
    <div class="headingLogo clear">
    	<div class="fl logo">
        	<a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url();?>/static/img/logo.png" alt="帮游旅游网"/></a>
        </div>
        <div class="fr orderNav orderNav_3"></div>
    </div>
	<!-- 订单导航 end -->
	<!-- 下单签约 go -->
   <div class="orderContent">
   <form action="#" method="post" id="order_form"> 
    <div class="orderMian">
    	<div class="orderThree-mian">
        	<!-- 订单信息 -->
        	<div class="bottomLine">
                <div class="title">订单信息</div>
                <div class="order-xx">
                    <p><i>订单号：</i></p>
                    <p><i>线路名称：</i><span class="textColor-green"><?php echo $linename;?></span></p>
                    <p><i>联系人：</i><?php echo $username;?>（TEL:<?php echo $mobile;?>;  E-MAIL:<?php echo $email;?>）</p>
                    <p><i>预定城市：</i><?php echo $cityname;?></p>
                    <p><i>出发时间：</i><?php echo $usedate;?></p>
                    <p><i>订单金额 ：</i><span class="textColor-red"><?php echo $money;?></span>元</p>
                    <p>
                        <i>使用优惠券：</i>
                        <select class="order_select">
                            <option>不使用</option>
                            <option>¥100</option>
                            <option>¥50</option>
                            <option>¥20</option>
                        </select>
                         用户没有优惠卷则不现实
                    </p>
                    <p><input type="text">币&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户没有游币则不现实</p>
                    <p><i>合计：</i><span class="textColor-red"><?php echo $money;?></span>元</p>
                </div>
            </div>
        	<!-- 邮箱信息 -->
        	<div class="bottomLine marginTop-20">
                <div class="title">邮箱信息</div>
                <div class="order-xx">
                    <p><span class="textColor-red">*</span><i>签约邮箱：</i>
                    <span class="mail" id="tourist_email">
                    <input type="text" style="padding-left:10px;" name="tourist_email" value="<?php echo $email;?>"></span>
                  	</p>
                    <p class="textColor-red fuKuan">付款完成后，您的邮箱将收到正式的、加盖合同章的合同，您也可以在会员中心查看和下载合同。</p>
                </div>
            </div>
        	<!-- 旅游合同 -->
        	<div class="bottomLine marginTop-20">
                <div class="title">旅游合同<span class="textColor-red heTong">请仔细阅读旅游合同范本，具体出游信息以您填写的订单为准，付款完成后您可在*会员中心-我的订单*下载包含完整订单信息的旅游合同。</span></div>
                <div class="htBoxContent">
                	<div class="marginTop-20"></div>
                	<div class="htItem">
                    	<div class="htText"></div>
                    </div>
                	<div class="htItem">
                    	<div class="title">额外约定</div>
                        <div class="yueDing clear">
                        	<div class="fl">是否同意转至其他旅行社出团？</div>
                            <div class="fr">
                            	<input type="radio" name="iszhuan" value="1">是　
                                <input type="radio" name="iszhuan" value="0" checked="checked">否
                            </div>
                        </div>
                        <div class="yueDing clear">
                        	<div class="fl">是否同意延期出团？</div>
                            <div class="fr">
                            	<input type="radio" name="isyan" value="1">是　
                                <input type="radio" name="isyan" value="0" checked="checked">否
                            </div>
                        </div>
                        <div class="yueDing clear">
                        	<div class="fl">是否同意改变其他线路出团？</div>
                            <div class="fr">
                            	<input type="radio" name="isgai" value="1">是　
                                <input type="radio" name="isgai" value="0" checked="checked">否
                            </div>
                        </div>
                        <div class="yueDing clear">
                        	<div class="fl">是否同意采用平团方式出团？</div>
                            <div class="fr">
                            	<input type="radio" name="iscai" value="1">是　
                                <input type="radio" name="iscai" value="0" checked="checked">否
                            </div>
                        </div>
                    	<div class="title bg-color">补充条款<a class="Core">显示明细</a></div>
                        <div class="hide_detail_box">
                        	<?php 
                        		if (empty($web_data ['supplement_clause'])) {
                        			echo "暂无补充条款";
                        		} else {
                        			echo $web_data ['supplement_clause'];
                        		}
                        	?>
                        </div>
                    </div>
                	<div class="htItem">
                    	<div class="title bg-color">安全提示<a class="Core">显示明细</a></div>
                        <div class="hide_detail_box">
                        	<?php 
                        		if (empty($web_data ['safety_tips'])) {
                        			echo "暂无安全提示";
                        		} else {
                        			echo $web_data ['safety_tips'];
                        		}
                        	?>
                        </div>
                    </div>
                    <div class="accept"><input name="agree_check" value="yes" type="checkbox"/>我已阅读并接受以上合同条款、补充条款、保险条款、安全提示和其他所有内容</div>
                    <p class="htItem-info">当前为旅游旺季，门市客人偏多，为避免长时间排队等候，请您优先悬着在网站签约、付款。我司会尽快处理您的订单，感谢您的
信赖与支持!</p>
                    
                </div>
            </div>

    	</div>
        <div class="orderFooter"><input class="btn-submit" id="submit" type="button" value="下一步"/></div>
    </div>
    </form>
   </div>
   <script>
	$(function(){
		$(".Core").click(function(){
			$(this).parent().next().toggle();
		});  
	});
	$('#submit').click(function(){
		var agree =[];
		$('input[name="agree_check"]:checked').each(function(){
			var a = agree.push($(this).val()); 
		}); 
		if (agree != "yes") {
			alert('请您阅读合同条款并同意后进行下一步');
			return false;	
		}
		var tourist_email = $("#tourist_email").text(); //签约邮箱 
		$.post(
			"<?php echo site_url('order_from/confirm_order/create_order')?>",
			$('#order_form').serialize(),
			function (data) { 
				data = eval('('+data+')');
				if (data.code == 2000) { 
					location.href="<?php echo site_url('order_from/confirm_order/order_success')?>";
				} else {
					alert(data.msg);
				}
			}
		);
	})
	
</script>
   
	<!-- 下单签约 end -->
    <div class="siteInfo">Copyrigght@2014-2015帮游网</div>
</body>
</html>
