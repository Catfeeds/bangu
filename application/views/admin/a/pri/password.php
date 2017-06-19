<style type="text/css">
	.eject_list_name{ width: 20%; text-align: right;margin-right: 15px;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">个人中心</li>
		</ul>
	</div>
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="well with-header with-footer" style="position:relative">
				<form method = "post" action="#" id="adminUser">
					<div class="web_body" >
						<div class="eject_content">
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">原密码:</div>
									<div class="content_info"><input type="password" name="oldpass" ></div>
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">新密码:</div>
									<div class="content_info"><input type="password" name="password"></div>
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">确认密码:</div>
									<div class="content_info"><input type="password" name="repass"></div>
								</div>
							</div>
						</div>					
					</div>
					<div class="table-toolbar">
						<input type="submit" class="btn btn-default" value="更新">
					</div>
				</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script type="text/javascript">
$("#adminUser").submit(function(){
	$.ajax({
		url:'/admin/a/pri/adminUser/updatePassword',
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
});
</script>