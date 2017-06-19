<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
<meta charset="utf-8" />
<title>后台产品详情页</title>
<meta name="description" content="Dashboard" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon"
	href="<?php echo base_url('assets/img/favicon.png');?>"
	type="image/x-icon">
<link href="<?php echo base_url('assets/css/product.css')?>"
	rel="stylesheet" />
<!--Basic Styles-->
<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>"
	rel="stylesheet" />
<link id="bootstrap-rtl-link" href="" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/font-awesome.min.css');?>"
	rel="stylesheet" />
<link href="<?php echo base_url('assets/css/weather-icons.min.css');?>"
	rel="stylesheet" />
<link href="<?php echo base_url('assets/css/hm.widget.css');?>"
	rel="stylesheet" />

<!--Fonts-->
<link href="<?php echo base_url('assets/css/fonts.css');?>"
	rel="stylesheet" type="text/css">

<!--Beyond styles-->
<link id="beyond-link"
	href="<?php echo base_url('assets/css/beyond.min.css');?>"
	rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/demo.min.css');?>"
	rel="stylesheet" />
<link href="<?php echo base_url('assets/css/typicons.min.css');?>"
	rel="stylesheet" />
<link href="" rel="stylesheet" />
<link id="skin-link" href="" rel="stylesheet" type="text/css" />
<!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
<script src="<?php echo base_url('assets/js/skins.min.js');?>"></script>
<!--Basic Scripts-->
<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<!--Beyond Scripts-->
<script src="<?php echo base_url('assets/js/beyond.min.js');?>"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<style type="text/css">
.widget-body .form-group label {;
	font-weight: bolder;
}

.line-lable {
	color: #15b000;
	height: 26px;
	line-height: 26px;
	position: relative;
	background: #edf6fa;
	border: 1px solid #d7e4ea;
	padding: 6px 20px 6px 12px;
	margin-right: 2px;
	vertical-align: middle;
}

.line-lable a {
	display: block;
	width: 24px;
	height: 32px;
	position: absolute;
	top: 0;
	right: 0;
	cursor: pointer;
	text-align: center;
	font-size: 21px;
	font-weight: 700;
	color: #000;
	text-shadow: 0 1px 0 #fff;
	filter: alpha(opacity = 20);
	opacity: .2;
}
/* 屏蔽设置价格*/
 .cal-manager .add-package{display:none;}
