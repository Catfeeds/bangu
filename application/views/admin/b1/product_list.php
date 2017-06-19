<!DOCTYPE html>
<!--
BeyondAdmin - w_1200 Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 1.0.0
Purchase: http://wrapbootstrap.com
-->
<html xmlns="http://www.w3.org/1999/xhtml">
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
    <link href="<?php echo base_url('assets/css/typicons.min.css');?>" rel="stylesheet" />
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
    .form-group label{ font-weight: bold;}
    
    </style>
</head>
<!-- /Head -->
<!-- Body -->
<style type="text/css">
	.col-sm-10 img{ margin-right: 5px;}
</style>
<body>
      <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            Ubang.com
                        </small>
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
    </div>
    <!-- /Navbar -->
    <!-- Main Container -->
    <div class="main-container container-fluid">
     

<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a href="<?php echo site_url('admin/b1/home')?>">首页</a></li>
		<li ><a href="<?php echo site_url('admin/b1/product')?>">产品管理</a></li><li class="active">产品详情</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body" >
	<?php if(!empty($status)&& $status==1){ ?>
		<div class="widget-main">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active"><a href="#home11" data-toggle="tab"> 基础信息 </a></li>
					<li class=""><a href="#profile10" data-toggle="tab"> 设置价格 </a></li>
					<li class=""><a class="routting"   href="#profile12" data-toggle="tab" id="routting" name="rout"> 行程安排 </a></li>

				</ul>
				<div class="tab-content tabs-flat" style="padding: 0px 12px">
					<!-- 基础信息 -->
					
					
					<div class="tab-pane active" id="home11">
						<form action="" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form" onsubmit="return CheckLine();" method="post" 
						id="lineInfo" novalidate="novalidate">		
						<input name="id" value="<?php  if(!empty($data['id'])){echo $data['id']; }?>" id="id" type="hidden" />
						<div class="widget-body">
							<div id="registration-form">
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " for="inputEmail3" style="width: 120px;padding-top:0px;">线路名称：</label> 
									<div class="col-sm-10"><?php echo $data['linename'];?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " style="width: 122px;padding-top:0px;"for="inputEmail3">供应商线路名称：</label> 
									<div class="col-sm-10">
										<?php echo $data['nickname'];?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">线路副标题：</label> 
									<div class="col-sm-10"><?php echo $data['linetitle'];?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;">出发地：</label>
									<div class="col-sm-10">									
												<?php foreach ($user_shop as $item):
												if($data['startcity']==$item['id']){ echo $item['cityname'].'&nbsp;&nbsp;';}
												endforeach;
												?>										
									</div>
								</div>
								<div class="form-group">
									<!-- 目的地 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">目的地选择：</label>
									<div class="col-sm-10" style="width: 70%;">		
										<span id="ds-list">	
											<?php foreach ($overcity_arr as $overcity):
										    	echo $overcity['name'].'&nbsp;&nbsp;';
											endforeach;?>						    
										</span>
									</div>
								</div>
								<div class="form-group">
									<!-- 线路属性 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">线路属性：</label>
									<div class="col-sm-10" style="width: 70%;">
										
										<span id="attr-list">
											<?php foreach ($line_attr_arr as $attr):
										    	echo $attr['name'].'&nbsp;&nbsp;';
											endforeach; ?>

										</span>
									</div>
								</div>
								<div class="form-group">
									<!-- 旅游天数 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">行程天数：</label>
								    <div class="col-sm-10">
										<div class="form-inline ">
											<?php echo $data['lineday'];?><span>天</span>
											<?php echo $data['linenight'];?><span>晚</span>
										</div>
									</div>
									
								</div>
								<div class="form-group">
									<!-- 提前天数 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">提前天数：</label> 
									<div class="col-sm-10">
										<div class="form-inline ">
											<span >提前</span>
											<?php echo $data['linebefore'];?>
											<span >天报名</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<!-- 首付比例  尾款提前天数 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">首付比例：</label>
									<div class="col-sm-10">
										<div class="input-group small-width">
											<?php echo $data['first_pay_rate'];?>%
											
										</div>
									</div>
								</div>
							   <div class="form-group">
									<!-- 酒店星级 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">酒店星级概述：</label>
									<div class="col-sm-10">									
                             			<?php 
                             			  echo $data['hotel_start']; 
                             			?>
									</div>
								</div>
								
								<div class="form-group">
									<!-- 往返交通 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;" for="inputEmail3">交通工具：</label>
									<div class="col-sm-10">									
                             			<?php  
                             			  echo $data['transport'];
                             			?>
									</div>
								</div>

								<div class="form-group">
									<!-- 儿童标准 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">儿童标准：</label> 
									<div class="col-sm-10">
										<?php echo $data['childrule'];?>
									</div>	
								</div>
								<div class="form-group">
									<!-- 线路特色 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">线路特色：</label>
									<div class="col-sm-10">
										<?php echo $data['features'];?>
									</div>
								</div>
								<div class="form-group">
									<!-- 费用包含 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;" for="inputEmail3">费用包含：</label>
									<div class="col-sm-10">
									<?php if(!empty($data['feeinclude'])){ echo $data['feeinclude'];} ?>
									</div>
								</div>
								<div class="form-group">
									<!-- 费用不包含 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">费用不含：</label>
									<div class="col-sm-10">
									<?php if(!empty($data['feenotinclude'])){ echo $data['feenotinclude'];} ?>
									</div>
								</div>
								
								<div class="form-group">
									<!-- 接待标准 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">接待标准：</label>
									<div class="col-sm-10">
									<?php if(!empty($data['hotel_start'])){ echo $data['hotel_start'];} ?>
									</div>
								</div>
								<div class="form-group">
									<!-- 预定须知 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">预定须知 ：</label>
									<div class="col-sm-10">
									<?php if(!empty($data['book_notice'])){ echo $data['book_notice'];} ?>
									</div>
								</div>
								<div class="form-group">
									<!-- 签证须知 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">签证须知 ：</label>
									<div class="col-sm-10">
									<?php if(!empty($data['visa_content'])){ echo $data['visa_content'];} ?>
									</div>
								</div>
								
								<div class="form-group">
									<!-- 行程文件-->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">行程文件 ：</label>
									<div class="col-sm-10">
									 <a href="<?php if(!empty($data['linedoc'])){ echo $data['linedoc'];} ?>"><?php if(!empty($data['linedoc'])){ echo "行程文件";}else{ echo '暂无下载';}?></a>
									</div>
								</div>
								<div class="form-group">
									<!-- 产品说明书-->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;" for="inputEmail3">产品说明书 ：</label>
									<div class="col-sm-10">
									 <a href="<?php if(!empty($data['sell_direction'])){ echo $data['sell_direction'];} ?>"><?php if(!empty($data['sell_direction'])){ echo '产品说明书';}else{ echo '暂无下载';}?></a>
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
					<!-- 设置价格 -->
					<input type="hidden" value="<?php echo date('Y-m-01', strtotime('0 month'));?>" id="selectMonth" name="selectMonth" />
					<div class="tab-pane" id="profile10">
						<form action="" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post" 
						id="linePriceForm" novalidate="novalidate">
						<input name="lineId" type="hidden" id="lineId" value="<?php echo $data['id'];?>" />
						<div class="widget-body" style="padding: 0;">
							<div id="registration-form">
								<div id="day_price">
									<div style="margin-top: 10px;">
									  	<span style="color: red">每个日期框如果有任意一个信息填写不完整，前台将不显示。</span>
									  	<div class="cal-manager" >
									  		<div class="package-name-manager" >
									  			<?php if(count($suits)==0){?>
									  				<span class="package-tab selected" packageId="" packageName=""><strong >套餐名称</strong><em class="del-package" style="display: none;"></em></span>
									  			<?php }else{?>
									  				<?php $i=0; foreach ($suits as $suit):?>
											  			<span class="package-tab <?php if($i==0){ echo "selected"; } ?>" suitId="<?php echo $suit['id'];?>" suitName="<?php echo $suit['suitname'];?>"><strong ><?php echo $suit['suitname'];?></strong></span>
											        <?php $i++; endforeach;?>
									  			<?php } ?>
									 			
									 		</div>
									    	<div class="package-con">
									    		<div class="package-name-edit">
							    					<ul class="form-list">
							    						<li>
							    							<div class="form-label" ><label for=""><i>&nbsp;</i>套餐名称：</label><i class="required">*</i></div>
							    							<div class="col-lg-2" style="width: 210px;">
							    								<input type="text" class="input-text" placeholder="套餐名称" value="<?php if(count($suits)>0){echo $suits[0]['suitname'];}?>"  name="suitName" id="suitName" maxlength="24" readonly="readonly"   disabled="disabled" />
							    								<input type="hidden" name="suitId" id="suitId" value="<?php if(count($suits)>0) {echo $suits[0]['id'];}?>" />
							    							</div>
							    						
							    						</li>
							    					</ul>
									    		</div>
									    		<div id="price-cal"></div>
									    	</div>
									    </div>
									</div>
									
								</div>
							</div>
						</div>
					
						</form>
					</div>
					
					<!-- 行程安排 -->
					<div class="tab-pane" id="profile12">
						<form action="" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form" name="fromRout"  onsubmit="return CheckRouting();"  method="post" 
						id="lineDayForm" novalidate="novalidate">
						<div class="widget-body" id="rout_line">		         
                             <?php  $num = $data ['lineday'];for($i = 0; $i < $num; ++ $i) { ?>					
							<input name="lineday" id="lineday" value="<?php if(!empty($data ['lineday'])){ echo $data ['lineday'];}?>" id="id" type="hidden" />
							<div id="registration-form">
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;"
										for="inputEmail3" style="font-size:18px;">第<?php echo $i+1; ?>天：</label>
									<div class="col-sm-10" >
									         <?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?>
									</div>
								</div>
		
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;"
										for="inputEmail3">用餐：</label>
									<div class="form-inline">
										<div class="checkbox " style="padding-top: 0px;">
											<label style="padding: 0px;text-align: left;width:80px;">
											早餐：<?php if(!empty($rout[$i])){ if($rout[$i]['breakfirsthas']==1){ echo '含';}else{ echo '不含';}} ?>
												</label> 
										</div>
										<div class="form-group" style="margin: 0px;">
											<?php if(!empty($rout[$i])){ echo $rout[$i]['breakfirst'];} ?>
										</div>
							
										<div class="checkbox" style="padding-top: 0px;">
										<label style="padding: 0px;text-align: left;width:80px;">	
										       午餐：<?php if(!empty($rout[$i])){ if($rout[$i]['lunchhas']==1){echo '含';}else{echo '不含';}} ?>
											</label>
										</div>
										<div class="form-group" style="margin: 0px;">
											<?php if(!empty($rout[$i])){ echo $rout[$i]['lunch'];} ?>
										</div>
							
										<div class="checkbox" style="padding-top: 0px;width:80px;">
											<label style="padding: 0px;text-align: left;"> 
												晚餐 :<?php if(!empty($rout[$i])){ if($rout[$i]['supperhas']==1){ echo '含';}else{echo '不含';}} ?>
											</label>
										</div>
										<div class="form-group" style="margin: 0px;">
											<?php if(!empty($rout[$i])){ echo $rout[$i]['supper'];} ?>
										</div>
									</div>
								</div>
							
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;"
										for="inputEmail3">住宿情况：</label>
									<div class="col-sm-10">
										<?php if(!empty($rout[$i])){ echo $rout[$i]['hotel'];} ?>
									</div>
								</div>
								<div class="form-group">
									<!-- 往返交通 -->
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;"
										for="inputEmail3">交通工具：</label>
									
									<div class="col-sm-10">
									
										<div class="col-lg-1 col-sm-1 col-xs-1"
											style="width: 80px; padding: 0px">
											<div class="checkbox">
												<label style="padding: 0px;text-align: left;">
												<?php foreach ($transport as $k=>$vl){?> 
													<?php if(!empty($rout[$i]['transport'])){  $arr=explode(',', $rout[$i]['transport']);foreach ($arr as $k=>$v){ if($v==$vl['description']){ echo $vl['description'];}} } ?>
												<?php  }?>
												</label>
											</div>
										</div>
										
									</div>
									
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right " style="width: 120px;padding-top:0px;"
										for="inputEmail3">行程内容：</label>
									<div class="col-sm-10">
									<?php if(!empty($rout[$i])){ echo $rout[$i]['jieshao'];} ?>
									
									</div>
								</div>
							</div>
							<?php } ?>		
						</div>

						</form>
					</div>
					
				</div>
			</div>
		</div>
		<?php }else{ echo "该产品已不存在或已下线";}?>
	</div>
