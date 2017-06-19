<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>基本资料_会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/user/user.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
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
			<div class="nav_right">
				<div class="user_title">我的资料</div>
				<div class="data_warp">
					<div class="pw_input">
						<label for="y_pW">注册帐号：</label> <span><?php echo $member['loginname']; ?></span>
					</div>
					<form action="<?php echo base_url('base/member/profile')?>"
						accept-charset="utf-8"
						data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
						data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
						data-bv-message="This value is not valid" method="post"
						onkeydown="if(event.keyCode==13)return false;" id="updataFrom"
						novalidate="novalidate" id="form" enctype="multipart/form-data"
						onsubmit="return checkForm(this)">
						
						<div class="pw_input">
							<label for="y_pW">我的昵称：</label> <input type="text"
								class="txt-m txt-grey nichen_input" name="nickname"
								value="<?php echo $member['nickname']; ?>" /> <i
								class="i_bt_ico">*</i> <span class="info_txt"><?php echo form_error('nickname' , '<div class="error2" style="color:red">' , '</div>');?></span>
						</div>
						<div class="pw_input">
							<label for="y_pW">性别：</label> <input type="radio" value="1"
								name="sex"
								<?php if($member['sex']=="1"){echo " checked='checked'";} ?> />男&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" value="0" name="sex"
								<?php if($member['sex']=="0"){echo " checked='checked'";} ?> />女</span>
						</div>
						<div class="pw_input">
							<label for="y_pW">我的邮箱：</label> <input type="text"
								class="txt-m txt-grey email_input" name="email"
								value="<?php echo $member['email']; ?>" /> <i class="i_bt_ico">*</i>
							<span class="info_txt"><?php echo form_error('email' , '<div class="error2" style="color:red">' , '</div>');?></span>
						</div>
						<div class="pw_input">
							<p class="bm_text">*以下为本站保密信息，预定产品时作为身份验证，不会用作其他用途！修改手机号码需要短信的验证</p>
						</div>

						<div class="pw_input">
							<label for="y_pW">联系手机：</label> <input type="text"
								class="txt-m txt-grey phone_input" id="mobile" name="mobile"
								value="<?php echo $member['mobile']; ?>" maxlength="11"/> <i class="i_bt_ico">*</i>
							<span class="info_txt"><?php echo form_error('mobile' , '<div class="error2" style="color:red">' , '</div>');?></span>
						</div>
                        <div class="pw_input">
							<label for="y_pW">短信验证码：</label> <input type="text"
								class="txt-m txt-grey yzm_input" name="yzm"
								value="" maxlength="4"/> <span class="yzm_button" id="get_mobile_code">获取验证码</span>&nbsp;<i class="i_bt_ico">*</i>
							<span class="info_txt"></span>
						</div>
						<div class="pw_input">
							<label for="y_pW">真实姓名：</label> <input type="text"
								name="truename" class="txt-m txt-grey turename_input"
								value="<?php echo $member['truename'] ?>" /> 
							<span class="info_txt"><?php echo form_error('truename' , '<div class="error2" style="color:red">' , '</div>');?></span>
						</div>
						<div class="pw_input">
							<label for="y_pW">身份证号：</label> <input type="text"
								class="txt-m txt-grey card_num" name="cardid"
								value="<?php echo $member['cardid']; ?>" /> 
                                <span class="info_txt"></span>
						</div>
						<div class="pw_input">
							<label for="y_pW">联系地址：</label> <input type="text"
								class="txt-m txt-grey live_address" name="address"
								value="<?php echo $member['address']; ?>" /> 
                                <span class="info_txt"></span>
						</div>
						<div class="pw_input">
							<label for="y_pW">邮编：</label> <input type="text"
								class="txt-m txt-grey youbian" name="postcode"
								value="<?php echo $member['postcode'];?>" maxlength="6"/> 
                                <span class="info_txt"></span>
						</div>
						<div class="submit_box">
							<input class="user_btn_submit" type="submit" name="btn"
								value="保存修改" />
						</div>
					</form>
				</div>
			</div>
			<!-- 右侧菜单结束 -->
		</div>
	</div>

	<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>
	</body>
