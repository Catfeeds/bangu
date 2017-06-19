<style type="text/css">
	.col_ts{ float: left; width: 16%; text-align: right;padding-top: 7px;}
	.col-sm-2 input{ display: inline; width: 250px; margin-left: 15px;}
	.col_pd{ padding-left: 0px;}
    .horizontalBox{ width: 400px; height: 400px; position:fixed; top:150px;left: 50%; margin-left: -180px;}
    .btn { background: #09c; color: #fff;}
    .btn:hover { background: #09c; color: #fff; opacity: 0.9;}
    .info{ height:30px; line-height: 30px; padding-left: 15px;}
    .form-group label{ padding-left: 0;}
	.form-group{ float:left}
	.ie8_input{ width:100px\9;}
	.ie8_select{ padding:5px 5px 6px 5px\9;}
	.ie8_pageBox{ width:50%\9; float:left\9}
	input{ line-height:100%\9;}
	.form-control{ line-height: 24px !important;}
	.form-group{ width:100%;}
	.form-group label{ width:20%; float:left}
	.form-group div{ width:80%; float:left}
	.form-group label { border:none !important;}
</style>
<!-- Page Breadcrumb -->

<!-- /Page Breadcrumb -->
<!-- Page Header -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"> </i><a href="<?php echo site_url('admin/b2/home/index')?>">主页</a></li>
		<li class="active">安全中心</li>
	</ul>
</div>
<!-- /Page Header -->
<!-- Page Body -->
<div class="page-body" id="bodyMsg">
	<div class="horizontalBox shadow">
		<form class="form-horizontal" role="form"
			action="<?php echo site_url('admin/b2/expert/security')?>" method="post">
			<div class="form-group">
				<label for="inputCash"
					class="col-sm-2 control-label no-padding-right col_ts">登录账号</label>
				<div class="col-sm-2 " style="line-height:33px; float:left; width:240px;">
	               <?php if(!empty($user[0]['login_name'])){ echo $user[0]['login_name'];} ?>
				</div>
			</div>
			<div class="form-group">
				<label for="inputMoney"
					class="col-sm-2 control-label no-padding-right col_ts">原密码</label>
				<div class="col-sm-2 col_pd" style="width: 240px;;">
					<input type="password" class="form-control" id="inputMoney" name="old_pwd" style="display:inline; ">
					<span class="info" style="color:red !important;"><?php echo form_error('old_pwd' , '<div class="error2" style="color:red">' , '</div>');?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputCard"
					class="col-sm-2 control-label no-padding-right col_ts">新密码</label>
				<div class="col-sm-2 col_pd" style="width: 240px;">
					<input type="password" class="form-control" id="inputCard" name="new_pwd" >
					<span class="info" style="color:red !important;"><?php echo form_error('new_pwd' , '<div class="error2" style="color:red">' , '</div>');?></span>
				</div>
			</div>
			<div class="form-group ">
				<label for="inputName"
					class="col-sm-2 control-label no-padding-right col_ts">确认密码</label>
				<div class="col-sm-2 col_pd" style="width: 240px;">
					<input type="password" class="form-control" id="inputName" name="new_pwd2">
					<span class="info" style="color:red !important;"><?php echo form_error('new_pwd2' , '<div class="error2" style="color:red">' , '</div>');?></span>
				</div>
			</div>
	
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10" style="margin-left:125px;">
					<button type="submit" class="btn btn-default ">确认修改</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$(function(){
	$("#inputMoney").blur(function(){
		var pw1 = $(this).val();
		if(pw1.length<=0){
			$(".info").eq(0).html("原密码不能为空");
			return false;
		}else{
			$(".info").eq(0).html("");
		}
	});
	$("#inputCard").blur(function(){
		var pw2 = $(this).val();
		if(pw2.length<=0){
			$(".info").eq(1).html("新密码不能为空");
			return false;
		}else if(pw2.length<=5){
			$(".info").eq(1).html("密码长度过低(6-20位字符)");
			return false;
		}else{
			$(".info").eq(1).html("");
		}
	});
	$("#inputName").blur(function(){
		var pw2 = $("#inputCard").val();
		var pw3 = $(this).val();
		if(pw3.length<=0){
			$(".info").eq(2).html("请再次输入新密码");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
		if(pw3!=pw2){
			$(".info").eq(2).html("两次输入的密码不一致");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
	});
	$(".btn-default").click(function(){
		var pw1 = $("#inputMoney").val();
		var pw2 = $("#inputCard").val();
		var pw3 = $("#inputName").val();
		if(pw1.length<=0){
			$(".info").eq(0).html("原密码不能为空");
			return false;
		}else{
			$(".info").eq(0).html("");
		}
		if(pw2.length<=0){
			$(".info").eq(1).html("新密码不能为空");
			return false;
		}else if(pw2.length<=5){
			$(".info").eq(1).html("密码长度过低(6-20位字符)");
			return false;
		}else{
			$(".info").eq(1).html("");
		}
		if(pw3.length<=0){
			$(".info").eq(2).html("请再次输入新密码");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
		if(pw3!=pw2){
			$(".info").eq(2).html("两次输入的密码不一致");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
	});
});

</script>