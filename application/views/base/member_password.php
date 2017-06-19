<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码_会员中心-帮游旅行网</title>
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
			<div class="nav_right">
				<div class="user_title">修改密码</div>
				<div class="passWord_warp">
      	<?php echo form_open('/base/member/updata_password');?>
        			<div class="pw_input update_password">
						<label for="y_pW">当前密码：</label><input type="hidden"
							value="<?php echo $member['loginname']; ?>" name="loginname" /> <input
							name="pwd" type="password" class="txt-m txt-grey"
							placeholder="请输入当前使用密码" id="y_pW" /> 
					</div>
                    <div class="password-state-inner txt-grey"><?php echo form_error('pwd' , '<div class="error2" style="color:red;margin-top:-10px;">' , '</div>');?></div>
					<div class="pw_input update_password">
						<label for="y_pW">新密码：</label> <input name="pwd1" type="password"
							class="txt-m txt-grey" id="x_pW" placeholder="请输入您要设置的密码" maxlength="20"/> 
						<span class="page_icon icon_pass_tip"> 如何设置安全密码
							<div class="icon_pass_tip_con">
								建议采用数字和字母混合<br>避免使用有规律的数字和字母<br> 避免与账户名、手机号、生日等部分或完全相同 <span
									class="z">◆</span> <span class="y">◆</span>
							</div>
						</span>
					</div>
					<!--<div class="password-state-inner txt-grey">由字母、数字或符号组成的6-20位半角字符，区分大小写</div> -->
                    <div class="password-state-inner txt-grey"><?php echo form_error('pwd1' , '<div class="error2" style="color:red;margin-top:-10px;">' , '</div>');?></div>
					<div class="pw_input update_password">
						<label for="y_pW">确认密码：</label> <input name="pwd2" type="password"
							class="txt-m txt-grey" placeholder="请再次输入新密码" id="z_pW" /> 
					</div>

					<div class="password-state-inner txt-grey"><?php echo form_error('pwd2' , '<div class="error2" style="color:red;margin-top:-10px;">' , '</div>');?></div>
					<div><?php if(!empty($ok) && $ok==1){ echo '<span style="color:#42D255;">'.$message.'</span>'; }else{ if(!empty($message)){ echo '<span style="color:red;">'.$message.'</span>';}}?></div>	

					<div class="submit_box">
						<input class="user_btn_submit" type="submit" value="确认" />
					</div>
					</form>
				</div>
			</div>
			<!-- 右侧菜单结束 -->
		</div>
	</div>
	<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">
$(function(){
	$("#y_pW").blur(function(){
		var pw1 = $(this).val();
		if(pw1.length<=0){
			$(".password-state-inner").eq(0).html("原密码不能为空");
			$(".password-state-inner").eq(0).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(0).css("margin-top","0px");
			$(".password-state-inner").eq(0).html("");
		}
		
	});
	$("#x_pW").blur(function(){
		var pw2 = $(this).val();
		if(pw2.length<=0){
			$(".password-state-inner").eq(1).html("新密码不能为空");
			$(".password-state-inner").eq(1).css("margin-top","-10px");
			return false;
		}else if(pw2.length<=5){
			$(".password-state-inner").eq(1).html("密码长度过低(6-20位字符)");
			$(".password-state-inner").eq(1).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(1).css("margin-top","0px");
			$(".password-state-inner").eq(1).html("");
		}
	});
	$("#z_pW").blur(function(){
		var pw2 = $("#x_pW").val();
		var pw3 = $(this).val();
		if(pw3.length<=0){
			$(".password-state-inner").eq(2).html("请再次输入新密码");
			$(".password-state-inner").eq(2).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(2).css("margin-top","0px");
			$(".password-state-inner").eq(2).html("");
		}
		if(pw3!=pw2){
			$(".password-state-inner").eq(2).html("两次输入的密码不一致");
			$(".password-state-inner").eq(2).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(2).css("margin-top","0px");
			$(".password-state-inner").eq(2).html("");
		}
	});
	$(".submit_box").click(function(){
		var pw1 = $("#y_pW").val();
		var pw2 = $("#x_pW").val();
		var pw3 = $("#z_pW").val();	
		if(pw1.length<=0){
			$(".password-state-inner").eq(0).html("原密码不能为空");
			$(".password-state-inner").eq(0).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(0).css("margin-top","0px");
			$(".password-state-inner").eq(0).html("");
		}
		if(pw2.length<=0){
			$(".password-state-inner").eq(1).html("新密码不能为空");
			$(".password-state-inner").eq(1).css("margin-top","-10px");
			return false;
		}else if(pw2.length<=5){
			$(".password-state-inner").eq(1).html("密码长度过低(6-20位字符)");
			$(".password-state-inner").eq(1).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(1).css("margin-top","0px");
			$(".password-state-inner").eq(1).html("");
		}
		if(pw3.length<=0){
			$(".password-state-inner").eq(2).html("请再次输入新密码");
			$(".password-state-inner").eq(2).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(2).css("margin-top","0px");
			$(".password-state-inner").eq(2).html("");
		}
		if(pw3!=pw2){
			$(".password-state-inner").eq(2).html("两次输入的密码不一致");
			$(".password-state-inner").eq(2).css("margin-top","-10px");
			return false;
		}else{
			$(".password-state-inner").eq(2).css("margin-top","0px");
			$(".password-state-inner").eq(2).html("");
		}
	});
});

</script>    
</body>
</html>