</html>
<script>
//输入框必须输入数字
$('.phone_input,.yzm_input,.youbian').keyup(function(){  
	var c=$(this);  
	if(/[^\d]/.test(c.val())){//替换非数字字符  
	  var temp_amount=c.val().replace(/[^\d]/g,'');  
	  $(this).val(temp_amount);  
	}  
 });

$(".nichen_input").blur(function(){
	var nichen = $(this).val();
	if(nichen.length<=0){
		$(".info_txt").eq(0).html("");
	}
});
$(".email_input").blur(function(){
	var email_input = $(this).val();
	if(!email_input.match(/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/)&&email_input.length!=0){
		$(".info_txt").eq(1).html("您填写的邮箱格式不正确！");
		return false;
	}else{
		$(".info_txt").eq(1).html("");
	}
});
$(".phone_input").blur(function(){
	var phone_input = $(this).val();
	if(!phone_input.match(/^1[3-8]\d{9}$/)&&phone_input.length!=0){		
		$(".info_txt").eq(2).html("手机号码格式不正确！");
		return false;
	}else{
		$(".info_txt").eq(2).html("");
	}
	var mobile=<?php echo $member['mobile']; ?>;
	if(mobile!=phone_input){
		$(".info_txt").eq(3).html("请填写您收到的短信验证码！");
		return false;
	}
	
});
 /*$(".yzm_input").blur(function(){
	var mobile=<?php //echo $member['mobile']; ?>;
	alert(mobile); 
	var yzm_input = $(this).val();
	if(yzm_input.length<=0){
		$(".info_txt").eq(3).html("请填写您收到的短信验证码！");
		return false;
	}else{
		$(".info_txt").eq(3).html("");
	} 
}); */
$(".turename_input").blur(function(){
	var turename_input = $(this).val();
	if(turename_input.length<=0){
		$(".info_txt").eq(4).html("");
	}
});
$(".card_num").blur(function(){
	var card_num = $(this).val();
    if(!card_num.match(/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/)&&card_num.length!=0){
		$(".info_txt").eq(5).html("您填写的身份证号码格式不正确");
		return false;
	}else{
		$(".info_txt").eq(5).html("");
	}
});
$(".live_address").blur(function(){
	var live_address = $(this).val();
	if(live_address.length<=0){
		$(".info_txt").eq(6).html("");
	}
});
$(".youbian").blur(function(){
	var youbian = $(this).val();
	if(!youbian.match(/^[1-9][0-9]{5}$/)&&youbian.length!=0){
		$(".info_txt").eq(7).html("请填写正确的邮编号");
		return false;
	}else{
		$(".info_txt").eq(7).html("");
	}
});

