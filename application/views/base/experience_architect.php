<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>体验师申请_旅游体验师_会员中心-帮游旅行网</title>
<meta content="旅游体验师,旅行体验师,帮游体验师" name="keywords">
<meta content="想成为帮游旅行网体验师吗？快来申请吧！" name="description">
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/user/user.css');?>" rel="stylesheet" />
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
			<div class="addly_back">
				<div class="addly_title">体验师申请</div>
			    <div class="addly_dangqian">当前头像</div>
			    <div class="user_tx"><img src="<?php if(!empty($member)){ echo $member['litpic'];} ?>" /></div>
			    <div class="addly_Prompt">请确认以下个人信息是否有误,请填写真实信息.</div>
					<form class="addly_form" method="post" action="<?php echo base_url('base/customer_service/updata_member_message')?>" onkeydown="if(event.keyCode==13)return false;" novalidate id="form" enctype="multipart/form-data" >
			    <table style="font-size:13px;">
			        <tbody>
			        	<tr>
			                <td><div align="right">注册账号：</div></td>
			                <td class="account"><?php  if(!empty($member)){ echo $member['loginname'];} ?> </td>
			            </tr>
			            <tr>
			                <td><div align="right">我的昵称：</div></td>
			                <td><input id=name name="nickname" value="<?php if(!empty($member)){ echo $member['nickname'];} ?>" size=30 check="2"> <i>*</i><span class="info1"></span></td>
			            </tr>
			            <tr>
			            	<td><div align="right">性别：</div></td>
			            	<td class="xingbie">
			            	<input type="radio" value="1" name="sex" <?php if($member['sex']=="1"){echo " checked='checked'";} ?> />男&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" value="0" name="sex" <?php if($member['sex']=="0"){echo " checked='checked'";} ?> />女
			            	</td></tr>
			            <tr>
			                <td><div align="right">职业：</div></td>
			                <td><input id=nameID   name="job"  value="<?php echo $member['job']; ?>" size="30" check="2"toupper="true"></td> 
			            </tr>
			            <tr>
			                <td><div align="right">个性标签：</div></td>
			                <td><input id=user name="label" size=30 check="2" value="<?php echo $member['label']; ?>"></td>
			            </tr>
			            <tr>
			                <td><div align="right">邮箱：</div></td>
			                <td><input  name="email" value="<?php echo $member['email']; ?>" size="30" id=money check="2"> <i>*</i><span class="info2"></span></td>
			            </tr>
			            <tr>
			                <td><div align="right">联系手机：</div></td>
			                <td><input name="mobile"  class="text1" id="phone" value="<?php echo $member['mobile']; ?>" size="30" maxlength="11" > <i>*</i><span class="info3"></span></td>
			            </tr>
			            <tr>
			                <td><div align="right">真实姓名：</div></td>
			                <td><input size="30"  class="text1" name="truename"  value="<?php echo $member['truename']; ?>"  check="2"></td>
			 
			            </tr>
			            <tr>
			                <td><div align="right">身份证号：</div></td>
			                <td><input id=poss size="30" check="2" name="cardid" value="<?php echo $member['cardid']; ?>"  maxlength="18"></td>
			            </tr>
			            <tr>
			                <td><div align="right">所在地：</div></td>
			                <td><input id=phone size=30 check="2" name="address" value="<?php echo $member['address']; ?>" ></td>
			            </tr>
			            <tr>
			                <td><div align="right">邮编：</div></td>
			                <td><input class="text1" id="youbian" size=30 check="1" name="postcode"  value="<?php echo $member['postcode']; ?>" ></td> 
			            </tr>
			        
			            </tbody>
			          
			    </table>
                <div class="person_talk clear">
			    <div class="character fl">个性独白：</div>
			    	<div class="addly_text fl"><textarea placeholder="哈哈哈" name="talk"><?php if(!empty($member['talk'])){ echo $member['talk'];} ?></textarea></div></div>
			    <div class="addly_btn"><input type="submit" value=提交></div>
			     
			</form>
			</div>
			<!-- 右侧菜单结束 -->
		</div>
	</div>

	<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>
    
<script type="text/javascript">
$(function(){
	$(".mc dl dt").removeClass("cur");
	$("#user_nav_5 dt").addClass("cur");
	
	
	$('#phone,#youbian').keyup(function(){  
		var c=$(this);  
		if(/[^\d]/.test(c.val())){//替换非数字字符  
		  var temp_amount=c.val().replace(/[^\d]/g,'');  
		  $(this).val(temp_amount);  
		}  
	 });
	$("#name").blur(function(){
		var name = $(this).val();
		if(name.length<=0){
			$(".info1").html("昵称不能为空!");
			return false;
		}else{
			$(".info1").html("");
		}
	});
	$("#money").blur(function(){
		var money = $(this).val();
		if(money.length<=0){
			$(".info2").html("邮箱号码不能为空!");
			return false;
		}else if(!money.match(/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/)){
			$(".info2").html("邮箱号码格式不正确!");
			return false;
		}else{
			$(".info2").html("");
		}
	});
	$("#phone").blur(function(){
		var phone = $(this).val();
		if(phone.length<=0){
			$(".info3").html("手机号码不能为空!");
			return false;
		}else if(!phone.match(/^1[3-8]\d{9}$/)){
			$(".info3").html("手机号码格式不正确!");
			return false;
		}else{
			$(".info3").html("");
		}
	});
	$(".addly_btn").click(function(){
		var name = $("#name").val();
		var email = $("#money").val();
		var phone = $("#phone").val();
		if(name.length<=0){
			$(".info1").html("昵称不能为空!");
			return false;
		}else{
			$(".info1").html("");
		}
		if(email.length<=0){
			$(".info2").html("邮箱号码不能为空!");
			return false;
		}else if(!email.match(/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/)){
			$(".info2").html("邮箱号码格式不正确!");
			return false;
		}else{
			$(".info2").html("");
		}
		if(phone.length<=0){
			$(".info3").html("手机号码不能为空!");
			return false;
		}else if(!phone.match(/^1[3-8]\d{9}$/)){
			$(".info3").html("手机号码格式不正确!");
			return false;
		}else{
			$(".info3").html("");
		}
	});
});
</script>
	</body>
</html>
