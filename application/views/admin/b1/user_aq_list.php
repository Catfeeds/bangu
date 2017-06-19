<style type="text/css">
.form-control {
	background-color: #fff;
	background-image: none;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	color: #555;
	display: block;
	font-size: 14px;
	height: 34px;
	line-height: 1.42857;
	padding: 6px 12px;
	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s
		ease-in-out 0s;
	width: 20%;
}

.col-sm-2 {
	width: 5.5%;
	height: 32px;
}
.col_ts{ float: left;}
.form_group .form_input { height:auto;}
body,.widget-body { background:#fff;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">安全中心</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div id="registration-form" style="margin-bottom:100px;">
                         
            <?php echo form_open('index.php/admin/b1/user_aq/insert');?>
			<table class="line_base_info table_form_content table_td_border" border="1" width="800">
                <tbody>
                    <tr height="50" class="form_group">
                        <td class="form_title">登录账号：</td>
                        <td>&nbsp;&nbsp;<?php if(!empty($user[0]['login_name'])){ echo $user[0]['login_name'] ; }?></td>
                    </tr>
                    <tr height="50" class="form_group">
                        <td class="form_title">原始密码：</td>
                        <td>
                        	<input type="password" placeholder="原始密码" id="y_pW" class="form_input w_500" name="pwd"/> 
                            <span class="info" style="color:red !important;"><?php echo form_error('pwd' , '<div class="error2" style="color:red">' , '</div>');?></span>
                        </td>
                    </tr>
                    <tr height="50" class="form_group">
                        <td class="form_title">新密码：</td>
                        <td>
                        	<input type="password" placeholder="新密码" id="x_pW" class="form_input w_500" name="pwd1" /><span class="info" style="color:red !important;"><?php echo form_error('pwd1' , '<div class="error2" style="color:red">' , '</div>');?></span>
                        </td>
                    </tr>
                    <tr height="50" class="form_group">
                        <td class="form_title">再次输入密码：</td>
                        <td>
                        	<input type="password" placeholder="再次输入密码" id="z_pW" class="form_input w_500" name="pwd2" /><span class="info" style="color:red !important;"><?php echo form_error('pwd2' , '<div class="error2" style="color:red">' , '</div>');?></span>
                        </td>
                    </tr>
                </tbody>
            </table>

			<?php if (!empty($status) && $status==1){ ?>
				<div class="alert alert-danger fade in" style="width:425px;background:#a0d468; border-color:#a0d468">
					<button data-dismiss="alert" class="close">×</button>
					<?php echo $result_msg;?>
				</div>
			<?php }elseif(!empty($status) && $status==2){?>
				<div class="alert alert-danger fade in" style="width:425px;">
					<button data-dismiss="alert" class="close">×</button>
					<i class="fa-fw fa fa-times"></i> <strong>错误!</strong> <?php echo $result_msg;?>
				</div>
			<?php }?>
			<div class="form_btn clear">
                <button class="btn btn-palegreen" type="submit" style="margin-left:360px;">确认</button>
            </div>
			
			</form>
		</div>

	</div>
</div>
<script type="text/javascript">
$(function(){
	$("#y_pW").blur(function(){
		var pw1 = $(this).val();
		if(pw1.length<=0){
			$(".info").eq(0).html("原密码不能为空");
			return false;
		}else{
			$(".info").eq(0).html("");
		}
	});
	$("#x_pW").blur(function(){
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
	$("#z_pW").blur(function(){
		var pw2 = $("#x_pW").val();
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
	$(".btn-palegreen").click(function(){
		var pw1 = $("#y_pW").val();
		var pw2 = $("#x_pW").val();
		var pw3 = $("#z_pW").val();	
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