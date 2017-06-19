<!DOCTYPE html>
<html lang="en">
<!-- Head -->
<head>
	<title>平台管理员登录</title>
	<link rel="icon" href="/bangu.ico" type="image/x-icon"/> 
	<?php $this->load->view('admin/a/common/head');?>
	<style>
		.login-container{
			max-width:340px;
		}
	</style>
</head>
<!-- /Head -->
<!-- Body -->
<body>
<div class="login-container animated fadeInDown">
<div class="widget">
	<div class="widget-header bordered-bottom bordered-palegreen">
		<span class="widget-caption">平台管理员登录</span>
	</div>
	<div class="widget-body">
		<div>
			<form class="form-horizontal form-bordered" role="form" method="post" id="loginForm" action="<?php echo site_url('admin/a/login/do_login')?>">
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">用户名</label>
					<div class="col-sm-10">
						<input class="form-control"  placeholder="用户名" name="username" value="<?php echo set_value('username') ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label no-padding-right">密码</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="inputPassword3" placeholder="密码" name="password" value="<?php echo set_value('password') ?>">
					</div>
				</div>
				<div class="form-group">
					<label  class="col-sm-2 control-label no-padding-right">验证码</label>
					<div class="col-sm-6">
						<input type="text" class="form-control"  placeholder="点击图片刷新" name="ucap" value="<?php echo set_value('ucap') ?>">
					</div>
					<div class="col-sm-4">
						<img style="-webkit-user-select: none" src="<?php echo base_url(); ?>tools" onclick="this.src='<?php echo base_url();?>tools?'+Math.random()">
					</div>
				</div>								
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6">
						<button type="submit" class="btn btn-palegreen shiny" value="登    录">登    录</button>						
					</div>				
				</div>
				
				<div class="alert alert-danger fade in error-msg" style='display:none;'>
					<i class="fa-fw fa fa-times"></i> <strong >错误!</strong><span id="error-show"></span>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<script>
$("#loginForm").submit(function(){
	$.ajax({
		url:"/admin/a/login/doLogin",
		type:"post",
		dataType:"json",
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				location.href = "/admin/a/home";
			} else {
				$(".error-msg").show();
				$("#error-show").text(data.msg);
			}
		}
	});
	return false;
});
	
</script>
</body>
<!--  /Body -->
</html>