/*.form-list{display:none;}
.del-package{display:none;} */
</style>
</head>
<!-- /Head -->
<!-- Body -->
<body>
	<div class="navbar">
		<div class="navbar-inner">
			<div class="navbar-container">
				<!-- Navbar Barnd -->
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand"> <small> Ubang.com </small>
					</a>
				</div>
				<!-- /Navbar Barnd -->
				<!-- Sidebar Collapse -->
				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="collapse-icon fa fa-bars"></i>
				</div>
				<!-- /Sidebar Collapse -->
				<!-- Account Area and Settings --->
				<div class="navbar-header pull-right">


					<!-- Settings -->
				</div>
			</div>
			<!-- /Account Area and Settings -->
		</div>
	</div>
	<!-- /Navbar -->
	<!-- Main Container -->
	<div class="main-container container-fluid">
		<!-- Page Breadcrumb -->
		<div class="page-breadcrumbs">
			<ul class="breadcrumb">
				<li><i class="fa fa-home"></i> <a
					href="<?php echo site_url('/admin/b2/order/index')?>">首页</a></li>
				<li>申请售卖权</li>
				<li class="active">产品详情</li>
			</ul>
		</div>
		<!-- /Page Breadcrumb -->

		<div class="widget flat radius-bordered">
			<div class="widget-body">
				<div class="widget-main ">
					<div class="tabbable">
						<ul id="myTab11" class="nav nav-tabs tabs-flat">
							<li class="active"><a href="#home11" data-toggle="tab"> 基础信息 </a></li>
							<li class=""><a class="routting" href="#profile12" data-toggle="tab" id="routting" name="rout"> 行程安排 </a></li>
							<li class=""><a href="#profile10" data-toggle="tab"> 报价 </a></li>
							<li class=""><a href="#profile14" data-toggle="tab"> 费用说明 </a></li>
							<li class=""><a href="#profile16" data-toggle="tab">参团须知 </a></li>
							<li class=""><a href="#profile15" data-toggle="tab">产品标签 </a></li>
							<li class="" id="expert_training"><a href="#profile17" data-toggle="tab"> 管家培训 </a><li>
							<?php if(!empty($gift)){ ?><li class="" id="supplierGift"><a href="#profile13" data-toggle="tab"> 抽奖礼品</a><li> <?php }?>
							
						
						</ul>
						<div class="tab-content tabs-flat" style="padding: 0px 12px;width: 1200px;">
							<!-- 基础信息 -->
							<div class="tab-pane active" id="home11" style="height: 500px;">
								<form accept-charset="utf-8" class="form-horizontal bv-form"  action=""  method="post" id="linebascForm">
									<input name="id"
										value="<?php  if(!empty($data['id'])){echo $data['id']; }?>"
										id="id" type="hidden" />
									<div class="widget-body">
										<div id="registration-form">
											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													for="inputEmail3" style="width: 120px; padding-top: 0px;">线路名称：</label>
												<div class="col-sm-10"><?php echo $data['linename'];?></div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">线路副标题：</label>
												<div class="col-sm-10"><?php echo $data['linetitle'];?></div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;">出发地：</label>
												<div class="col-sm-10">
													<?php
													if(!empty($citystr)){
														echo $citystr;
													}
													?>
												</div>
											</div>
											<div class="form-group">
												<!-- 目的地 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">目的地：</label>
												<div class="col-sm-10" style="width: 70%;">
													<span id="ds-list">
													<?php
													foreach ( $overcity_arr as $overcity ) :
														echo $overcity ['name'] . '&nbsp;&nbsp;';
													endforeach
													;
													?>
													</span>
												</div>
											</div>

                                       							 <?php if(!empty($themeid)){ ?>
											<div class="form-group">
												<!-- 主题游 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">主题游：</label>
												<div class="col-sm-10" style="width: 70%;">
													<span id="attr-list">
													<?php  echo $themeid[0]['name']; ?>
													</span>
												</div>
											</div>
										<?php }?>
											<div class="form-group">
												<!-- 主题游 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">提前报名天数：</label>
												<div class="col-sm-10" style="width: 70%;">
													<span id="attr-list">
													<?php  echo $data['linebefore']; ?>
													</span>
												</div>
											</div>
											<div class="form-group">
												<!-- 主题游 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">押金：</label>
												<div class="col-sm-10" style="width: 70%;">
													<span id="attr-list">
													<?php  echo empty($affiliated['deposit']) ? 0 : $affiliated['deposit']; ?>
													</span>
												</div>
											</div>
											<div class="form-group">
												<!-- 主题游 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">提前交团款天数：</label>
												<div class="col-sm-10" style="width: 70%;">
													<span id="attr-list">
													<?php  echo empty($affiliated['before_day']) ? 0 : $affiliated['before_day']; ?>
													</span>
												</div>
											</div>
										
											<div class="form-group">
												<!-- 线路特色 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">线路特色：</label>
												<div class="col-sm-10" style="width:700px;">
												<?php if(!empty($data['features'])){ echo $data['features'] ;}?>
												</div>
											</div>
											<!-- <button id="apply_line_form" type="submit" class="btn btn-blue">成为管家</button> -->
										</div>
									</div>
								</form>
							</div>

							<!-- 行程安排 -->
							<div class="tab-pane" id="profile12">
								<form action="" accept-charset="utf-8"
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" name="fromRout"
									onsubmit="return CheckRouting();" method="post"
									id="lineDayForm" novalidate="novalidate">
									<div class="widget-body" id="rout_line">
										<?php  $num = $data ['lineday'];for($i = 0; $i < $num; ++ $i) { ?>
										<input name="lineday" id="lineday" value="<?php if(!empty($data ['lineday'])){ echo $data ['lineday'];}?>" id="id" type="hidden" />
										<div id="registration-form">
											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;font-size:18px;" for="inputEmail3">
													第<?php echo $i+1; ?>天：</label>
												<div class="col-sm-10" style="line-height:27px;">
												<?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?>
												</div>
											</div>
											<?php if(!empty($rout[$i]['transport']) && $rout[$i]['transport']!='无'){  ?>
											<div class="form-group">
												<!-- 往返交通 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">城市间交通：</label>
												<div class="col-sm-10">
													<div class="col-lg-1 col-sm-1 col-xs-1"
														style="width: auto; padding: 0px; line-height: 7px;">
														<div class="checkbox">
															<label
																style="padding: 0px; text-align: left; font-weight: 500;">
																<?php if(!empty($rout[$i]['transport'])){ echo $rout[$i]['transport'];} ?>
															</label>
														</div>
													</div>
												</div>
											</div>
											<?php }?>
											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">用餐：</label>
												<div class="form-inline">
													<div class="checkbox " style="padding-top: 0px;">
														<label style="padding: 0px; text-align: left; width: auto; padding-right: 10px;">
															早餐：<?php if(!empty($rout[$i])){ if($rout[$i]['breakfirsthas']==1){ echo $rout[$i]['breakfirst'];}else{ echo '不含';}} ?>
														</label>
													</div>
													<div class="checkbox" style="padding-top: 0px;">
														<label	style="padding: 0px; text-align: left; width: auto; padding-right: 10px;">
															午餐：<?php if(!empty($rout[$i])){ if($rout[$i]['lunchhas']==1){echo $rout[$i]['lunch'];}else{echo '不含';}} ?>
														</label>
													</div>
													<div class="checkbox" style="padding-top: 0px;">
														<label style="padding: 0px; text-align: left; width: auto; padding-right: 10px;">
															晚餐 :<?php if(!empty($rout[$i])){ if($rout[$i]['supperhas']==1){ echo $rout[$i]['supper'];}else{echo '不含';}} ?>
														</label>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">住宿：</label>
												<div class="col-sm-10">
												<?php if(!empty($rout[$i])){ echo $rout[$i]['hotel'];} ?>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">行程：</label>
												<div class="col-sm-10">
												<?php if(!empty($rout[$i])){ echo $rout[$i]['jieshao'];} ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 70px; padding-top: 0px;" for="inputEmail3"></label>
												<div class="col-sm-10" style="width: 650px;">
													<ul>
													<?php
														if (! empty ( $rout [$i] )) {
															$pic_arr = explode ( ';', $rout [$i] ['pic'] );
															foreach ( $pic_arr as $k => $v ) {
																if (! empty ( $v )) {
																	?>
													<li style="margin: 5px 5px 0px 0px; float: left;"><img alt=""	style="width: 180px; height: 160px;" src="<?php echo $v; ?>"></li>
													<?php } }}?>
													</ul>
												</div>
											</div>
										</div>
										<?php } ?>
										</div>

								</form>
							</div>
							<!-- 设置价格 -->
							<input type="hidden"
								value="<?php echo date('Y-m-01', strtotime('0 month'));?>"
								id="selectMonth" name="selectMonth" />
							<div class="tab-pane" id="profile10">
								<form action="" accept-charset="utf-8"
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post"
									id="linePriceForm" novalidate="novalidate">
									<input name="lineId" type="hidden" id="lineId"
										value="<?php echo $data['id'];?>" />
									<div class="widget-body" style="padding: 0;">
										<div id="registration-form">
											<div id="day_price">
												<div style="margin-top: 10px;">
													
													<div style="margin-top:20px;">
														<span style="padding-left: 5px;">促销价:</span>
												  	    <input style="padding-left: 5px;width:45px; background: #ebebe4" class="price_input" type="text" readonly="readonly" disabled="disabled" value="<?php if(!empty($data['lineprice'])){ echo $data['lineprice']; }?>" name="lineprice" id="lineprice" />
														<span>元/</span>
														<input style="padding-left: 5px;width:38px; background: #ebebe4" class="price_input uint1" type="text" readonly="readonly" disabled="disabled" value="<?php if(!empty($suits[0]['unit'])){ echo $suits[0]['unit']; }else{ echo '1';}?>" name="unit" id="unit" />
														<span>人份</span>
																
														<span>已优惠:</span>
												  	    <input style="padding-left: 5px;width:50px; background: #ebebe4" class="price_input" type="text" readonly="readonly" disabled="disabled" value="<?php echo $data['saveprice'];?>" id="saveprice" name="saveprice" />
												  	    <span>元/人</span>	  
												  	</div>
												  	<div style="margin-top:20px;"><span>成人佣金:</span>
												  		<input style="padding-left: 5px;width:60px; background: #ebebe4" class="price_input" type="text" readonly="readonly" disabled="disabled"  value="<?php echo $data['agent_rate_int'];?>" id="agent_rate" class="form-control text-width" name="agent_rate"  />
												  		<span>元/人份</span>
												  	</div>
												  	  <div style="margin-top:20px;"><span>小童佣金:</span>
												  		<input style="padding-left: 5px;width:60px; background: #ebebe4" class="price_input" type="text" readonly="readonly" disabled="disabled"  value="<?php echo $data['agent_rate_child'];?>" id="agent_rate" class="form-control text-width" name="agent_rate_child"  />
												  		<span>元/人份</span>
												  	</div>
													<div style="margin-top:15px;"><span>备注:</span></div> 
												
													<div style="margin-top: 20px;">
														<span class=" col_price">儿童占床说明 :</span>
														 <span id="child_description"><?php if(!empty($data['child_description'])){ echo $data['child_description']; }else{echo '暂无内容'; } ?></span>
													</div>


													<div style="margin-top: 20px;">
														<span class=" col_price">儿童不占床说明 :</span>
														 <span id="child_nobed_description"><?php if(!empty($data['child_nobed_description'])){ echo $data['child_nobed_description']; }else{echo '暂无内容'; }?></span>
													</div>

													<div style="margin: 10px 0px 10px 0px;">
														<span class=" col_price">老人价说明 :</span>
														<span id="old_description"><?php if(!empty($data['old_description'])){ echo $data['old_description'];}else{echo '暂无内容'; } ?></span>
													</div>

													<div style="margin-bottom: 30px;">
														<span class=" col_price">特殊人群说明:</span> 
														<span id="special_description"><?php if(!empty($data['special_description'])){ echo $data['special_description'];}else{echo '暂无内容'; } ?></span>
													</div>

													<div class="cal-manager">
													</div>
												</div>

											</div>
										</div>
									</div>

								</form>
							</div>

							<!-- 费用说明 -->
							<div class="tab-pane" id="profile14" style="min-height: 400px;">
								<form action="" accept-charset="utf-8"
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post"
									id="linePriceForm" novalidate="novalidate">
									<div class="widget-body">
										<div id="registration-form">

											<div class="form-group">
												<!-- 费用包含 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px;padding-top: 0px;" for="inputEmail3">费用包含：</label>
												<div class="col-sm-10">
												<?php if(!empty($data['feeinclude'])){ echo $data['feeinclude'];}else{ echo '暂无信息'; } ?>
												</div>
											</div>

											<div class="form-group">
												<!-- 费用不包含 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">费用不含：</label>
												<div class="col-sm-10">
												<?php if(!empty($data['feenotinclude'])){ echo $data['feenotinclude'];}else{ echo '暂无信息';} ?>
												</div>
											</div>

											<div class="form-group">
												<!-- 预定须知 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">保险说明：
												</label>
												<div class="col-sm-10">
												<?php if(!empty($data['insurance'])){ echo $data['insurance'];}else{ echo '暂无信息';} ?>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">签证说明：</label>
												<div class="col-sm-10">
												<?php if(!empty($data['visa_content'])){ echo $data['visa_content'];}else{ echo '暂无信息';} ?>
												</div>
											</div>

											<div class="form-group">
												<!-- 购物自费 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">购物自费
													：</label>
												<div class="col-sm-10">
												<?php if(!empty($data['other_project'])){ echo $data['other_project'];}else{ echo '暂无信息';} ?>
												</div>
											</div>

										</div>
									</div>
								</form>
							</div>


							<!-- 参团须知 -->
							<div class="tab-pane" id="profile16" style="min-height: 400px;">
								<form action="" accept-charset="utf-8"
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post"
									id="linePriceForm" novalidate="novalidate">
									<div class="widget-body">
										<div id="registration-form">
											<div class="form-group">

												<!-- 特别约定 -->
												<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">特别约定：</label>
												<div class="col-sm-10">
												<?php if(!empty($data['special_appointment'])){ echo $data['special_appointment'];}else{ echo '暂无信息';} ?>
												</div>
											</div>
											<div class="form-group">
												<!-- 温馨提示 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">温馨提示
													：</label>
												<div class="col-sm-10">
												<?php if(!empty($data['beizu'])){ echo $data['beizu'];}else{ echo '暂无信息';} ?>
												</div>
											</div>

											<div class="form-group">
												<!-- 安全提示 -->
												<label class="col-sm-2 control-label no-padding-right "
													style="width: 120px; padding-top: 0px;" for="inputEmail3">安全提示
													：</label>
												<div class="col-sm-10">
												<?php if(!empty($data['safe_alert'])){ echo $data['safe_alert'];}else{ echo '暂无信息';} ?>
												</div>
											</div>

										</div>
									</div>
								</form>
							</div>

							<!-- 产品标签-->
							<div class="tab-pane" id="profile15" style="min-height: 400px;">
								<div class="widget-body">
									<div id="registration-form">

										<div class="form-group">
											<!-- 线路属性 -->
											<label class="col-sm-2 control-label no-padding-right "
												style="width: 120px; padding-top: 0px;" for="inputEmail3">产品标签：</label>
											<div class="col-sm-10" style="width: 70%;">
											<?php
											if (! empty ( $line_attr_arr )) {
												foreach ( $line_attr_arr as $attr ) :
													?>
											<p id="attr-list" style="float:left;margin-top:3px;">
											
											    <?php  echo '<span id="ds-236" class="line-lable" data-val="236" name="ds-lable" data="236">'.$attr ['name'].'</span>';?>
											
											</p>
											<?php
	
											endforeach
												;
											} else {
												echo '暂无内容';
											}
											?>
											</div>
										</div>

									</div>
								</div>
							</div>

							<!-- 管家培训-->
							<div class="tab-pane" id="profile17" style="min-height: 400px;">
								<form accept-charset="utf-8"
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post"
									id="apply_line_form" novalidate="novalidate"
									onsubmit="return ChecklineTrain();">
									<div class="widget-body">
										<input name="id" value="<?php echo $data['id'];?>" id="id"
											type="hidden" />
										<div class="form-group"
											style="margin-left: 2%; margin-top: 20px;">
										<?php if(!empty($train)){ ?>
										<table aria-describedby="editabledatatable_info"
												class="table table-bordered dataTable no-footer"
												style="width: 70%">
												<thead>
													<tr role="row">
														<th style="width: 45px; text-align: center">序号</th>
														<th style="width: 150px; text-align: center">问题</th>
														<th style="width: 150px; text-align: center">答案</th>
													</tr>
												</thead>
												<tbody class="train_table">
												<?php if(!empty($train)){ foreach ($train as $k=>$v){?>
												<tr class="train_len">
														<td style="text-align: center"><?php echo $k+1; ?><input
															type="hidden" name="train_id[]"
															value="<?php echo $v['id']; ?>" /></td>
														<td><?php echo $v['question']; ?></td>
														<td><?php echo $v['answer']; ?></td>
													</tr>
											<?php } }?>
											</tbody>
											</table>
									<?php }else{ echo '暂无培训内容';}?>
									</div>
									</div>
								</form>
								<?php if($data['status'] == 1) :?>
								<div class="button-list" style="margin-top: 50px;text-align: center;">
									<button class="button-but through-line" onclick="through(<?php echo $data['id'];?>,<?php echo $data['agent_rate_int']?>)">通过</button>
									<button class="button-but refuse-line" onclick="refuse(<?php echo $data['id']?>);">拒绝</button>
								</div>
								<?php endif;?>
							</div>
							    <!-- 抽奖礼品-->
					     	  	<div class="tab-pane" id="profile13" style="min-height:300px;">
									<div class="widget-body" style="width: 80%;">
									   <form action="<?php echo base_url()?>admin/b1/product/updatelineTrain" accept-charset="utf-8" method="post" 
											id="lineGiftForm" novalidate="novalidate" onsubmit="return ChecklineGift();"  >
											  <input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" /> 
										<div id="registration-form">
										   <div>
										        <input type="hidden" name="hasClass" id="hasClass" value="<?php if(!empty($gift)){ echo 1;}?>" >
										       <table  class="table table-striped table-hover table-bordered dataTable no-footer"> 
											    <thead class="gift_title">
											     <?php if(!empty($gift)){ ?>
											        <tr role="row">
											            <th style="width: 100px;text-align:center">礼品名称</th>
											            <th style="width: 80px;text-align:center" >有效期</th>
											            <th style="width: 60px;text-align:center" > 图片</th>
											            <th style="width: 40px;text-align:center" >数量 </th>
											            <th style="width: 80px;text-align:center" >价值</th>
											            <th style="width: 60px;text-align:center" >状态</th>
											          
											        </tr>
											       <?php }?>
											    </thead>
											 
											    <tbody class="gift_text">
									                               <?php if(!empty($gift)){ 
									                                		foreach ($gift as $k=>$v){	
									                                ?>
											           <tr class="gift_tr<?php echo $v['glid']; ?>">
												            <td style="text-align:center" class="sorting_1">
												            <?php echo $v['gift_name']; ?></td>
												            <td style="text-align:center" class=" "><input type="hidden"  value="<?php echo $v['id']; ?>"/><?php echo $v['starttime'].'至'.$v['endtime']; ?></td>
												            <td  style="text-align:center" class="center  "><img style="width:65px; height:65px; " src="<?php echo $v['logo']; ?>" ></td>
												            <td style="text-align:center" class=" "><?php if(!empty($v['gift_num'])){ echo $v['gift_num'];}else{ echo 0;}?>张</td>
												            <td style="text-align:center" class=" "><?php if(!empty($v['worth'])){ echo $v['worth'];}?></td>
												            <td style="text-align:center" class=" "><?php if($v['status']==0){ echo '上架';}elseif($v['status']==1){echo '下架';} ?></td>
											          </tr>
											        <?php } }else{ echo '暂无礼品';}?>
											</tbody>
										</table>
									    
									</div>		
									</div>
										<div class="registration-form" style="margin:30px 0px 0px 570px;">	
											<button class="btn btn-palegreen"  type="submit" id="save_line_gift" style="display:none">保存</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="form-box fb-body line-refuse">
	<div class="fb-content">
		<div class="box-title">
			<h4>退回线路申请</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="refuseForm" class="form-horizontal" >
				<div class="form-group" style="margin-left:0px;margin-right:20px;">
					<div class="fg-title">退回原因：<i>*</i></div>
					<div class="fg-input"><textarea name="refuse_remark" ></textarea></div>
				</div>
				<div class="form-group" style="margin-left:0px;margin-right:20px;">
					<input type="hidden" name="refuse_id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<div class="form-box fb-body line-through">
	<div class="fb-content">
		<div class="box-title">
			<h4>通过线路申请</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="throughForm" class="form-horizontal" >
				<div class="form-group" style="margin-left:0px;margin-right:20px;">
					<div class="fg-title">管家佣金：</div>
					<div class="fg-input"><input type="text" name="agent_rate" style="width: 80%;margin-right: 5px;" />元/人份</div>
				</div>
				<div class="form-group" style="margin-left:0px;margin-right:20px;">
					<input type="hidden" name="through_id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>


	<script
		src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
	<script	src="<?php echo base_url('assets/js/admin/jquery.b2_date.js')?>"></script>
	<script type="text/javascript">

