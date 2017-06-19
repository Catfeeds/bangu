<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.col_lb{ float: left; width: 16%; text-align: right;}
	.col_ts{ float: left;}
	.col-sm-10{ width: 83%;}
	.table-toolbar{ margin-left: 5px;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">权限管理</li>
		</ul>
	</div>
	<!-- Page Body -->
	
				<!-- <div class="well with-header with-footer"> -->
						<div class="table-toolbar">
							<a id="add_expert" href="javascript:void(0);" class="btn btn-default" onclick="add()"> 添加 </a>
						</div>
                       	<div class="tab-content">
	                       	<label>
								<form class="form-inline" id="search_form" action="#" method="post">
									<div class="form-group dataTables_filter" style="display:inline-block;float:left;margin-right:10px;">
										<label class="sr-only"> 顶级 </label> 
										<select name="pid">
											<option value="0">请选择</option>
											<?php 
												foreach($top_pri as $key =>$val) {
													echo "<option value='{$val['resourceId']}'>{$val['name']}</option>";
												}
											?>
										</select>
									</div>
									<input type="hidden" name="is" value="1">
									<input type="hidden" name="page_new">
									<button type="submit" class="btn btn-default">搜索</button>
								</form>
							</label>
							<div class="tab-pane active">
								<table class="table table-hover">
								    <thead class="bordered-darkorange">
								        <tr>
								            <th>菜单标题</th>
								            <th>唯一标识</th>
								            <th>访问地址</th>
								            <th>描述</th>
								            <th>排序</th>
								            <th>操作</th>  
								        </tr>
								    </thead>
								    <tbody class="body_data">
								    		<?php foreach($list as $val): ?>
								        		<tr>
										            <td ><?php
										            	if ($val ['pid'] != 0) {
											            	$codelen = strlen($val['code']);
											            	$a = 2;
											            	for ($a ;$a < $codelen ;$a ++) {
											            		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											            	}
										            	}
										            	echo $val ['name'];
										            ?></td>
										            <td><?php echo $val ['code']?></td>
										            <td><?php echo $val ['uri']?></td>
										            <td><?php echo $val ['description']?></td>
										            <td><?php echo $val ['showorder']?></td>
										            <td>
										            	<a href='#' onclick="edit(<?php echo $val ['resourceId']?>)" class="btn btn-info btn-xs edit"> 编辑</a>
										           		<a href='#' onclick="del(<?php echo $val ['resourceId']?>)" class="btn btn-danger btn-xs delete"> 删除</a>
										            </td>
									        	</tr>
									        <?php endforeach;?>
								    </tbody>
								</table>
								<div class="pagination"><?php echo $page_string?></div>
							</div>
						</div>
						<!-- </div> -->
					</div>
				</div>
			
	<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog" style="margin:30px auto; width:600px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">添加角色权限</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="pri_form" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">菜单标题</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="name" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3"  class="col-sm-2 control-label no-padding-right col_lb">选择角色</label>
						<div id="role_user" style="clear:both;float:left;margin:-30px 0px 0px 100px;"></div>
					</div>
					<div class="form-group">
						<label for="inputEmail3"  class="col-sm-2 control-label no-padding-right col_lb">选择上级标题</label>
						<div class="col-sm-10 col_ts" >
							<select name="parent_pri" id="parent_pri">
								<option value="0">请选择</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">访问地址</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" name="uri" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" name="showorder" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">描述 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="description" rows="6" cols="57"></textarea>
						</div>
					</div>
					<input type="hidden" value="" name="resourceId">
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
	$('.ajax_page').click(function() {
		if ($(this).hasClass('active')) { //点击当前页，不执行下面的
			return false;
		}
		var page_new = $(this).find('a').attr('page_new');
		get_ajax_page(page_new);
	})
	//条件搜索
	$('#search_form').submit(function() {
		get_ajax_page(1);
		return false;
	})
	
	/**
	* @method ajax分页
	* @param {intval} page_new 第几页
	*/
	function get_ajax_page(page_new) {
		//主要作用是可以用表单一次提交所有数据
		$('input[name="page_new"]').val(page_new);
		$.post(
			"<?php echo site_url('admin/a/pri_manage/pri_list')?>",
			$('#search_form').serialize(),
			function(data) {
				var data = eval('('+data+')');
				$('.body_data').html('');
				$.each(data.list ,function(kay ,val) {
					if (val.pid != 0) {
						var code_len = val.code.length;
						var a = 2;
						var space = '';
						for (a ; a < code_len ;a++) {
							space = space + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						}
					} else {
						var space = '';
					}
					var string = "<tr>";
						string += "<td>"+space+val.name+"</td>";
						string += "<td>"+val.code+"</td>";
						string += "<td>"+val.uri+"</td>";
						string += "<td>"+val.description+"</td>";
						string += "<td>"+val.showorder+"</td>";
						string += "<td><a href='#' onclick='edit("+val.resourceId+")' class='btn btn-info btn-xs edit'><i class='fa fa-edit'></i>编辑</a>";
						string += '<a href="#" onclick="del('+val.resourceId+')" class="btn btn-danger btn-xs delete"> 删除</a></td>';
						string += '</tr>';
						$('.body_data').append(string);
				})
				
				$('.pagination').html(data.page_string);
				$('.ajax_page').click(function() {
					if ($(this).hasClass('active')) { //点击当前页，不执行下面的
						return false;
					}
					var page_new = $(this).find('a').attr('page_new');
					get_ajax_page(page_new);
				})
			}
		);
	}
	
		$('.bootbox-close-button').click(function(){
			$('.modal-backdrop').css('display','none');
			$('.bootbox').css('display','none');
		})
		
		function edit(id) {
			common(id);
			$('.form_submit').html('');
			var string = '<input class="btn btn-palegreen bootbox-close-button " onclick="close();" value="关闭" style="float: right; margin-right: 2%; " type="button">'
				string += '<input id="sub" onclick="edit_pri()"  class="btn btn-palegreen" value="提交" style="float: right; margin-right: 2%;" type="button">';
			$('.form_submit').html(string);
			$('.modal-backdrop').show();
			$('.bootbox').show();
			$('.modal-title').html('编辑角色权限');
			$('.bootbox-close-button').click(function(){
				$('.modal-backdrop').css('display','none');
				$('.bootbox').css('display','none');
			})
		}
		function del(id) {
			common(id);
			$('.form_submit').html('');
			var string = '<input class="btn btn-palegreen bootbox-close-button " onclick="close();" value="关闭" style="float: right; margin-right: 2%; " type="button">'
				string += '<input id="sub" onclick="delete_pri('+id+')"  class="btn btn-palegreen" value="删除" style="float: right; margin-right: 2%;" type="button">';
			$('.form_submit').html(string);
			$('.modal-backdrop').show();
			$('.bootbox').show();
			$('.modal-title').html('删除角色权限');
			$('.bootbox-close-button').click(function(){
				$('.modal-backdrop').css('display','none');
				$('.bootbox').css('display','none');
			})
		}
		function delete_pri(id) {
			$.post(
				"<?php echo site_url('admin/a/pri_manage/delete')?>",
				{'id':id},
				function (data) {
					data = eval('('+data+')');
					if (data.status == 1) {
						alert(data.msg);
						location.reload();
					} else {
						alert(data.msg);
					}
				}
			);
		}
		function common(id) {
			$.post(
					"<?php echo site_url('admin/a/pri_manage/get_one_data')?>",
					{'id':id},
					function(data) {
						data = eval('('+data+')');
						var pri = data[0];
						$('input[name="name"]').val(pri.name);
						$('input[name="uri"]').val(pri.uri);
						$('textarea[name="description"]').val(pri.description);
						$('input[name="resourceId"]').val(pri.resourceId);
						$('input[name="showorder"]').val(pri.showorder);
						var role = data.role;
						$('.role_check').remove();
						$.each(role ,function (key ,val) {
							var sel = '';
							$.each(data.role_id ,function (k ,v) {
								if (val.roleId == v.roleId) {
									sel = "checked = 'checked'";
								}
							})
							var str = '<div class="col-lg-4 col-sm-4 col-xs-4 role_check" style="width:150px;margin-left:20px;" >';
								str += '<div class="checkbox"> '; 
								str += '<label style="padding-left:0px;"><input style="left:0px;opacity:1;" '+sel+' type="checkbox" value="'+val.roleId+'" name="role[]">'+val.roleName+'</label>';
								str += '</div></div>';	
							$('#role_user').append(str);						
						});

						$('#parent_pri').html('');
						$('#parent_pri').html('<option value="0">请选择</option>');
						$.each(data.pri ,function (key ,val) {
							var b = '';
							if (val.pid != 0) {
								var codelen = val.code.length;
								var a = 2;
								
								for (a ;a <codelen ;a++) {
									 b += '&nbsp;&nbsp;&nbsp;'
								}
							}
							if (pri.pid == val.resourceId) {
								selected = "selected = 'selected'";
							} else {
								selected = '';
							}
							
							$('#parent_pri').append("<option value='"+val.resourceId+"' "+selected+">"+b+val.name+"</option>");
						})
						$('.checkbox label ').css('padding-left','0');
					}
				)
		}
		function add (id) {
			$('input[name="name"]').val('');
			$('input[name="uri"]').val('');
			$('textarea[name="description"]').val('');
			$('input[name="resourceId"]').val('');
			$('.modal-title').html('添加角色权限');
			$('select[name="parent_pri"]').val(0);
			$.post(
				"<?php echo site_url('admin/a/pri_manage/get_role_json')?>",
				{},
				function (data) {
					data = eval('('+data+')');
					$('.role_check').remove();
					$.each(data.role ,function (key ,val) {
						
						var str = '<div class="col-lg-4 col-sm-4 col-xs-4 role_check" style="width:150px;" >';
							str += '<div class="checkbox"> '; 
							str += '<label style="padding-left:0px;"><input class="colored-success" type="checkbox" value="'+val.roleId+'" name="role[]"><span class="text">'+val.roleName+'</span></label>';
							str += '</div></div>';	
						$('#role_user').append(str);						
					});
					$('#parent_pri').html('');
					$('#parent_pri').html('<option value="0">请选择</option>');
					$.each(data.pri ,function (k ,v) {
						var codelen = v.code.length;
						var a = 2;
						var b = '';
						for (a ;a <codelen ;a++) {
							 b += '&nbsp;&nbsp;&nbsp;'
						}
						$('#parent_pri').append("<option value='"+v.resourceId+"'>"+b+v.name+"</option>");
					})
				}
			);
			$('.form_submit').html('');
			var string = '<input class="btn btn-palegreen bootbox-close-button " onclick="close()" value="关闭" style="float: right; margin-right: 2%; " type="button">'
			string += '<input id="submit" onclick="add_pri()" class="btn btn-palegreen" value="提交" style="float: right; margin-right: 2%;" type="button">';
			
			$('.form_submit').html(string);
			$('.modal-backdrop').show();
			$('.bootbox').show();
			
			$('.bootbox-close-button').click(function(){
				$('.modal-backdrop').css('display','none');
				$('.bootbox').css('display','none');
			})
		}
	//	$('#sub').click(function(){
		function edit_pri(){
			$.post(
				"<?php echo site_url('admin/a/pri_manage/edit_pri')?>",
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
		function add_pri(){
			
			$.post(
					"<?php echo site_url('admin/a/pri_manage/add_pri')?>",
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
	</script>
</div>
