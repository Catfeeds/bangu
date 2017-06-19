<style type="text/css">
	.form-group{ float: left; padding-right: 5px;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">提现管理</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	
				<div class="well with-header with-footer">
					<ul id="myTab5" class="nav nav-tabs">
						<li class="tab-red"><a
							href="<?php echo base_url(); ?>admin/a/expert/topic_list">新申请</a></li>
						<li class="active"><a
							href="<?php echo base_url(); ?>admin/a/expert/passed">已审核</a></li>
						<li class="tab-blue"><a
							href="<?php echo base_url(); ?>admin/a/expert/refused">已拒绝</a></li>
					</ul>

					<div class="tab-content">
						<label>
							<form class="form-inline" role="form"
								action="<?php echo base_url(); ?>admin/a/expert/passed" method="get">
								<div class="form-group dataTables_filter" style="">
									<label class="sr-only"> 专家</label> <input type="text"
										onfocus="init_value(this)" name="cardholder" id="expert_name"
										class="form-control" placeholder="专家姓名"
										value="<?php echo $cardholder?>">
								</div>
								<div class="form-group" style="width:200px">
									<div class="controls">
										<div class="input-group">
											<span class="input-group-addon"> <i class="fa fa-calendar"></i>
											</span> <input type="text" class="form-control"
												onfocus="init_value(this)" id="apply_date"
												value="<?php echo $addtime?>" name="addtime" value="申请时间">
										</div>
									</div>
								</div>
								<button type="submit" class="btn btn-darkorange" style="float:left;">搜索</button>
							</form>
						</label>

							<table
								class="table table-striped table-hover table-bordered dataTable no-footer"
								id="editabledatatable" aria-describedby="editabledatatable_info">
								<thead>
									<tr role="row">
										<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 120px; text-align: center">编号</th>
									<th class="sorting_disabled" tabindex="0" rowspan="1"
									colspan="1" style="width: 120px;text-align:center">完成日期</th>
										<th class="sorting_disabled" tabindex="0" rowspan="1"
											colspan="1" style="width: 120px; text-align: center">申请日期</th>
										<th class="sorting_disabled" tabindex="0" rowspan="1"
											colspan="1" style="width: 100px; text-align: center">流水号</th>
										<th class="sorting_disabled" tabindex="0" rowspan="1"
											colspan="1" style="width: 120px; text-align: center">交易类型</th>
										<th class="sorting_disabled" tabindex="0" rowspan="1"
											colspan="1" style="width: 120px; text-align: center">可提现金额</th>
										<th class="sorting_disabled" tabindex="0" rowspan="1"
											colspan="1" style="width: 120px; text-align: center">申请金额</th>
										<th class="sorting_disabled" tabindex="0" rowspan="1"
											colspan="1" style="width: 120px; text-align: center">专家名称</th>
										<th class="sorting_disabled" rowspan="1" colspan="1"
											style="width: 300px; text-align: center">审核人</th>
									</tr>
								</thead>
								<tbody>
						 <?php foreach ($passed_list as $item): ?>
							<tr>
										<td style="text-align: center"><?php echo $item['id']?></td>
										<td style="text-align: center"><?php echo $item['modtime']?></td>
										<td style="text-align: center"><?php echo $item['apply_date']?></td>
										<td style="text-align: center"><?php echo $item['serial_number']?></td>
										<td style="text-align: center"><?php echo $item['bankname']?></td>
										<td style="text-align: center"><?php echo $item['amount_before']?></td>
										<td style="text-align: center"><?php echo $item['apply_amount']?></td>
										<td style="text-align: center"><?php echo $item['expert_name']?></td>
										<td style="text-align: center"><?php echo $item['operator']?></td>
									</tr>
							<?php endforeach;?>
						</tbody>
							</table>
							<div class="pagination"><?php echo $this->page->create_page()?></div>
					</div>
				</div>
		
	<!-- /Page Body -->
</div>
<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script
	src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script>
$('#apply_date').daterangepicker();
</script>