(function(){


	var priceDate = null;

	function initProductPrice(){
		var url = '<?php echo base_url()?>admin/a/line/getProductPriceJSON';
		priceDate = new jQuery.priceDate({  record:'', renderTo:".cal-manager",comparableField:"day",
			url :url,
			params : function(){ 
				return jQuery.param( { "lineId":jQuery('#lineId').val()  ,"suitId":jQuery('#suitId').val()  ,"startDate":jQuery('#selectMonth').val() } );
			},
			monthTabChange : function(obj,date){
				jQuery('#selectMonth').val(date);	
			},
			dayFormatter:function(settings,data){
					var dayid= '';
					var number= '';
					var adultprice= '';
					var childprice= '';
					var childnobedprice = '';
					var groupId='';
					var oldprice='';
				
					if(data){
						dayid = data.dayid;
						childnobedprice = data.childnobedprice;
						adultprice=data.adultprice;
						childprice=data.childprice;
						number = data.number;
						oldprice = data.oldprice;
						
					}
					var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
					var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
					var html = '<div class="day"><span><label class="dayNum">'+settings.day+'</a>'+getCopyDown(settings.isLastRow)+'</label></span><span class="num"><input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input '+ flag +' value="'+dayid+'" type="hidden" name="dayid">空位<input style="text-align:right"  disabled="disabled"" readonly="readonly" type="text" '+ flag +' value="'+number+'" name="number">份</span></div>';
					//html = html + '<div class="cell-price">¥<input type="text" style="width: 52px;" '+(settings.disabled ? '':'placeholder="市场参考价"' )+' '+ flag +' value="'+refprice+'"  size="4" name="refprice">元</div>';
					html = html + '<div class="cell-price">¥<input type="text"  disabled="disabled"" readonly="readonly" style="width: 70px;"'+(settings.disabled ? '':'placeholder="成人价"' )+' '+ flag +' value="'+adultprice+'"  size="4" name="adultprice">元</div>';
		        	html = html +'<div class="cell-price">¥<input type="text"  disabled="disabled"" readonly="readonly" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩占床"' )+' '+ flag +' value="'+childprice+'" size="4" name="childprice">元</div>';
		        	html = html +'<div class="cell-price">¥<input type="text"  disabled="disabled"" readonly="readonly" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩不占床"' )+' '+ flag +' value="'+childnobedprice+'" size="4" name="childnobedprice">元</div>';
		        	html = html +'<div class="cell-price">¥<input type="text"  disabled="disabled"" readonly="readonly" style="width: 70px;" '+(settings.disabled ? '':'placeholder="老人价"' )+' '+ flag +' value="'+oldprice+'" size="4" name="oldprice">元</div>';
		        	return html;
				},dayFormatter1:function(settings,data){
					var dayid= '';
					var number= '';
					var adultprice= '';
					var childprice= '';
					var childnobedprice = '';
					var groupId='';
					var oldprice='';
				
					if(data){
						dayid = data.dayid;
						childnobedprice = data.childnobedprice;
						adultprice=data.adultprice;
						childprice=data.childprice;
						number = data.number;
						oldprice = data.oldprice;
				
					}
					var flag = ( settings.disabled ? ' class="disableText" disabled="disabled" readonly="readonly"' : 'class="price"' );
					var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled" readonly="readonly"' : 'class="day"' );
					var html = '<div class="day"><span><label class="dayNum">'+settings.day+'</a>'+getCopyDown(settings.isLastRow)+'</label></span><span class="num"><input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day[]"><input '+ flag +' value="'+dayid+'" type="hidden" name="dayid">数量<input style="text-align:right" type="text"  disabled="disabled" readonly="readonly" '+ flag +' value="'+number+'" name="number">份</span></div>';
					//html = html + '<div class="cell-price">¥<input type="text" style="width: 52px;" '+(settings.disabled ? '':'placeholder="市场参考价"' )+' '+ flag +' value="'+refprice+'"  size="4" name="refprice[]">元</div>';
					html = html + '<div class="cell-price">¥<input type="text"  disabled="disabled" readonly="readonly" style="width: 70px;" '+ flag +' value="'+adultprice+'"  placeholder="套餐价格" size="4" name="adultprice">元</div>';
		        	html = html +'<input type="hidden"  disabled="disabled" readonly="readonly" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩占床"' )+' '+ flag +' value="'+childprice+'" size="4" name="childprice">';
		        	html = html +'<input type="hidden"  disabled="disabled" readonly="readonly" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩不占床"' )+' '+ flag +' value="'+childnobedprice+'" size="4" name="childnobedprice">';
		        	html = html +'<input type="hidden"  disabled="disabled" readonly="readonly" style="width: 70px;" '+(settings.disabled ? '':'placeholder="老人价"' )+' '+ flag +' value="'+oldprice+'" size="4" name="oldprice">';
		        	return html;
		        	
				}
			});
		
		
	}
	initProductPrice()

})();

