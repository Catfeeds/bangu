<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.col_lb{ float: left; width: 16%; text-align: right;}
	.col_ts{ float: left;}
	.col-sm-10{ width: 83%;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">角色管理</li>
		</ul>
	</div>
	<!-- Page Body -->
				<!-- <div class="well with-header with-footer"> -->
						<div class="table-toolbar">
							<a id="add_expert" href="javascript:void(0);" class="btn btn-default" onclick="add()"> 添加 </a>
						</div>
                       	<div class="tab-content">
							<div class="tab-pane active">
								<table class="table table-hover">
								    <thead class="bordered-darkorange">
								        <tr>
								            <th>编号</th>
								            <th>角色名</th>
								            <th>描述</th>
								            <th>操作</th>  
								        </tr>
								    </thead>
								    <tbody>
								    		<?php foreach($list as $val): ?>
								        		<tr>
										            <td><?php echo $val ['roleId']?></td>
										            <td><?php echo $val ['roleName']?></td>
										            <td><?php echo $val ['description']?></td>
										            <td>
										            	<a href='#' onclick="edit(<?php echo $val ['roleId']?>)" class="btn btn-info btn-xs edit"> 编辑</a>
										           		<a href='#' onclick="del(<?php echo $val ['roleId']?>)" class="btn btn-danger btn-xs delete"> 删除</a>
										            </td>
									        	</tr>
									        <?php endforeach;?>
								    </tbody>
								</table>
								<div class="pagination"></div>
							</div>
						</div>
						<!-- </div> -->
					</div>
				</div>
	<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog" style="margin:30px auto;width:600px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">添加角色</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="pri_form" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">角色名称</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="roleName" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3"  class="col-sm-2 control-label no-padding-right col_lb">选择管理员</label>
						<div id="admin_user" style="clear:both;float:left;margin:-30px 0px 0px 100px;"></div>
					</div>
				
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">描述 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="description" rows="6" cols="57"></textarea>
						</div>
					</div>
					<input type="hidden" value="" name="roleId">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input id="sub" class="btn btn-palegreen submit" value="提交" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade in" style="display:none;"></div>
	<!-- /Page Body -->
	<script>
		$('.bootbox-close-button').click(function(){
			$('.modal-backdrop').css('display','none');
			$('.bootbox').css('display','none');
			$('input[name="roleName"]').val('');
			$('textarea[name="description"]').val('');
		})
		function edit(id) {
			$.post(
				"<?php echo site_url('admin/a/pri_role/get_one_json')?>",
				{'id':id},
				function(data) {
					data = eval('('+data+')');
					var role = data.role;
					
					$('input[name="roleName"]').val(role.roleName);
					$('textarea[name="description"]').val(role.description);
					$('input[name="roleId"]').val(role.roleId);
					$('.admin_check').remove();
					$.each(data.admin ,function (key ,val) {
						var sel = '';
						$.each(data.admin_id ,function (k ,v) {
							if (val.id == v.adminId) {
								sel = "checked = 'checked'";
							}
						})
						var str = '<div class="col-lg-4 col-sm-4 col-xs-4 admin_check" style="width:150px;" >';
							str += '<div class="checkbox"> '; 
							str += '<label><input '+sel+' style="left:20px;opacity:1;" type="checkbox" value="'+val.id+'" name="user[]">'+val.username+'</label>';
							str += '</div></div>';	
						$('#admin_user').append(str);						
					});
					$('.form_submit').html('');
					var string = '<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">'
					string += '<input id="submit" onclick="edit_role()" class="btn btn-palegreen" value="提交" style="float: right; margin-right: 2%;" type="button">';
					
					$('.form_submit').html(string);
					
					$('.modal-backdrop').show();
					$('.bootbox').show();
					$('.bootbox-close-button').click(function(){
						$('.modal-backdrop').css('display','none');
						$('.bootbox').css('display','none');
						$('input[name="roleName"]').val('');
						$('textarea[name="description"]').val('');
					})
				}
			)
		}
		function add (id) {
			$('input[name="roleName"]').val('');
			$('textarea[name="description"]').val('');
			$('select[name="parent_pri"]').val(0);
			$.post(
				"<?php echo site_url('admin/a/pri_role/get_admin_json')?>",
				{},
				function (data) {
					data = eval('('+data+')');
					$('.admin_check').remove();
					$.each(data ,function (key ,val) {
						
						var str = '<div class="col-lg-4 col-sm-4 col-xs-4 admin_check" style="width:150px;" >';
							str += '<div class="checkbox"> '; 
							str += '<label><input class="colored-success" type="checkbox" value="'+val.id+'" name="user[]"><span class="text">'+val.username+'</span></label>';
							str += '</div></div>';	
						$('#admin_user').append(str);						
					});
					
				}
			);
			$('.form_submit').html('');
			var string = '<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">'
			string += '<input id="submit" onclick="add_role()" class="btn btn-palegreen" value="提交" style="float: right; margin-right: 2%;" type="button">';
			
			$('.form_submit').html(string);
			$('.modal-backdrop').show();
			$('.bootbox').show();
			$('.bootbox-close-button').click(function(){
				$('.modal-backdrop').css('display','none');
				$('.bootbox').css('display','none');
				$('input[name="roleName"]').val('');
				$('textarea[name="description"]').val('');
			})
			
		}
		function edit_role() {
			$.post(
				"<?php echo site_url('admin/a/pri_role/edit_role')?>",
				$('#pri_form').serialize(),
				function(data) {
					data = eval('('+data+')');
					if (data.status == 1) {
						alert(data.msg);
						window.location.reload();
					} else {
						alert(data.msg);
					}
				}
			);
		}
		function add_role(){
			$.post(
					"<?php echo site_url('admin/a/pri_role/add_role')?>",
					$('#pri_form').serialize(),
					function(data) {
						data = eval('('+data+')');
						if (data.status == 1) {
							alert(data.msg);
							window.location.reload();
						} else {
							alert(data.msg);
						}
					}
				);
		}
		function del(id) {
			$.post(
					"<?php echo site_url('admin/a/pri_role/get_one_json')?>",
					{'id':id},
					function(data) {
						data = eval('('+data+')');
						var role = data.role;
						
						$('input[name="roleName"]').val(role.roleName);
						$('textarea[name="description"]').val(role.description);
						$('input[name="roleId"]').val(role.roleId);
						$('.admin_check').remove();
						$.each(data.admin ,function (key ,val) {
							var sel = '';
							$.each(data.admin_id ,function (k ,v) {
								if (val.id == v.adminId) {
									sel = "checked = 'checked'";
								}
							})
							var str = '<div class="col-lg-4 col-sm-4 col-xs-4 admin_check" style="width:150px;" >';
								str += '<div class="checkbox"> '; 
								str += '<label><input '+sel+' style="left:20px;opacity:1;" type="checkbox" value="'+val.id+'" name="user[]">'+val.username+'</label>';
								str += '</div></div>';	
							$('#admin_user').append(str);						
						});
						$('.form_submit').html('');
						var string = '<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">'
						string += '<input onclick="del_role()" class="btn btn-palegreen" value="确认删除" style="float: right; margin-right: 2%;" type="button">';
						
						$('.form_submit').html(string);
						
						$('.modal-backdrop').show();
						$('.bootbox').show();
						$('.bootbox-close-button').click(function(){
							$('.modal-backdrop').css('display','none');
							$('.bootbox').css('display','none');
							$('input[name="roleName"]').val('');
							$('textarea[name="description"]').val('');
						})
					}
				)
		}
		function del_role() {
			roleId = $('input[name="roleId"]').val();
			$.post(
				"<?php echo site_url('admin/a/pri_role/delete')?>",
				{'id':roleId},
				function (data) {
					data = eval('('+data+')');
					if (data.status == 1) {
						alert(data.msg);
						window.location.reload();
					} else {
						alert(data.msg);
					}
				}
			);
		}
	</script>
</div>
