<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.tbtsd { height:30%;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">结算管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs">
					<a href="#home11" data-toggle="tab" id="tab0"> 未结算</a></li>
					<li class="" name="tabs">
					<a href="#profile11" data-toggle="tab" id="tab1"> 已结算 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 未结算 -->
					<div class="tab-pane active" id="tab_content0">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width:auto">对账单号：</label>
										<div class="col-lg-4 w_200">
											<input type="text" name="ordersn"
												class="form-control user_name_b1" style="width:100px;"> <input type="hidden"
												name="status" class="form-control user_name_b1" value='0'>
										</div>
										<label class="col-lg-4 control-label" style="width:auto">结算日期：</label>
										<div class="col-lg-4 w_200">
										 	<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  class="form-control"
													id="reservation" name="line_time" style="width:160px;">
											</div> 
										</div>

										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4 w80">
											<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
										</div>
									</div>
								</form>
								<div style="margin-bottom: 10px;">   <a target="_blank" 
                                     href="<?php echo base_url();?>admin/b1/account/show_supplier_add_order"><input type="button" value="新建结算单" id="searchBtn" class="btn btn-palegreen"></a></div>		
								<div id="list"></div>
							</div>
						</div>
					</div>

					<!-- 已结算 -->
					<div class="tab-pane" id="tab_content1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="list1Form"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width:auto">对账单号：</label>
										<div class="col-lg-4 w_200">
											<input type="text" name="ordersn"
												class="form-control user_name_b1"> <input type="hidden"
												name="status" class="form-control user_name_b1" value='1'>
										</div>
										<label class="col-lg-4 control-label" style="width:auto">结算日期：</label>
										<div class="col-lg-4 w_200">
											<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  class="form-control"
													id="reservation2" name="line_time">
											</div>
										</div>

										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4 w80">
											<input type="button" value="搜索" class="btn btn-palegreen " id="searchBtn1">
										</div>
									</div>
								</form>

								<div id="list1"></div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- 未结算弹出框 -->
<div style="display: none;" class="tbtsd">
	<div class="closetd" style="opacity: 0.2; padding:0 0 0 8px;font-size: 20px; font-weight: 800;">×</div>
	<div align="center" style="height:100%;">
		<div class="widget-body" style="height:100%;">
			<div id="registration-form" class="messages_show" style="height:90%;overflow-y:auto;overflow-x:hidden;margin-top:35px; ">
				<table class="table table-bordered table-hover money_table">
						<thead>
							<tr>
								<th class="account_money_width">订单号</th>
								<th class="account_money_width">预订人</th>
								<th class="account_money_width">产品标题</th>
								<th class="account_money_width">参团人数</th>
								<th class="account_money_width">订单金额</th>
								<th class="account_money_width">管家佣金 </th>
								<th class="account_money_width">平台使用费</th>
								 <th class="account_money_width">实付金额</th> 
								<th class="account_money_width">出团日期</th>
								<th class="account_money_width">下单时间</th>
							</tr>
						</thead>
						<tbody id="account_detail">

						    <tr> <!--  
							<td><?php //echo $item['ordersn']?></td>
							<td><?php //echo $item['truename'];?></td>
							<td><?php //echo $item['productname']?></td>
							<td><?php //echo $item['joinnum']?></td>
							<td><?php //echo $item['total_price']?></td>
							<td><?php //echo $item['agent_fee']?></td>
							<td><?php //echo $item['a_rate'];?></td>			
							<td><?php //echo sprintf("%.2f",($item['total_price']- $item['total_price']*$item['agent_rate']-$item['agent_fee']));?></td>
							<td><?php //echo $item['usedate']?></td>
							<td><?php //echo $item['addtime']?></td>-->
							</tr>
				
						</tbody>
					</table>
			</div>
		</div>
	</div>
</div>
<div class="bgsd" style="display: none;"></div>
<!-- 未结算弹出框结束 -->
<?php echo $this->load->view('admin/b1/common/account_script'); ?>
<?php echo $this->load->view('admin/b1/common/time_script'); ?>