//切换儿童、老人、特殊的说明
function switchover(suitId){
	jQuery.ajax({ type : "POST",data :'suitId='+suitId,url : "<?php echo base_url()?>admin/a/line/switchover_desc",
		success : function(data) {
			if(data!='' && data!='0'){
				var obj = eval('(' + data + ')');
				$("#child_description").html(obj.child_description);
				$("#old_description").html(obj.old_description);
				$("#special_description").html(obj.special_description);
				$("#child_nobed_description").html(obj.child_nobed_description);
				$("input[name='unit']").val(obj.unit);
			}
		}
	});
}


	//退回线路申请
	var refuseObj = $('#refuseForm');
	function refuse(lineid) {
		refuseObj.find('textarea[name=refuse_remark]').val('');
		refuseObj.find('input[name=refuse_id]').val(lineid);
		$('.line-refuse,.mask-box').fadeIn(500);
	}
	$('#refuseForm').submit(function(){
		$.ajax({
			url:'/admin/a/lines/line/refuse',
			type:'post',
			data:{lineid:refuseObj.find('input[name=refuse_id]').val(),refuse_remark:refuseObj.find('textarea[name=refuse_remark]').val()},
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$('.button-list').hide();
					alert(data.msg);
					closebox();
				} else {
					alert(data.msg);
				}
			}
		});
		return false;
	})
	//通过线路申请
	var throughObj = $('#throughForm');
	function through(lineid ,agent_rate) {
		throughObj.find('input[name=agent_rate]').val(agent_rate);
		throughObj.find('input[name=through_id]').val(lineid);
		$('.line-through,.mask-box').fadeIn(500);
	}
	throughObj.submit(function(){
		$.ajax({
			url:'/admin/a/lines/line/through',
			type:'post',
			data:{lineid:throughObj.find('input[name=through_id]').val(),agent_rate:throughObj.find('input[name=agent_rate]').val()},
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$('.button-list').hide();
					alert(data.msg);
					closebox();
				} else {
					alert(data.msg);
				}
			}
		});
		return false;
	})
</script>