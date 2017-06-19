<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="col_box">
<!-- Head -->
<head>
<meta charset="utf-8" />
<title>后台产品详情页</title>
<meta name="description" content="Dashboard" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png');?>" type="image/x-icon">

<!--Basic Styles-->
<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
<link id="bootstrap-rtl-link" href="" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/weather-icons.min.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/hm.widget.css');?>" rel="stylesheet" />
<!--Fonts-->
<link href="<?php echo base_url('assets/css/fonts.css');?>" rel="stylesheet" type="text/css">
<!--Beyond styles-->
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/demo.min.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/typicons.min.css');?>"rel="stylesheet" />
<link href="" rel="stylesheet" />
<link id="skin-link" href="" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/b2_style.css');?>" rel="stylesheet" />
<!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
<script src="<?php echo base_url('assets/js/skins.min.js');?>"></script>
<!--Basic Scripts-->
<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<!--Beyond Scripts-->
<script src="<?php echo base_url('assets/js/beyond.min.js');?>"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>

<link href="<?php echo base_url('assets/css/product.css')?>" rel="stylesheet" />
<style type="text/css">
.disable .dayNum, .priceDate .dayNum{ color: #59A8EE;}  
.tabs li{ margin-left: 0;}
.priceDate .disableText{color: #40B554;}
.priceDate .price{ background: none; border: none;color: #40B554; padding: 4px;}
.priceDate .num input{ border: none;}
.priceDate th{ border: 1px solid #adbec6;}
table{ width: 100%;;}
.col_box{ height: 100%; display: -webkit-box; display: -webkit-flex; display: flex; -webkit-box-orient: vertical; -webkit-flex-flow: column; flex-flow: column; }
html,body{ min-height: 100%;}
.widget-body .form-group label{font-weight:bolder}
.line-lable{color:#15b000;height:26px;line-height:26px;position:relative;background:#edf6fa;border:1px solid #d7e4ea;padding:6px 20px 6px 12px;margin-right:2px;vertical-align:middle}
.line-lable a{display:block;width:24px;height:32px;position:absolute;top:0;right:0;cursor:pointer;text-align:center;font-size:21px;font-weight:700;color:#000;text-shadow:0 1px 0 #fff;filter:alpha(opacity=20);opacity:.2}
#profile14 ul{margin-left:-40px}
.cal-manager .add-package{display:none}
.del-package{display:none}
#attr-list{line-height:38px}
#registration-form img{ padding:0 5px;}
.bodyBox{ width:1200px; margin: 0 auto;min-height: 100%;}
.widget-body{ padding: 20px; background: #fff; border:1px solid #ddd; border-top: none}
.widget{ margin: 0;}
.col-sm-10{  line-height: 30px;;}
.priceDate td{ background: #fffde6; border: 1px solid #adbec6;}
.priceDate .disable{ background-image: none; background: #fffef7;}
.priceDate .disableText{ background: none; padding: 4px; text-align: right;}
.priceDate .num{ background: none;}
.thus_disable{ background: #099}
.widget-body .form-group label{ text-align: right; height: 30px; line-height: 30px; margin: 0;}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{border-top: 2px solid #09c; background: #fff; border-left: 1px solid #ddd; border-right: 1px solid #ddd;}
.page-breadcrumbs{ border:1px solid #ddd; border-top: none; padding-left:10px;}
.checkbox{ padding-top: 0 !important;}
.reserve_record dl{    margin-top: 0; margin-bottom: 0px;}

.reserve_table td .lprice {
  color:#F40;
}

i{ font-style:initial;}
.reserve_record dl{ border-bottom:1px solid #BCD8F4 }
.singleRow{ background:#fff;}
.reserve_table .bg_blue{ background:#fff;}
.priceDate .disable{ background:#fff;}
.priceDate td{ background:#fff;}
.reserve_table .bg_blue{}
.reserve_record dl {
    border-left: #BCD8F4 solid 1px;
    border-right: #BCD8F4 solid 1px;
    border-bottom: #96CDFA solid 2px;
}
.reserve_table tr td{
    border-left: #BCD8F4 solid 1px;
    border-right: #BCD8F4 solid 1px;
    border-bottom: #96CDFA solid 2px;
}
</style>
</head>
<body class="col_box">
<div class="navbar" style=" display:none">
	<div class="navbar-inner">
		<div class="navbar-container">
		<!-- Navbar Barnd -->
			<div class="navbar-header pull-left">
				<a href="#" class="navbar-brand"> <small> Ubang.com </small></a>
			</div>
			<div class="sidebar-collapse" id="sidebar-collapse">
				<i class="collapse-icon fa fa-bars"></i>
			</div>
			<div class="navbar-header pull-right">
			</div>
		</div>
	</div>
</div>
<div class="main-container container-fluid bodyBox " >
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs shadow">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i><a href="<?php echo site_url('/admin/b2/order/index')?>">首页</a></li>
		<li>申请售卖权</li>
		<li class="active">产品详情</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<div class="widget flat radius-bordered shadow">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active"><a href="#home11" data-toggle="tab"> 基础信息 </a></li>
					<li class=""><a class="routting" href="#profile12"	data-toggle="tab" id="routting" name="rout"> 行程安排 </a></li>
					<li class=""><a href="#profile10" data-toggle="tab"> 报价 </a></li>
					<li class=""><a href="#profile14" data-toggle="tab"> 费用说明 </a></li>
					<li class=""><a href="#profile16" data-toggle="tab">参团须知 </a></li>
					<li class=""><a href="#profile15" data-toggle="tab">产品标签 </a></li>
					<li class="" id="expert_training"><a href="#profile17"data-toggle="tab"> 管家培训 /成为管家</a></li>
					<?php if(!empty($gift)){ ?>
					<li class="" id="supplierGift"><a href="#profile13" data-toggle="tab"> 抽奖礼品</a>
					<li><?php }?>
					<label class="col-sm-2 control-label no-padding-right "	for="inputEmail3" style="width: 369px; padding-top: 8px; color: red; font-size: 12px">提示:请在“管家培训”页面申请管家资质</label>
				</ul>
				<div class="tab-content tabs-flat" style="padding: 0px 12px;">
					<!-- 基础信息 -->
					<div class="tab-pane active" id="home11" style="height: 650px;">
						<form accept-charset="utf-8" class="form-horizontal bv-form" action="" method="post" id="linebascForm">
							<input name="id" value="<?php if(!empty($data['id'])){echo $data['id']; }?>" id="id" type="hidden" />
							<div class="">
								<div id="registration-form">
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " for="inputEmail3" style="width: 120px; padding-top: 0px;">线路名称：</label>
										<div class="col-sm-10">
											<?php if(!empty($data['brand'])){ echo $data['brand'] ; ?>
											<span style="font-size: 14px;font-family:宋体;color:navy">·</span><?php }?>
											<?php echo $data['linename'];?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">线路副标题：</label>
										<div class="col-sm-10">
											<?php echo $data['linetitle'];?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;">出发地：</label>
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
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">目的地：</label>
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

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;">上车地点：</label>
										<div class="col-sm-10">
									             <?php  if(!empty($carAddress)){
							                                         foreach ($carAddress as $key => $value) {
							                                                echo $value['on_car'].'&nbsp;&nbsp;&nbsp;&nbsp;'; 
							                                         }
							                                     }?>
										</div>
									</div>
									<?php  if(!empty($themeid)){ ?>
									<div class="form-group">
										<!-- 主题游 -->
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">主题游：</label>
										<div class="col-sm-10" style="width: 70%;">
											<span id="attr-list">
											<?php echo $themeid[0]['name']; ?>
											</span>
										</div>
									</div>
									<?php }?>
									<div class="form-group">
										<!-- 线路特色 -->
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">线路特色：</label>
										<div class="col-sm-10">
											<?php if(!empty($data['features'])){ echo htmlspecialchars_decode($data['features']); }?>
										</div>
									</div>
									<!-- <button id="apply_line_form" type="submit" class="btn btn-blue">成为管家</button> -->
								</div>
							</div>
						</form>
					</div>
					<!-- 行程安排 -->
					<div class="tab-pane" id="profile12">
						<form action="" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-message="This value is not valid" class="form-horizontal bv-form" name="fromRout" onsubmit="return CheckRouting();" method="post" id="lineDayForm" novalidate>
							<div class="" id="rout_line">
								<?php  $num = $data ['lineday'];for($i = 0; $i < $num; ++ $i) { ?>
								<input name="lineday" id="lineday" value="<?php if(!empty($data ['lineday'])){ echo $data ['lineday'];}?>" id="id" type="hidden" />
								<div id="registration-form">
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right "style="width: 120px; padding-top: 0px; font-size: 18px;"for="inputEmail3">
第
										<?php echo $i+1; ?>
										天：</label>
										<div class="col-sm-10">
											<?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?>
										</div>
									</div>
									<?php if(!empty($rout[$i]['transport'])&& $rout[$i]['transport']!='无'){  ?>
									<div class="form-group">
										<!-- 往返交通 -->
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">城市间交通：</label>
										<div class="col-sm-10">
											<div class="col-lg-1 col-sm-1 col-xs-1" style="width: auto; padding: 0px; line-height: 7px;">
												<div class="checkbox">
													<label style="padding: 0px; text-align: left; font-weight: 500;">
													<?php if(!empty($rout[$i]['transport'])){ echo $rout[$i]['transport'];} ?>
													</label>
												</div>
											</div>
										</div>
									</div>
									<?php }?>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " style="width: 118px; padding-top: 0px;" for="inputEmail3">用餐：</label>
										<div class="form-inline">
											<div class="checkbox " style="padding-top: 0px;">
												<label style="padding: 0px; text-align: left; width: auto; padding-right: 10px;">
早餐/
												<?php if(!empty($rout[$i])){ if($rout[$i]['breakfirsthas']==1){ if(!empty($rout[$i]['breakfirst'])){ echo $rout[$i]['breakfirst'];}else{ echo '有';}}}else{ echo '不含';} ?>
												</label>
											</div>
											<div class="checkbox" style="padding-top: 0px;">
												<label style="padding: 0px; text-align: left; width: auto; padding-right: 10px;">
午餐/
												<?php if(!empty($rout[$i])){ if($rout[$i]['lunchhas']==1){ if(!empty($rout[$i]['lunch'])){echo $rout[$i]['lunch'];}else{echo '有'; }}}else{echo '不含';} ?>
												</label>
											</div>
											<div class="checkbox" style="padding-top: 0px;">
												<label style="padding: 0px; text-align: left; width: auto; padding-right: 10px;">
晚餐/
												<?php if(!empty($rout[$i])){ if($rout[$i]['supperhas']==1){ if(!empty( $rout[$i]['supper'])){ echo $rout[$i]['supper'];}else{ echo '有';}}}else{echo '不含';}?>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">住宿：</label>
										<div class="col-sm-10">
											<?php if(!empty($rout[$i])){ echo $rout[$i]['hotel'];} ?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">行程：</label>
										<div class="col-sm-10">
											<?php if(!empty($rout[$i])){ echo $rout[$i]['jieshao'];} ?>
										</div>
									</div>
									<div class="form-group" style="overflow: inherit;">
										<label class="col-sm-2 control-label no-padding-right " style="width: 70px; padding-top: 0px;" for="inputEmail3"></label>
										<div class="col-sm-10" style="width:100%; height: auto;">
											<ul>
												<?php
													if (! empty ( $rout [$i] )) {
													$pic_arr = explode ( ';', $rout [$i] ['pic'] );
													foreach ( $pic_arr as $k => $v ) {
													if (! empty ( $v )) {
												?>
												<li style="margin: 5px 5px 0px 0px; float: left;">
												<img alt="" style="width: 180px; height: 160px;" src="<?php echo $v; ?>">
												</li>
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
					<input type="hidden" value="<?php echo date('Y-m-01', strtotime('0 month'));?>" id="selectMonth" name="selectMonth" />
					<div class="tab-pane" id="profile10">
						<form action="" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="linePriceForm" novalidate>
							<input name="lineId" type="hidden" id="lineId" value="<?php echo $data['id'];?>" />
							<div class="" style="padding: 0;">
								<div id="registration-form">
									<div id="day_price">
										<div style="margin-top: 10px;">
										       <div style="margin-top:10px;" >
			                                                                                      <span>定金:</span>
			                                                                                       <?php if(!empty($line_aff[0])){ echo $line_aff[0]['deposit'];}else{ echo 0;} ?>
			                                                                                      <span>元/人份</span>

			                                                                                      <span style="padding-left: 25px;">提前:</span>
			                                                                                     <?php if(!empty($line_aff[0])){ echo $line_aff[0]['before_day'];}else{ echo 0;} ?>
			                                                                                      <span>天交清团费</span>
			                                                                                  </div>
										<!-- 	<div style="margin-top: 20px;">
											<span>成人佣金:</span>
											<input style="padding-left: 5px; width: 60px; background: #f8f8f8" class="price_input" type="text" readonly disabled="disabled" value="<?php //echo $data['agent_rate_int'];?>" id="agent_rate" class="form-control text-width" name="agent_rate" />
											<span>元/人份</span>
										</div>
										<div style="margin-top: 20px;">
											<span>小童佣金:</span>
											<input style="padding-left: 5px; width: 60px; background: #f8f8f8" class="price_input" type="text" readonly disabled="disabled" value="<?php //echo $data['agent_rate_child'];?>" id="agent_rate" class="form-control text-width" name="agent_rate" />
											<span>元/人份</span>
										</div> -->
											<div style="margin-top: 15px;">
												<span>备注:</span>
											</div>
											<div style="margin-top: 20px;">
												<span class=" col_price">儿童占床说明 :</span>
												<span id="child_description"><?php if(!empty($data['child_description'])){ echo $data['child_description']; }else{echo '暂无内容'; } ?>
												</span>
											</div>
											<div style="margin-top: 10px;">
												<span class=" col_price">儿童不占床说明 :</span>
												<span id="child_nobed_description"><?php if(!empty($data['child_nobed_description'])){ echo $data['child_nobed_description']; }else{echo '暂无内容'; }?>
												</span>
											</div>
											<div style="margin-bottom: 30px;">
												<span class=" col_price">特殊人群说明:</span>
												<span id="special_description"><?php if(!empty($data['special_description'])){ echo $data['special_description'];}else{echo '暂无内容'; } ?>
												</span>
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
						<form action="" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="linePriceForm" novalidate>
							<div class="">
								<div id="registration-form">
									<div class="form-group">
										<!-- 费用包含 -->
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px;" for="inputEmail3">费用包含：</label>
										<div class="col-sm-10">
											<?php if(!empty($data['feeinclude'])){ echo $data['feeinclude'];}else{ echo '暂无信息'; } ?>
										</div>
									</div>
									<div class="form-group">
										<!-- 费用不包含 -->
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">费用不含：</label>
										<div class="col-sm-10">
											<?php if(!empty($data['feenotinclude'])){ echo $data['feenotinclude'];}else{ echo '暂无信息';} ?>
										</div>
									</div>
									<div class="form-group">
										<!-- 预定须知 -->
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">保险说明：
										</label>
										<div class="col-sm-10">
											<?php if(!empty($data['insurance'])){ echo $data['insurance'];}else{ echo '暂无信息';} ?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">签证说明：</label>
										<div class="col-sm-10">
											<?php if(!empty($data['visa_content'])){ echo $data['visa_content'];}else{ echo '暂无信息';} ?>
										</div>
									</div>
									<div class="form-group">
										<!-- 购物自费 -->
										<label class="col-sm-2 control-label no-padding-right "	style="width: 120px; padding-top: 0px;" for="inputEmail3">购物自费：</label>
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
						<form action="" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="linePriceForm" novalidate>
							<div class="">
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
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">温馨提示：</label>
										<div class="col-sm-10">
											<?php if(!empty($data['beizu'])){ echo $data['beizu'];}else{ echo '暂无信息';} ?>
										</div>
									</div>
									<div class="form-group">
										<!-- 安全提示 -->
										<label class="col-sm-2 control-label no-padding-right " style="width: 120px; padding-top: 0px;" for="inputEmail3">安全提示：</label>
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
						<div class="">
							<div id="registration-form">
								<div class="form-group">
									<!-- 线路属性 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px; height: 40px; line-height: 40px; padding-top: 0px;" for="inputEmail3">产品标签：</label>
									<div class="col-sm-10" style="width: 70%;">
										<?php
if (! empty ( $line_attr_arr )) {
foreach ( $line_attr_arr as $attr ) :
?>
										<span id="attr-list">
										<?php  echo '<span id="ds-236" class="line-lable" data-val="236" name="ds-lable" data="236">
										'.$attr ['name'].'</span>';?>
											</span>
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
						<form accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="apply_line_form" novalidate>
							<div class="">
								<input name="id" value="<?php echo $data['id'];?>" id="id"	type="hidden" />
								<div class="control-label " for="inputEmail3" style="color: red; font-size: 12px; text-align: left;">
									当您售卖此条线路时将遇到游客常见问题，供应商提供了参考答案，请您认真阅读牢记后，再行申请售卖权。
								</div>
								<div class="form-group" style="margin-left: 2%; margin-top: 20px;">
									<?php if(!empty($train)){ ?>
									<table aria-describedby="editabledatatable_info" class="table table-bordered dataTable no-footer" style="width: 70%">
									<thead>
									<tr role="row">
										<th style="width: 45px; text-align: center">
											序号
										</th>
										<th style="width: 150px; text-align: center">
											问题
										</th>
										<th style="width: 150px; text-align: center">
											答案
										</th>
									</tr>
									</thead>
									<tbody class="train_table">
									<?php if(!empty($train)){ foreach ($train as $k=>
									$v){?>
									<tr class="train_len">
										<td style="text-align: center">
											<?php echo $k+1; ?>
											<input type="hidden" name="train_id[]" value="<?php echo $v['id']; ?>" />
										</td>
										<td>
											<?php echo $v['question']; ?>
										</td>
										<td>
											<?php echo $v['answer']; ?>
										</td>
									</tr>
									<?php } }?>
									</tbody>
									</table>
									<?php }else{ echo '暂无培训内容';}?>
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox" style="float: left;">
									<label><input type="checkbox" checked="true" id="read_profile"><span class="text">我已阅读以上培训内容及佣金比例并承诺相关责任义务</span>
									</label>
								</div>
								<button type="submit" class="btn btn-blue" style="margin-left: 30px;" id="btn_submit">成为管家</button>
							</div>
						</form>
					</div>
					<!-- 抽奖礼品-->
					<div class="tab-pane" id="profile13" style="min-height:300px;">
						<div class="widget-body" style="width: 80%;">
							<form action="<?php echo base_url()?>
								admin/b1/product/updatelineTrain" accept-charset="utf-8" method="post" 
									id="lineGiftForm" novalidate onsubmit="return ChecklineGift();"  >
								<input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" />
								<div id="registration-form">
									<div>
										<input type="hidden" name="hasClass" id="hasClass" value="<?php if(!empty($gift)){ echo 1;}?>" >
										<table class="table table-striped table-hover table-bordered dataTable no-footer">
										<thead class="gift_title">
										<?php if(!empty($gift)){ ?>
										<tr role="row">
											<th style="width: 100px;text-align:center">
												礼品名称
											</th>
											<th style="width: 80px;text-align:center">
												有效期
											</th>
											<th style="width: 60px;text-align:center">
												 图片
											</th>
											<th style="width: 40px;text-align:center">
												数量
											</th>
											<th style="width: 80px;text-align:center">
												价值
											</th>
											<th style="width: 60px;text-align:center">
												状态
											</th>
										</tr>
										<?php }?>
										</thead>
										<tbody class="gift_text">
										<?php if(!empty($gift)){ 
			                                		foreach ($gift as $k=>
										$v){	
			                                ?>
										<tr class="gift_tr<?php echo $v['glid']; ?>
											">
											<td style="text-align:center" class="sorting_1">
												<?php echo $v['gift_name']; ?>
											</td>
											<td style="text-align:center" class=" ">
												<input type="hidden" value="<?php echo $v['id']; ?>"/><?php echo $v['starttime'].'至'.$v['endtime']; ?>
											</td>
											<td style="text-align:center" class="center ">
												<img style="width:65px; height:65px; " src="<?php echo $v['logo']; ?>" >
											</td>
											<td style="text-align:center" class=" ">
												<?php if(!empty($v['gift_num'])){ echo $v['gift_num'];}else{ echo 0;}?>
												张
											</td>
											<td style="text-align:center" class=" ">
												<?php if(!empty($v['worth'])){ echo $v['worth'];}?>
											</td>
											<td style="text-align:center" class=" ">
												<?php if($v['status']==0){ echo '上架';}elseif($v['status']==1){echo '下架';} ?>
											</td>
										</tr>
										<?php } }else{ echo '暂无礼品';}?>
										</tbody>
										</table>
									</div>
								</div>
								<div class="registration-form" style="margin:30px 0px 0px 570px;">
									<button class="btn btn-palegreen" type="submit" id="save_line_gift" style="display:none">保存</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script src="<?php echo base_url('assets/js/admin/jquery.b2_date.js')?>"></script>
<script type="text/javascript">
(function(){
	
	$('.del-package').remove();
	$('#apply_line_form').submit(function(){
	$("#btn_submit").attr("disabled", true);
	if($("#read_profile").attr('checked')){
		$.post("<?php echo base_url('admin/b2/line_apply/apply_line_operator');?>",{'apply_line_id':<?php if(!empty($data['id'])){echo $data['id']; }?>},
			function(data) {
				data = eval('('+data+')');
				if (data.status == 200) {
					alert(data.msg);
					window.opener.location.reload();
					window.close();
				} else {
					alert(data.msg);
					$("#btn_submit").attr("disabled", false);
				}
			}	
		);
		
	}else{
		alert('请确认已经阅读说明');
		$("#btn_submit").attr("disabled", false);
	}
	
return false;
});
  var priceDate = null;

  function initProductPrice(){
     var url = '<?php echo base_url()?>admin/b2/pre_order/getProductPriceJSON';
      priceDate = new jQuery.calendarTable({  record:'', renderTo:".cal-manager",comparableField:"day",
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
          var before_day='';
          var hour='';
          var minute='';
          var room_fee='';
          var agent_rate_childno='';
          var agent_room_fee='';
          var agent_rate_int='';
          var agent_rate_child='';
          var time='';
          if(data){
            dayid = data.dayid;
            childnobedprice = data.childnobedprice;
            adultprice=data.adultprice;
            childprice=data.childprice;
            number = data.number;
            oldprice = data.oldprice;
            room_fee=data.room_fee;
            agent_rate_childno=data.agent_rate_childno;
            agent_room_fee=data.agent_room_fee;
            before_day=data.before_day;
            hour=data.hour;
            minute=data.minute;
            agent_rate_int=data.agent_rate_int;
            agent_rate_child=data.agent_rate_child;
            var str0='<span style="color:#F40" >';
            str1='<span>';
            time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';
            
          }
          settings.disabled;
          var  flag=true;
          var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
          var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
          html += flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span class="lprice">'+adultprice+"</span><span>元</span>")+'</p>':'';
          html+= flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_int+"</span><span>元</span>")+'</p>':'';

          html+= flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'';

          html+=  flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childnobedprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_childno+"</span><span>元</span>")+'</p>':'';
          
          html+=flag ? '<p class="singleRow" >'+(''==number?'':'<span class="lprice" >'+number+"</span><span>份</span>")+'</p>': '';

          html+=flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span class="lprice" >'+room_fee+"</span><span>元</span>")+'</p>': '';
          html+=flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_room_fee+"</span><span>元</span>")+'</p>':'';

          html+=flag ? '<p class="singleRow" >'+(''==time?'':time)+'</p>':'';

          return html;
        },dayFormatter1:function(settings,data){
          var dayid= '';
          var number= '';
          var adultprice= '';
          var childprice= '';
          var childnobedprice = '';
          var groupId='';
          var oldprice='';
          var before_day='';
          var hour='';
          var minute='';
          var room_fee='';
          var agent_rate_childno='';
          var agent_room_fee='';
          var agent_rate_int='';
          var agent_rate_child='';
           var time='';
          if(data){
            dayid = data.dayid;
            childnobedprice = data.childnobedprice;
            adultprice=data.adultprice;
            childprice=data.childprice;
            number = data.number;
            oldprice = data.oldprice;
            room_fee=data.room_fee;
            agent_rate_childno=data.agent_rate_childno;
            agent_room_fee=data.agent_room_fee;
            before_day=data.before_day;
            hour=data.hour;
            minute=data.minute;
            agent_rate_int=data.agent_rate_int;
            agent_rate_child=data.agent_rate_child;
            var str0='<span style="color:#F40" >';
            str1='<span>';
            time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';
          }

          settings.disabled;
          var  flag=true;
          var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
          var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
          html += flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span class="lprice">'+adultprice+"</span><span>元</span>")+'</p>':'';
          html+= flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_int+"</span><span>元</span>")+'</p>':'';

          html+= flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'';

          html+=  flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childnobedprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_childno+"</span><span>元</span>")+'</p>':'';
          
          html+=flag ? '<p class="singleRow" >'+(''==number?'':'<span class="lprice" >'+number+"</span><span>份</span>")+'</p>': '';

          html+=flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span class="lprice" >'+room_fee+"</span><span>元</span>")+'</p>': '';
          html+=flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_room_fee+"</span><span>元</span>")+'</p>':'';

          html+=flag ? '<p class="singleRow" >'+(''==time?'':time)+'</p>':'';

          return html;
              
        }
      });
    
    
  }
  initProductPrice()
})();
</script>