function checkForm(o){ 
   var phone= o.mobile.value; //手机
   var nickname=o.nickname.value;//昵称
   var email=o.email.value; //邮箱
   var truename=o.truename.value;//真实姓名
 //  var yzm=o.yzm.value;//短信验证码
   var cardid=o.cardid.value;//身份证号
   var address=o.address.value;//居住地
   var postcode=o.postcode.value//邮编
   var myreg = /^1[3-8]\d{9}$/; //验证手机
   var  re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/; //验证邮箱
   var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;  //验证身份证
   var yb = /^[1-9][0-9]{5}$/;  //验证邮编
	if(''==nickname){
		$(".info_txt").eq(0).html('昵称不能为空！');
		   return false;
	}else{
		$(".info_txt").eq(0).html("");
	}
	if(''==email){
		$(".info_txt").eq(1).html('邮箱号码不能为空！');
		   return false;
	}else{
		$(".info_txt").eq(1).html("");
	}
	if(!email.match(re))
    {
       $(".info_txt").eq(1).html('邮箱格式不正确！');
       return false;
   }else{
		$(".info_txt").eq(1).html("");
	}
   if(''==phone){
	    $(".info_txt").eq(2).html('手机号码不能为空！');
	   return false;
	}else{
		$(".info_txt").eq(2).html("");
	}
	if(!phone.match(myreg))
   	{
        $(".info_txt").eq(2).html('请输入有效的手机号码！');
       return false;
   	}else{
		$(".info_txt").eq(2).html("");
	} 
	var card_num = $('input[name="cardid"]').val();
    if(!card_num.match(/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/)&&card_num.length!=0){
		$(".info_txt").eq(5).html("您填写的身份证号码格式不正确");
		return false;
	}else{
		$(".info_txt").eq(5).html("");
	}
	
/*  	if(''==yzm){
	    $(".info_txt").eq(3).html('请输入您收到的短信验证码！');
	   return false;
	}else{
		$(".info_txt").eq(3).html("");
	}  */
/* 	if(''==truename){
		$(".info_txt").eq(4).html('真实姓名不能为空！');
		   return false;
	}else{
		$(".info_txt").eq(4).html("");
	} */
/* 	if(''==cardid){
		$(".info_txt").eq(5).html('身份证号不能为空！');
		   return false;
	}else{
		$(".info_txt").eq(5).html("");
	} */
/* 	if(!cardid.match(reg))
    {
       $(".info_txt").eq(5).html('身份证号格式不正确！');
       return false;
    }else{
		$(".info_txt").eq(5).html("");
	} */
/* 	if(''==address){
		$(".info_txt").eq(6).html('居住地址不能为空！');
		   return false;
	}else{
		$(".info_txt").eq(6).html("");
	} */
/* 	if(''==postcode){
		$(".info_txt").eq(7).html('邮编不能为空！');
		   return false;
	}else{
		$(".info_txt").eq(7).html("");
	}  
	if(!postcode.match(yb))
    {
       $(".info_txt").eq(7).html('邮编号格式不正确！');
       return false;
    }else{
		$(".info_txt").eq(7).html("");
	} */
   //提交表单
/* 	if ($(this).hasClass('processing')) {
		alert('您已提交定制要求，正在处理中...');
		return false;
	} */
//	$(this).css({'cursor':'text'}).addClass('processing');
	$.post(
		"<?php echo site_url('base/member/profile')?>",
		$('#updataFrom').serialize(),
		function(data) {
 			data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
			} else {
				//$('.submit_coutom').css({'cursor':'pointer'}).removeClass('processing');
				//生成随机数
				var $chars = '0123456789'; 
				var rand_code = '';  
				for (i = 0; i < 6; i++) {  
				    rand_code += $chars.charAt(Math.floor(Math.random() * 10));  
				}  
			//	$('input[name="yzm"]').val(rand_code);
				alert(data.msg);
			} 
		}
	);
	return false;	   
 }

 //获取手机验证码
 $("#get_mobile_code").click(function(){ 
		var mobile = $('input[name="mobile"]').val(); 
		var npwMobile=<?php if(!empty($member['mobile'])){ echo $member['mobile'];}?>;
		if( mobile!=npwMobile){
		$.post(
				"<?php echo site_url('send_code/send_updataMobile_code')?>",
				{'mobile':mobile},
				function(data) {
					data = eval('('+data+')');
					if (data.code == 2000) {
						sendMessage();
						alert(data.msg);
					} else {
						alert(data.msg);
						$("#vcode").trigger("click");
						
					} 
				}
			);
		}else{
			alert('请修改你需要的手机号码');
		}
 })
 
//倒计时
var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
  　curCount = count;
　　//设置button效果，开始计时
	 $("#get_mobile_code").css({"cursor":"auto"}).attr('is_get_code' ,'0');
     $("#get_mobile_code").html(curCount + "秒");
     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
}

//timer处理函数
function SetRemainTime() {
	if (curCount == 0) {                
         window.clearInterval(InterValObj);//停止计时器
         $("#get_mobile_code").html("重新发送验证码");
		 $("#get_mobile_code").css({"cursor":"pointer"}).attr('is_get_code' ,'1');
    }
    else {
         curCount--;
         $("#get_mobile_code").html(curCount + "秒");
    }
}
</script>