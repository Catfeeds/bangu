<style type="text/css">
	.col_span{ float: left;margin-top: 6px}
	.col_ip{ float: left; }
.col-sm-10{width: 76.333%}

</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">投诉列表</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

				
						<div class="widget-header ">
							<span class="widget-caption">投诉列表</span>
							<div class="widget-buttons">
								<!-- <a href="#" data-toggle="maximize"> <i class="fa fa-expand"></i>
								</a> <a href="#" data-toggle="collapse"> <i class="fa fa-minus"></i>
								</a> <a href="#" data-toggle="dispose"> <i class="fa fa-times"></i>
								</a> -->
							</div>
						</div>
						<div class="widget-body">
							<div role="grid" id="simpledatatable_wrapper"
								class="dataTables_wrapper form-inline no-footer">
								<div id="simpledatatable_filter" >
									<label>
										<form class="form-inline" role="form"  method="post" action="<?php echo site_url('admin/a/expert/complain_list')?>">
										    <div class="form-group dataTables_filter col_ip" >

										        <input type="text" class="form-control" placeholder="产品名称" name="line_name" value="<?php echo $line_name;?>">
										    </div>
										    <div class="form-group dataTables_filter col_ip"style="padding-left:15px;" >

										        <input type="text" class="form-control" placeholder="投诉人"  name="complainant" value="<?php echo $truename;?>">
										    </div>
										    <div class="checkbox col_ip" style="\margin-top:0px; padding-right:15px;" >

										        <label><span class=" col_span">状态</span>
										            <select name="status" class="form-control input-sm " style="width:100px;float:left;">
												<option value="" >
													        	请选择
												</option>
												<option value="9" <?php if($status==9) echo "selected='selected'";?>>
													        	待处理
												</option>
												 <option value="1" <?php if($status==1) echo "selected='selected'";?>>
													        	已处理
												</option>
											</select>
										        </label>
										    </div>
										    <button type="submit" class="btn btn-default" style="float:left;">
										        	搜索
										    </button>
										</form>
									</label>
								</div>
								<div class="dataTables_length" id="simpledatatable_length">
									<label></label>
								</div>
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="simpledatatable" aria-describedby="simpledatatable_info">
									<thead>
										<tr role="row">
											<th style="text-align:center">投诉人</th>
											<th style="text-align:center">投诉时间</th>
											<th style="text-align:center" >投诉内容</th>
											<th style="text-align:center">产品名称</th>
											<th style="text-align:center">专家</th>
											<th style="text-align:center">状态</th>
											
											<th style="text-align:center">供应商</th>
											<th style="text-align:center">附件</th>
											<th style="text-align:center">联系电话</th>
											<th style="text-align:center">投诉对象</th>
											<th style="text-align:center">处理意见</th>
											<th style="text-align:center">操作</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($complain_list as $item): ?>
       									 <tr>
           								     <td class="sorting_1" style="text-align:center"><?php echo $item['complainant'];?></td>
           								     <td class=" " style="text-align:center"><?php echo $item['complainTime'];?></td>
            								     <td title="<?php echo $item['content']?>" style="text-align:center"><?php echo str_cut($item['content'],45);?></td>
            								     <td title="<?php echo $item['product']?>" style="text-align:center"><?php echo str_cut($item['product'],45) ;?></td>
            								     <td class=" " style="text-align:center"><?php echo $item['expert'];?></td>
            								     <td class=" " style="text-align:center"><?php echo $item['status'];?></td>
									     <td class=" " style="text-align:center"><?php echo $item['supplier'];?></td>
										 <td class=" " style="text-align:center" ><?php if ($item['attachment']==''){?> 暂无附件下载<?php }else{?><a href="<?php echo $item['attachment'];?>"> 附件下载</a><?php }?></td>
										 
									     <td class=" " style="text-align:center"><?php echo $item['phone'];?></td>
									     <td class=" " style="text-align:center"><?php echo $item['complain_type'];?></td>
									     <td title="<?php echo $item['remark']?>"><?php echo str_cut($item['remark'],45)?></td>
									    <td class=" " style="text-align:center">
									    <?php if ($item ['status'] == '待处理'): ?>
									    <a href="javascript:void(0);" onclick="edit_see(<?php echo $item['cid']?>)"  class="btn btn-default btn-xs purple">转为已处理</a></td>
										<?php endif;?>
									  </tr>
									<?php endforeach;?>
									</tbody>
								</table>
								<div class="pagination"><?php echo $this->page->create_page()?></div>
							</div>
						</div>
				


	<!-- /Page Body -->
</div>
<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">投诉处理</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="nav_form" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">投诉人</label>
						<div class="col-sm-10">
							<input class="form-control" disabled  name="member_name" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">投诉内容</label>
						<div class="col-sm-10">
							<textarea name="reason" rows="6" cols="50" disabled></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">投诉时间</label>
						<div class="col-sm-10">
							<input class="form-control" disabled name="addtime" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">处理意见</label>
						<div class="col-sm-10">
							<textarea name="remark" rows="6" cols="50" maxlength="40" placeholder="请填写处理意见，最多40字"></textarea>
						</div>
					</div>

					<input type="hidden" value="" name="complain_id">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input id="submit_complain" class="btn btn-palegreen submit" value="提交" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade in" style="display:none;"></div>
<script>
	function edit_see(id) {
		$.post(
			"<?php echo site_url('admin/a/expert/get_complain_json')?>",
			{'id':id},
			function(data) {
				data = eval('('+data+')');
				$('input[name="member_name"]').val(data.complainant);
				$('input[name="addtime"]').val(data.complainTime);
				$('textarea[name="reason"]').val(data.content);
				 $('input[name="complain_id"]').val(data.cid);
				$('.modal-backdrop').show();
				$('.bootbox').show();
			}
		)
	}
	$('.bootbox-close-button').click(function(){
		$('input[name="member_name"]').val('');
		$('input[name="addtime"]').val('');
		$('textarea[name="reason"]').val('');
		 $('input[name="complain_id"]').val('');
		$('.modal-backdrop').hide();
		$('.bootbox').hide();
	})
	$('#submit_complain').click(function(){
		var id = $('input[name="complain_id"]').val();
		var remark = $('textarea[name="remark"]').val();
		$.post(
			"<?php echo site_url('admin/a/expert/complain_change')?>",
			{'id':id,'remark':remark},
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
	})
</script>
