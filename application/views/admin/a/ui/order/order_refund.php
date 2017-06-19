
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="#"> 首页 </a></li>
			<li class="active">仪表盘</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="well with-header with-footer">
					<div class="widget">
						<div class="widget-header  with-footer">
							<span class="widget-caption">菜单</span>
							<div class="widget-buttons">
								<a href="#" data-toggle="maximize"> <i class="fa fa-expand"></i>
								</a> <a href="#" data-toggle="collapse"> <i class="fa fa-minus"></i>
								</a> <a href="#" data-toggle="dispose"> <i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="widget-body">
							<div class="flip-scroll">

								<label>
									<form class="form-inline" role="form" action="<?php echo site_url('admin/a/order/search_refund')?>" method="post">
										<div class="form-group dataTables_filter">
											<label class="sr-only"> 产品标题 </label> <input type="text"
												class="form-control" name="productname" value="<?php echo $productname;?>" placeholder="产品标题">
										</div>
										<div class="form-group dataTables_filter">
											<label class="sr-only"> 订单编号 </label> <input type="text"
												class="form-control" name="ordersn" value="<?php echo $ordersn;?>" placeholder="订单编号">
										</div>
										<div class="form-group">
											<div class="controls">
												<div class="input-group">
													<span class="input-group-addon"> <i class="fa fa-calendar">
													</i>
													</span> <input type="text" value="<?php echo $time;?>" name="time" class="form-control" >
												</div>
											</div>
										</div>
										<div class="form-group dataTables_filter">
											<label class="sr-only"> 供应商 </label> <input type="text"
												class="form-control" value="<?php echo $supplier_name;?>" name="supplier_name" placeholder="供应商">
										</div>
										<button type="submit" class="btn btn-darkorange">搜索</button>
									</form>
								</label>
								<table class="table table-hover">
									<thead class="bordered-darkorange">
										<tr>
											<th>订单编号</th>
											<th>预定人</th>
											<th>产品标题</th>
											<th>参团人数</th>
											<th>订单金额</th>
											<th>申请退款金额</th>
											<th>供应商</th>
											<th>专家</th>
											<th>出团日期</th>
											<th>申请时间</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($refund as $val):?>
										<tr>
											<td><?php echo $val['订单编号']?></td>
											<td><?php echo $val['预定人']?></td>
											<td><?php echo $val['产品标题']?></td>
											<td><?php echo $val['参团人数']?></td>
											<td><?php echo $val['订单金额']?></td>
											<td><?php echo $val['申请退款金额']?></td>
											<td><?php echo $val['供应商']?></td>
											<td><?php echo $val['专家']?></td>
											<td><?php echo $val['出团日期']?></td>
											<td><?php echo $val['申请时间']?></td>
											<td>
												<?php if( $val['rstatus'] == 0):?>
												<a href="javascript:void(0)" onclick ="refund(<?php echo $val['id'] ?>)"  class="btn btn-default btn-xs purple"><i
													class="fa fa-edit"></i>退款</a>
												<?php elseif($val['rstatus'] == 1):?>
													已退款
												<?php elseif($val['rstatus'] == 2):?>
													已拒绝退款
												<?php endif;?>
											</td>
										
										</tr>
										<?php endforeach;?>
									</tbody>
								</table>
							</div>
							<?php if ($is_page == 1):?>
							<div class="pagination"><?php echo $this->page->create_page()?></div>
							<?php endif;?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- /Page Body -->
</div>
<div id="finance_info" style="display: none;">
	<form class="form-horizontal" role="form" id="finance_form" method="post" action="#">
		
	</form>
	<script>
		function confirmation(id ,is) {
			$.post(
				"<?php echo site_url('admin/a/order/refund_money');?>",
				{'id':id ,'is':is},
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
	</script>
</div>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">  
	function refund(id) {
		$.post(
				"<?php echo site_url('admin/a/order/put_refund_json'); ?>",
				{'id':id },
				function (data) {
					$('#finance_form').html('');
					obj= $.parseJSON(data);
					$.each(obj,function(key,val){
						var str = '';
						str = "<div class='form-group'><label for='inputEmail3' class='col-sm-2 control-label no-padding-right'>"+key+"</label>";
						if (typeof(val) == "object") {
							val = '';
						}
						str += '<div class="col-sm-10"><input type="text" class="form-control" value="'+val+'" readonly  ></div></div>';
						$("#finance_form").append(str);
					})
					str = "";
					str += '<div class="form-group"><input type="button" class="btn btn-palegreen bootbox-close-button " aria-hidden="true"  type="button" value="取消" style="float: right; margin-right: 2%; " id="cancel"/>';
					str += '<input type="button" class="btn btn-palegreen" value="确认退款" style="float: right; margin-right: 15%;" onclick="confirmation('+id+',1)" /></div>';
					str += '<input type="button" class="btn btn-palegreen" value="拒绝退款" style="float: right; margin-right: 10%;margin-top: -47px;" onclick="confirmation('+id+',2)" /></div>'
					$("#finance_form").append(str);
					bootbox.dialog({
		                message: $('#finance_info').html(),
		                title: "退款",
		                className: ""              
		           });  	
				}
			);
     }

</script>
		
