<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.pagination{margin-top: 3px;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="#"> 首页 </a></li>
			<li class="active">数据字典</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<!-- <div class="well with-header with-footer">
					<div class="header bordered-pink">数据字典</div> -->
					<div class="widget-body">
                    	<div class="table-toolbar">
							<a id="add_form_dict" href="javascript:void(0);"
								class="btn btn-default"> 添加 </a>

						</div>
						<label style="margin-bottom:10px;">
							<form class="form-inline clear" action="#" method="post">
								<div class="form-group dataTables_filter fl" style="margin-right:20px;">
									<label class="sr-only"> 名称 </label> 
									<input type="text" class="form-control" name='name' placeholder="名称">
								</div>
								<div class="checkbox fl" style="margin-right:20px;margin-top:2px;">
									<label> 
									<select name="parent_id" class="form-control input-sm">
											<option value="0" >请选择</option>
											<?php 
												foreach($parent_list as $val){
													echo "<option value='{$val ['dict_id']}'>{$val ['description']}</option>";
												}
											?>
									</select>
									</label>
								</div>
								<button type="button" id="search_dict" class="btn btn-darkorange fl">搜索</button>
							</form>
						</label>

						
						<div role="grid" id="editabledatatable_wrapper"
							class="dataTables_wrapper form-inline no-footer">
							<table
								class="table table-striped table-hover table-bordered dataTable no-footer"
								id="editabledatatable" aria-describedby="editabledatatable_info">
								<thead>
									<tr role="row">
										<th>ID编号</th>
										<th>名称</th>
										<th>唯一标识</th>
										<th>上级名称</th>
										<th>排序</th>
										<th>操作</th>
									</tr>
								</thead>

								<tbody class="dict_list">
									<?php foreach($list as $v): ?>
									<tr class="odd">
										<td><?php echo $v['dict_id'] ?></td>
										<td><?php echo $v['description'] ?></td>
										<td><?php echo $v['dict_code']; ?></td>
										<td><?php echo $v['parent_name'] ?></td>
										<td><?php echo $v['showorder']?></td>
										<td>
											<a href="#" onclick="see_dict(<?php echo $v['dict_id']?>,1)"  class="btn btn-info btn-xs edit">编辑</a>
											<a href="#" onclick="see_dict(<?php echo $v['dict_id']?>,2)" class="btn btn-danger btn-xs delete">删除</a>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>

						</div>
					</div>
					<div class="pagination"><?php echo $page_str?></div>
				</div>
			</div>
		<!-- </div> -->
	</div>
	<!-- /Page Body -->
</div>

<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>

<div aria-hidden="false" style="display: none;" class="bootbox  modal fade in" tabindex="-1" role="dialog">
		<div class="modal-dialog" style="position:absolute;left:50%;margin-left:-300px;">
			<div class="modal-content" style="width:600px;">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button bc_close close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">数据库字典</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body"><div>
					<form class="form-horizontal" role="form" id="add_dict_form" method="post" action="#">
						<div class="form-group clear">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">名字</label>
							<div class="col-sm-8 fl">
								<input class="form-control" name="description" type="text" style="width:420px;">
							</div>
						</div>
						
						<div class="form-group clear">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">唯一标识</label>
							<div class="col-sm-8 fl">
								<input class="form-control" name="dict_code" type="text" placeholder="例 DICT_TRANSPORT" style="width:420px;">
							</div>
						</div>
						<div class="form-group clear">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">排序</label>
							<div class="col-sm-8 fl">
								<input class="form-control" name="showorder" type="text" style="width:420px;">
							</div>
						</div>
						<div class="form-group clear">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">上级</label>
							<div class="col-sm-8 fl">
								<select name="pid" >
									<option value="0">请选择</option>
									<?php 
										foreach($parent_list as $val){
											echo "<option value='{$val ['dict_id']}'>{$val ['description']}</option>";
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group clear">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">图片</label>
							<div class="col-sm-8 fl">
								<input id="dict_pic" name="dict_pic" type="file">
								<input value="上传" id="upfile_pic" type="button">
								<input name='pic' type='hidden'>
							</div>
						</div>
						
						<div class="form-group">
							<input type="hidden" value="" name="dict_id">
							<input type="hidden" value="" name="is">
							<input class="btn btn-palegreen bootbox-close-button " aria-hidden="true" value="取消" style="float: right; margin-right: 2%; " type="button">
							<input class="btn btn-palegreen" id="submit" value="提交" style="float: right; margin-right: 2%;" type="button">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
<div class="modal-backdrop fade in bc_close" style="display:none"></div>
<script>
	$('input[name="name"]').val('');
	$('select[name="parent_id"]').val(0);								
	$('.ajax_page').click(function(){
		var page_new = $(this).find('a').attr('page_new');
		get_ajax_data(page_new);
	})
	$('#search_dict').click(function(){
		get_ajax_data(1);
	})
	/**
	*	@method ajax分页
	*	@author 贾开荣
	*	@param  {intval} page_naw 当前分页
	*/
	function get_ajax_data(page_new) {
		var name = $('input[name="name"]').val();
		var pid = $('select[name="parent_id"] :selected').val();
		$.post(
			'<?php echo site_url('admin/a/dictionary/index')?>',
			{'is':1,'page':page_new,'name':name,'pid':pid},
			function(data) {
				data = eval('('+data+')');
				$('.dict_list').html('');
				$.each(data.list ,function(key ,val) {
					if (typeof val.dict_code == "object") {
						dict_code = '';
					} else {
						dict_code = val.dict_code;
					}
					if (typeof val.parent_name == "object") {
						parent_name = '';
					} else {
						parent_name = val.parent_name;
					}
					str = "<tr>";
					str += '<td>'+val.dict_id+'</td><td>'+val.description+'</td><td>'+dict_code+'</td>';
					str += '<td>'+parent_name+'</td><td>'+val.showorder+'</td>';
					str += '<td><a href="#" onclick="see_dict('+val.dict_id+',1)" class="btn btn-info btn-xs edit"> 编辑</a>';
					str += '<a href="#" onclick="see_dict('+val.dict_id+',2)" class="btn btn-danger btn-xs delete">删除</a></td>';
					str += '</tr>';
					$('.dict_list').append(str);
				})
				$('.pagination').html(data.page_str);

				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_ajax_data(page_new);
				})
			}
		);
	}
	$('#add_form_dict').click(function(){
		//$(":input,#add_dict_form").not(":button, :submit, :reset, :hidden").val("").removeAttr("checked").removeAttr("selected");//核心
		$('input[name="description"]').val('');
		$('input[name="showorder"]').val('');
		$('input[name="pic"]').val('');
		$('input[name="dict_pic"]').val('');
		$('input[name="dict_code"]').val('');
		$('select[name="pid"]').find('option[value="0"]').attr('selected' ,true);
		$('input[name="dict_id"]').val('');
		$('input[name="is"]').val(1);
		$('.upload_pic').remove();
		$('#submit').val('确认添加');
		$('.bootbox').show();
		$('.modal-backdrop').show();
	})
	$('.bootbox-close-button').click(function(){
		$('.bootbox').hide();
		$('.modal-backdrop').hide();
	})
	//文件上传
	$('#upfile_pic').on('click', function() {
		ajax_upload_file('dict_pic' ,'pic' ,'dictionary');
    });
    
	$('#submit').click(function(){
		var is = $('input[name="is"]').val();
		var id = $('input[name="dict_id"]').val();
		if (is == 2) { //删除
			$.post(
				"<?php echo site_url('admin/a/dictionary/delete')?>",
				{'id':id},
				function(data){
					data = eval('('+data+')');
					if (data.code == 2000) {
						alert(data.msg);
						window.location.reload();
					} else {
						alert(data.msg);
					}
				}
			);
			return false;
		}
		$.post(
			"<?php echo site_url('admin/a/dictionary/change_dict')?>",
			$('#add_dict_form').serialize(),
			function(data) {
				data = eval('('+data+')');
				if (data.code == 2000) {
					alert(data.msg);
					window.location.reload();
				} else {
					alert(data.msg);
				}
			}
		);
		
		return false;
	})
	function see_dict(id,is) {
		$.post(
			"<?php echo site_url('admin/a/dictionary/get_one_json')?>",
			{'id':id},
			function(data) {
				if (is == 1) {
					$('#submit').val('确认编辑');
				} else {
					$('#submit').val('确认删除');
				}
				data = eval('('+data+')');
				$('.upload_pic').remove();
				$('input[name="description"]').val(data.description);
				$('input[name="showorder"]').val(data.showorder);
				$('input[name="pic"]').val(data.pic);
				$('input[name="dict_pic"]').val('');
				if (typeof data.pic != "object" && data.pic.length > 0) {
					$('#dict_pic').after("<img class='upload_pic' src='"+data.pic+"' width='80' height='80'>");
				}
				$('input[name="dict_code"]').val(data.dict_code);
				$('select[name="pid"]').find('option[value="'+data.pid+'"]').attr('selected' ,true);
				$('input[name="dict_id"]').val(id);
				$('input[name="is"]').val(is);
			}
		);
		$('.bootbox').show();
		$('.modal-backdrop').show();
	}
</script>
