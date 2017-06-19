<style type="text/css">
	.col_lb{ float: left; width: 16%; text-align: right;}
	.col_ts{ float: left;}
	.col-sm-10{ width: 83%;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">用户获取积分设置</li>
		</ul>
	</div>

	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	<div class="page-body"> 
		<div class="row">
			<div class="col-xs-12 col-md-12">
					<div class="tab-content"> 
						<div class="table-toolbar">
							<button id="add_member_point" class="btn btn-default" >添加</button>
						</div>
						<table
							class="table table-striped table-hover table-bordered dataTable no-footer"
							id="editabledatatable" aria-describedby="editabledatatable_info">
							<thead>
								<tr role="row">
									<th class="sorting_disabled" tabindex="0" rowspan="1"
										colspan="1" style="width: 120px;text-align:center">程序标识</th>
									<th class="sorting_disabled" tabindex="0" rowspan="1"
										colspan="1" style="width: 100px;text-align:center">积分类型</th>
									<th class="sorting_disabled" tabindex="0" rowspan="1"
										colspan="1" style="width: 150px;text-align:center">消息内容</th>
									<th class="sorting_disabled" tabindex="0" rowspan="1"
										colspan="1" style="width: 120px;text-align:center">是否开启</th>
									<th class="sorting_disabled" tabindex="0" rowspan="1"
										colspan="1" style="width: 140px;text-align:center">积分</th>
									<th class="sorting_disabled" rowspan="1" colspan="1"
										style="width: 300px;text-align:center">操作</th>
								</tr>
							</thead>
							<tbody>
						 <?php foreach ($member_point_list as $item): ?>
							<tr>
									<td style="text-align:center"><?php echo $item['code']?></td>
									<td style="text-align:center"><?php echo $item['pointtype']?></td>
									<td style="text-align:center"><?php echo $item['content']?></td>
									<td style="text-align:center"><?php echo $item['isopen']?></td>
									<td style="text-align:center"><?php echo $item['value']?></td>
									<td style="text-align:center"><a data-val="<?php echo $item['id']?>"
										class="btn btn-info btn-xs edit"
										onclick="edit_member_point(this)">  修改
									</a> <a data-val="<?php echo $item['id']?>"
										class="btn btn-info btn-xs edit"
										onclick="delete_member_point(this)"> 删除
									</a> </td>
								</tr>
							<?php endforeach;?>
						</tbody>
						</table>
						<div class="pagination"><?php echo $this->page->create_page()?></div>
					 </div>
				</div>
			</div>
	</div> 

	<!-- /Page Body -->
</div>

<div style="display:none;" class="bootbox modal fade in" id="add_member_point_modal">
	<div class="modal-dialog" style="margin:30px auto;width:600px;">
		<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
		<h4 class="modal-title">添加用户积分</h4>
	</div>
<div class="modal-body">
<div class="bootbox-body">
	<div>
	<form class="form-horizontal" role="form" id="add_member_point_form" method="post" action="#">
	    <div class="form-group">
	     <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">程序标识</label>
	     <div class="col-sm-10 col_ts">
	      <input type="text" class="form-control" name="code" id="code" value=""/>
	     </div>
	    </div>
	        <div class="form-group">
	     <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">积分类型</label>
	     <div class="col-sm-10 col_ts">
	      <input type="text" class="form-control" name="point_type" id="point_type" value=""/>
	     </div>
	    </div>
	    <div class="form-group">
	     <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">积分值</label>
	     <div class="col-sm-10 col_ts">
	      <input type="text" class="form-control" name="point_value" id="point_value" value=""/>
	     </div>
	    </div>

	    <div class="form-group">
	     <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">是否开启</label>
	     <div class="col-sm-10 col_ts">
	      <select class="form-control" name="is_open" id="is_open">
	      	<option value="1">开启</option>
	      	<option value="0">关闭</option>
	      </select>
	     </div>
	    </div>


	    <div class="form-group">
	     <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">消息内容</label>
	     <div class="col-sm-10 col_ts">
	      <textarea name="content" id="content" rows="6" cols="57"></textarea>
	      <input type="hidden" name="member_point_id" id="member_point_id" value=""> <!--隐藏一个ID,用于编辑-->
	     </div>
	    </div>
	    <div class="form-group">
	     <input type="button" onclick="hidden_modal()" class="btn btn-palegreen bootbox-close-button " aria-hidden="true" value="取消" style="float: right; margin-right: 2%; " />
	     <input type="submit" class="btn btn-palegreen" value="提交" style="float: right; margin-right: 2%;" />
	    </div>
	   </form>
	</div>
	</div>
</div>
 </div>
</div>
</div>
<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>








<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript">
//隐藏弹框
function hidden_modal(){
	$("#back_ground_modal").hide();
	$("#add_member_point_modal").hide();
}

//弹框添加
$('#add_member_point').click(function(){
	$("#code").val('');
	$('#is_open option').attr('selected',false);
	$("#point_value").val('');
	$("#point_type").val('');
	$("#content").val('');
	$('#member_point_id').val('');
	$("#back_ground_modal").show();
	$("#add_member_point_modal").show();
});

	$('#add_member_point_form').submit(function(){
			$.post(
				"<?php echo site_url('admin/a/index_member_point/add_edit_member_point');?>",
				$('#add_member_point_form').serialize(),
				function(data) {
					data = eval('('+data+')');
					if (data.status == 1) {
						alert(data.msg);
						location.reload();
					} else {
						alert(data.msg);
					}
				}
			);
			return false;
		});
function edit_member_point(obj){
	var id = $(obj).attr('data-val');
	$.post("<?php echo base_url()?>admin/a/index_member_point/get_one_member_point",
		{"id":id},
		function(data){
			data = eval('('+data+')');
			$("#code").val(data.code);
			$("#point_type").val(data.pointtype);
			$('#is_open option[value='+data.isopen_code+']').attr('selected',true);
     			$("#content").val(data.content);
     			$("#point_value").val(data.value);
     			$('#member_point_id').val(id);
     			$("#back_ground_modal").show();
			$("#add_member_point_modal").show();
		});
}


function delete_member_point(obj){
	var id = $(obj).attr('data-val');
	$.post("<?php echo base_url()?>admin/a/index_member_point/delete_member_point",
		{"id":id},
		function(data){
			alert('删除成功!');
			location.reload();
		});
	}
</script>