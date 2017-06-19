
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="<?php echo site_url('admin/b1/home')?>">首页</a></li>
		<li class="active">供应商后台</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<!-- Page Header -->
<div class="page-header position-relative">
	<div class="header-title">
		<h1>结算管理</h1>
	</div>
	<div class="header-buttons">
		<a class="sidebar-toggler" href="#"> <i class="fa fa-arrows-h"></i>
		</a> <a class="refresh" id="refresh-toggler" href=""> <i
			class="glyphicon glyphicon-refresh"></i>
		</a> <a class="fullscreen" id="fullscreen-toggler" href="#"> <i
			class="glyphicon glyphicon-fullscreen"></i>
		</a>
	</div>
</div>
<!-- /Page Header -->
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs"><a href="#home11" data-toggle="tab"
						id="tab0"> 未结算 ()</a></li>
					<li class="" name="tabs"><a href="#profile11" data-toggle="tab"
						id="tab1"> 已结算() </a></li>
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
										<label class="col-lg-4 control-label" style="width: 100px;">对账单号：</label>
										<div class="col-lg-4" style="width: 10%;">
											<input type="text" placeholder="对账单号" name="ordersn"
												class="form-control user_name_b1"> <input type="hidden"
												name="status" class="form-control user_name_b1" value='0'>
										</div>
										<label class="col-lg-4 control-label" style="width: 100px;">结算日期：</label>
										<div class="col-lg-4" style="width: 20%;">
										 	<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  placeholder="结算日期" class="form-control"
													id="reservation" name="line_time">
											</div> 
											<!-- <input type="text" placeholder="结算日期" name="startdatetime"
												class="form-control user_name_b1"> -->
										</div>
										<!--  <div class="col-lg-4" style="width: 10%;">
											<input type="text" placeholder="结束日期" name="enddatetime"
												class="form-control user_name_b1">
										</div>-->
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
										</div>
									</div>
								</form>

								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 未结算弹出框 -->
					<div style="display: none;" class="tbtsd">
						<div class="closetd" style="opacity: 0.2; padding:0 0 0 8px;font-size: 20px; font-weight: 800;">×</div>
						<div align="center" style="height:100%;">
							<div class="widget-body" style="height:100%;">
								<div id="registration-form" class="messages_show" style="height:90%;overflow-y:auto;overflow-x:hidden;margin-top:35px; ">
			
								</div>
							</div>
						</div>
					</div>
					<div class="bgsd" style="display: none;"></div>
					<!-- 未结算弹出框结束 -->
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
										<label class="col-lg-4 control-label" style="width: 100px;">对账单号：</label>
										<div class="col-lg-4" style="width: 10%;">
											<input type="text" placeholder="对账单号" name="ordersn"
												class="form-control user_name_b1"> <input type="hidden"
												name="status" class="form-control user_name_b1" value='1'>
										</div>
										<label class="col-lg-4 control-label" style="width: 100px;">结算日期：</label>
										<div class="col-lg-4" style="width: 18%;">
											<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  placeholder="结算日期" class="form-control"
													id="reservation2" name="line_time">
											</div>
										<!-- 	<input type="text" placeholder="结算日期" name="sn"
												class="form-control user_name_b1"> -->
										</div>
									<!--  	<div class="col-lg-4" style="width: 10%;">
											<input type="text" placeholder="结束日期" name="sn"
												class="form-control user_name_b1">
										</div>-->
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
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

<?php echo $this->load->view('admin/b1/common/account_script'); ?>
<?php echo $this->load->view('admin/b1/common/time_script'); ?>