</div>



   
<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script src="<?php echo base_url('assets/js/jQuery-plugin/dateTable/jquery.dateTable.js')?>"></script>
<link href="<?php echo base_url('assets/css/product.css')?>" rel="stylesheet" />

<script type="text/javascript">
(function(){

	var data = jQuery.parseJSON('<?php echo $destinations;?>');
	//初始化弹出树数据
	var destinations = new jQuery.Destinations({
			root : 'destinations',//根节点
			bindBtn:'.user_shop_div',//弹出框 绑定单哪个对象 
			selectTo:"#ds-list",//选择到哪个对象
			title : '选择目的地',//弹出框标题
			data : data,
			getVal:function(value){
				jQuery('#overcity').val(value);
			}
	});

	data = jQuery.parseJSON('<?php echo $line_attr;?>');
	//初始化弹出树数据
	var attr = new jQuery.Destinations({
			root : 'attr',//根节点
			bindBtn:'.user_shop_attr',//弹出框 绑定单哪个对象 
			selectTo:"#attr-list",//选择到哪个对象
			title : '选择线路属性',//弹出框标题
			data : data,
			getVal:function(value){
				jQuery('#linetype').val(value);
			}
	});
	//套餐TAB移入 移除事件
	jQuery(".package-name-manager").on("mouseenter mouseleave",".package-tab",function(event){
						var tab = jQuery(this);
					    if( event.type == "mouseenter"){
					    	 jQuery(".del-package",tab).show();
					    }else if(event.type == "mouseleave" ){
					    	jQuery(".del-package",tab).hide();
					    }           
					});
	//添加新套餐
	jQuery(".package-name-manager").on("click",'.add-package',function(){
		jQuery(this).before('<span class="package-tab" suitId="" suitName="" ><strong >套餐名称</strong><em class="del-package" ></em></span>')
	});
	//删除套餐
	jQuery(".package-name-manager").on("click",'.del-package',function(){
		var suit = jQuery(this);
		var suitId = suit.attr('suitId');
		var productId = jQuery('#productId').val();
		var delUrl = '<?php echo base_url()?>admin/b1/product/getProductPriceJSON';
		var suitTab = suit.parent();
		suitTab.prev().click();
		suitTab.remove();
		//删除套餐
		jQuery.util.ajax({url : delUrl,type: "POST",data: "suitId="+suitId,callback:function(response){
			window.location.href="/Admin/Product/productPrice?id="+productId;
		}});
		return false;
		
	});
	//tab套餐切换
	jQuery(".package-name-manager").on("click",'.package-tab',function(){
		jQuery('.selected').removeClass("selected");
		jQuery(this).addClass("selected");
		var suitId = jQuery(this).attr('suitId');
		var suitName = jQuery(this).attr('suitName');
		jQuery('#suitId').val(suitId);
		jQuery('#suitName').val(suitName);
		initProductPrice();
	});

	//tab套餐切换
	jQuery("#suitName").keyup(function(){
		jQuery('.selected').html(jQuery(this).val());
	});

	function initProductPrice(){
		var url = '<?php echo base_url()?>admin/b1/product/getProductPriceJSON';
		priceDate = new jQuery.priceDate({  record:'', renderTo:"#price-cal",comparableField:"day",
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
					var adultbasicprice= '';
					var childbasicprice= '';
					var adultprice= '';
					var childprice= '';
					var refprice = '';
					var groupId='';
					if(data){
						dayid = data.dayid;
						refprice = data.refprice;
						adultbasicprice = data.adultbasicprice;
						childbasicprice = data.childbasicprice;
						adultprice=data.adultprice;
						childprice=data.childprice;
						number = data.number;
					}
					var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
					var html = '<div class="day"><span><label class="dayNum">'+settings.day+'</a>'+getCopyDown(settings.isLastRow)+'</label></span><span class="num"><input '+ flag +' value="'+settings.date+'" type="hidden" name="day[]"><input '+ flag +' value="'+dayid+'" type="hidden" name="dayid[]">空位<input  class="disableText" disabled="disabled"" readonly="readonly" style="text-align:right" type="text" '+ flag +' value="'+number+'" name="number[]">人</span></div>';
				//	html = html + '<div class="cell-price">¥<input  class="disableText" type="text" style="width: 52px;" disabled="disabled"" readonly="readonly" '+ flag +' value="'+refprice+'"  size="4" name="refprice[]">元</div>';
					html = html + '<div class="cell-price">¥<input type="text"  class="disableText" style="width: 52px;" disabled="disabled"" readonly="readonly"  '+ flag +' value="'+adultprice+'"  size="4" name="adultprice[]">元</div>';
		        	html = html +'<div class="cell-price">¥<input type="text"  class="disableText" style="width: 52px;" disabled="disabled"" readonly="readonly"  '+ flag +' value="'+childprice+'" size="4" name="childprice[]">元</div>';
		        	return html;
				}
			});
	}
	initProductPrice()

	

})();



</script>



