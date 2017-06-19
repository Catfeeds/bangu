<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
.control-label{width:100px;}
.form-horizontal .form-group input{ width:70%;}
.form-horizontal .form-group textarea{    width:100%; height: 120px;}
</style>
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb"  style="width:100%;margin-left:0px;">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">修改保险 </li>
		</ul>
	</div>

	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">已购买 </a></li>
		<li class="" id="tab1" name="tabs"><a href="#home1">已注销 </a></li>	
		<li class="" id="tab2" name="tabs"><a href="#home2">未购买 </a></li>	
	</ul>

	<div class="tab-content tabs-flat">
		<!-- 管家列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
				
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
							
	    					<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:4px;float:left">出团日期：</label>
	    					<div class="col-lg-4" style=" width:300px;float:left" >
						       	<input class="form-control user_name_b1" type="text" name="starttime" id="starttime" value="<?php echo date("Y-m-d",strtotime("+1 day")); ?>" style="width:120px;float:left;" placeholder="出团日期"><span style="float:left;padding:5px;" > - </span>
						<!-- </div>
						<div class="col-lg-4" style="width:auto;padding-right:0px; width:125px;float:left" > -->
						       	<input class="form-control user_name_b1" type="text" name="usertime" id="usertime" value="<?php echo date("Y-m-d",strtotime("+1 day")); ?>" style="width:120px;float:left;" placeholder="出团日期">
						</div>
	
						<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
							<div class="col-lg-4" style="width: 7%;padding-left:2px;">
							     <input type="button"  style="width:60px" value="搜索" class="btn btn-palegreen" id="btnSearch0">  
							</div>
							<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>	
						</div>
					</form>
					<div id="list"></div>
				</div>
			</div>
		</div>
		<!--已通过-->
		<div class="tab-pane " id="home1">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm1">
						<div class="form-group has-feedback">

							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:4px;float:left">出团日期：</label>
							<div class="col-lg-4" style="width:300px;float:left" >
							       	<input class="form-control user_name_b1" type="text" name="starttime" id="starttime1" value="<?php echo date("Y-m-d",strtotime("+1 day")); ?>" style="width:120px;float:left;" placeholder="出团日期">
							<!-- </div> -->
							<span style="float:left;padding:5px;" > - </span>
							<!-- <div class="col-lg-4" style="width:auto;padding-right:0px; width:125px;float:left" > -->
							       	<input class="form-control user_name_b1" type="text" name="usertime" id="usertime1" value="<?php echo date("Y-m-d",strtotime("+1 day")); ?>" style="width:120px;float:left;" placeholder="出团日期">
							</div>
							
							<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
							<div class="col-lg-4" style="width: 5%;padding-left:2px;">
							     <input type="button" value="搜索" style="width:60px" class="btn btn-palegreen" id="btnSearch1">  
							</div>

						</div>
					</form>
					<div id="list1"></div>
				</div>
			</div>
		</div>
	          <!--未购买-->
		<div class="tab-pane " id="home2">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm2">
						<div class="form-group has-feedback">
		
		 					<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:4px;float:left">订单编号：</label>
							<div class="col-lg-4" style="width:auto;padding-right:0px; width:235px;float:left" >
							       <input class="form-control user_name_b1" type="text" name="ordersn" id="ordersn" value="" style="width:100%" placeholder="订单编号">
							</div>
					                     <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:4px;float:left">出团日期：</label>
							<div class="col-lg-4" style="width:300px;float:left" >
							       	<input class="form-control user_name_b1" type="text" name="starttime" id="starttime2" value="<?php echo date("Y-m-d",strtotime("+1 day")); ?>" style="width:120px;float:left;" placeholder="出团日期">
							       	<span style="float:left;padding:5px;" > - </span>
							<!-- </div>
							<div class="col-lg-4" style="width:auto;padding-right:0px; width:125px;float:left" > -->
							       	<input class="form-control user_name_b1" type="text" name="usertime" id="usertime2" value="<?php echo date("Y-m-d",strtotime("+1 day")); ?>" style="width:120px;float:left;" placeholder="出团日期">
							</div>
							<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
							<div class="col-lg-4" style="width: 5%;padding-left:2px;">
							     <input type="button" value="搜索" style="width:60px" class="btn btn-palegreen" id="btnSearch2">  
							</div>

						</div>
					</form>
					<div id="list2"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--修改订单保险-->
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="editbootbox  modal fade in" >
		<div class="modal-dialog" style="width:38%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">修改保险</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="form_editdata_submit" method="post" action="#">
							         	
							           <div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right" style="width:60px;margin-top:6px">保单号</label>
									<div class="col-sm-8">
									    <span style="line-height:32px;" id="insurance_code"></span>
									</div>
								</div>			
								<div class="form-group" >
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right" style="width:60px;margin-top:6px">保险单</label>
									<div class="col-sm-8">
										<span style="line-height:32px;" id="insurance_sn"></span>
									</div>
								</div>

								<div class="form-group" style="width:100%" id="submit_btn">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"  style="width:70px;margin-top:6px">注销保险</label>
									<div class="col-sm-8">
										<input type="text" name="insurance_code"  class="form-control"  style="width:70%;float:left;"    placeholder="保单号" >
										<span onclick="submit_editInsure();" class="btn btn-default opp_eidt" style="margin-left:10px">提交</span>
									</div>
								</div>	
								<!--出游人信息-->
								<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right" style="width:112px;">出游人信息:</label>
								<div class="member_traver" style="margin:45px;overflow-y:auto;max-height:190px"></div> 
								<input  type="hidden" name="order_insurance_id" />   
								<!--取消按钮-->
								<!-- <div class="form-group" style="width:100%;margin-left:40%" id="quxiao_btn">
									<div class="col-sm-8">
										<span onclick="submit_quxiaoInsure();" class="btn btn-default opp_eidt" style="margin-left:10px">取消保险</span>
									</div>
								</div> -->
						
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>



<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />

<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
//-----------------------------------保险列表数据----------------------------------------------
jQuery(document).ready(function(){
	/*未结算 */
	var page=null;
	// 查询
	jQuery("#btnSearch0").click(function(){
		page.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/insurance/insurance_edit/indexData",form : '#listForm0',// 绑定一个查询表单的ID
		columns : [

			{field : 'id',title : '序号',width : '40',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}
			},
			
			{field : 'productname',title : '线路名称',align : 'center',sortable : true,width : '120'},
			{field : 'usedate',title : '出团日期',align : 'center',sortable : true,width : '80'},
			{field : 'insurance_name',title : '保险名称',align : 'center',sortable : true,width : '120'},
			{field : 'people_num',title : '保险人数',align : 'center', width : '100'},
			{field : 'code',title : '保险编码',align : 'center', width : '80'},
			{field : 'insurance_price',title : '保险价格',align : 'center', width : '100'},
			/*{field : 'settlement_price',title : '保险售卖价',align : 'center', width : '100'},*/
			{field : 'is_buy',title : '购买状态',align : 'center', width : '100',
				formatter : function(value,rowData, rowIndex){	
					if(rowData.status==1){
						return '已购买';					
					}else if(rowData.status==-1) {
						return '已注销';
					}else{
						return '未购买';
					}
				}
			},
			
			{field : 'is_buy',title : '操作',align : 'center', width : '100',
				//isbuy_insurance
				formatter : function(value,rowData, rowIndex){
					var water_account="'"+rowData.water_account+"'";
					if(rowData.status==1){
						if(rowData.status>4){
							return '<a onclick="('+water_account+',0);"  href="##">查看</a>';
						}else{
							return '<a onclick="editInsure('+water_account+',1);"  href="##">修改</a>';
						}											
					}else{
						if(rowData.status==4){
							//return '<a onclick="editInsure('+rowData.id+','+rowData.is_buy+',1);"  href="##">修改</a>';
							return '<a onclick="editInsure('+water_account+',0);"  href="##">查看</a>';
						}else{
							return '<a onclick="editInsure('+water_account+',0);"  href="##">查看</a>';	
						}	
					}
				}
			}
		]
	});
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		page.load({"status":"1"});
	});

	// 第二个列表 已注销===============================================================
	var page1 = null;
	function initTab1(){
	jQuery("#btnSearch1").click(function(){
		page1.load({"status":"-1"});
	});
	var data = '<?php echo $pageData; ?>';
	page1 = new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/insurance/insurance_edit/indexData",form : '#listForm1',// 绑定一个查询表单的ID
			columns : [
				{field : 'id',title : '序号',width : '40',align : 'center',
					formatter : function(value,rowData, rowIndex) {
						return rowIndex+1;
					}
				},
				
				{field : 'productname',title : '线路名称',align : 'center',sortable : true,width : '120'},
				{field : 'usedate',title : '出团日期',align : 'center',sortable : true,width : '80'},
				{field : 'insurance_name',title : '保险名称',align : 'center',sortable : true,width : '120'},
				{field : 'people_num',title : '保险人数',align : 'center', width : '100'},
				{field : 'code',title : '保险编码',align : 'center', width : '80'},
				{field : 'insurance_price',title : '保险价格',align : 'center', width : '100'},
				/*{field : 'settlement_price',title : '保险售卖价',align : 'center', width : '100'},*/
				{field : 'is_buy',title : '购买状态',align : 'center', width : '100',
					formatter : function(value,rowData, rowIndex){	
						if(rowData.status==1){
							return '已购买';					
						}else if(rowData.status==-1) {
							return '已注销';
						}else{
							return '未购买';
						}
					}
				},
				
				{field : 'is_buy',title : '操作',align : 'center', width : '100',
					//isbuy_insurance
					formatter : function(value,rowData, rowIndex){
					
						var water_account="'"+rowData.water_account+"'";
						if(rowData.status==1){
							
							if(rowData.status>4){
								return '<a onclick="('+water_account+',0);"  href="##">查看</a>';
							}else{
								return '<a onclick="editInsure('+water_account+',1);"  href="##">修改</a>';
							}											
						}else{
							if(rowData.status==4){
								//return '<a onclick="editInsure('+rowData.id+','+rowData.is_buy+',1);"  href="##">修改</a>';
								return '<a onclick="editInsure('+water_account+',0);"  href="##">查看</a>';
							}else{
								return '<a onclick="editInsure('+water_account+',0);"  href="##">查看</a>';	
							}	
						}
				         }
				}
			]
		});
	}
 	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery('#tab1').addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"-1"});	
	}); 
    	// 第三个列表 未购买===============================================================
	var page2 = null;
	function initTab2(){
	jQuery("#btnSearch2").click(function(){
		page2.load({"status":"2"});
	});
	var data = '<?php echo $pageData; ?>';
	page2 = new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/insurance/insurance_edit/get_insurance_order",form : '#listForm2',// 绑定一个查询表单的ID
			columns : [

				{field : 'ordersn',title : '订单编号',align : 'center',sortable : true,width : '120'},
				{field : 'usedate',title : '出团日期',align : 'center',sortable : true,width : '80'},
				{field : 'number',title : '出游人数',align : 'center',sortable : true,width : '80'},
				{field : 'productname',title : '线路名称',align : 'center',sortable : true,width : '120'},
				{field : 'status',title : '订单状态',align : 'center',sortable : true,width : '120',
					formatter : function(value,rowData, rowIndex){
						if(rowData.status==0){
							return '待留位';	
						}else if(rowData.status==1){
							return '已留位';
						}else if(rowData.status==2){ 
							return '待确认收款';
						}else if (rowData.status==3) {
							return '已支付';
						}else if(rowData.status==4){
							return '已确认';
						}else if(rowData.status==5){
							return '已出行';
						}else if(rowData.status==6){
							return '已评论';
						}else if(rowData.status==7){
							return '已投诉';
						}else if(rowData.status==8){
							return '出团结束';
						}else if(rowData.status==-1){
							return '供应商拒绝';
						}else if(rowData.status==-2){
							return '平台拒绝';
						}else if(rowData.status==-3){
							return '退订中';
						}else if(rowData.status==-4){
							if(rowData.ispay==0){
 								return '已取消';
							}else{
							           return '已退订';	
							}		
						}
					}	
				},
				{field : 'insurance_name',title : '保险名称',align : 'center', width : '100'},
				{field : 'insurance_code',title : '保险编码',align : 'center', width : '80'},
				{field : 'insurance_price',title : '保险费用',align : 'center', width : '100'},
				{field : 'amount',title : '保险售卖价',align : 'center', width : '100'}			
			/*	{field : 'is_buy',title : '操作',align : 'center', width : '100',
					//isbuy_insurance
					formatter : function(value,rowData, rowIndex){
						var date="'"+rowData.usedate+"'";	
					        return '<a onclick="editInsure('+rowData.suitid+','+date+',0);"  href="##">查看</a>';
					}
				},*/
			]
		});
	}
 	jQuery('#tab2').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery('#tab2').addClass('active');
		if(null==page2){
			initTab2();
		}
		page2.load({"status":"2"});	
	}); 

	
}); 
//-----------------------------------保险列表数据 end----------------------------------------------
$('#usertime,#usertime1,#usertime2').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#starttime,#starttime1,#starttime2').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
//修改弹框
function editInsure(id,type){

	$('.editbootbox').show();
	$('.modal-backdrop,.opp_eidt').show();
             if(type==1){
             	$('#submit_btn').show();
             }else{
             	$('#submit_btn').hide();
             }
             $('input[name="insurance_code"]').val('');
	
		$.post("/admin/a/insurance/insurance_edit/order_traver",{'water_account':id},function(re) {
			var re = eval('('+re+')');
                                      if(re.data!=''){       //出游人信息
				var title=' '; 
				title=title+'<table  class="table table-bordered dataTable no-footer " >';
				title=title+'<thead> ';	
				title=title+'<tr> ';
				title=title+'<th style="width: 150px;text-align:center;font-weight:500">出游人</th> ';
				title=title+'<th style="width: 170px;text-align:center;font-weight:500">性别</th> ';
				title=title+' <th style="width: 170px;text-align:center;font-weight:500">出生日期</th>';
				title=title+' <th style="width: 100px;text-align:center;font-weight:500">手机号</th>';				         
				title=title+' </tr></thead>';
				title=title+' <tbody class="">';
				
				var html='';

				if(re.orderInsure.people_num!=''){
					if(re.orderInsure.people_num>0){
						var length=re.orderInsure.people_num;	
					}else{
					      	var length=re.data.length;	
					}
				}
				
				$.each(re.data ,function(key ,val) {
                                                   	if(length>key){
                                                   		html=html+' <tr style="" class="" >';
			 			if(val.name=='' || val.name==null){
			 				val.name=val.enname;	
			 			}		 		
			 			if(val.sex==1){
			 				var sex='男';
			 			}else{
			 				var sex='女';
			 			}
						 html=html+'<td style="text-align:center">'+val.name+'</td>';
						 html=html+'<td style="text-align:center">'+sex+'</td>';
						 html=html+'<td style="text-align:center">'+val.birthday+'</td>';
						 html=html+'<td style="text-align:center">'+val.telephone+'</td>';
						 html=html+' </tr>';
                                                  	}
	
		 		})					         
	                                    title= title+html;
	                                    title=title+'</tbody> ';
	                                    title=title+'</table> ';
	                                    $('.member_traver').html(title);
                                     }
                                  
                                     if(re.orderInsure.insurance_code!='' && typeof(re.orderInsure.insurance_code)!='undefined'){
				$('#insurance_code').html(re.orderInsure.insurance_code);
                                     }else{
                                     	$('#insurance_code').html('暂无保单号');
                                     }
                                     if(re.orderInsure.id!=''){
                                               $('input[name="order_insurance_id"]').val(re.orderInsure.id)
                                     }
                                     if(re.orderInsure.insurance_sn!='' && typeof(re.orderInsure.insurance_sn)!='undefined'){
                                     	$('#insurance_sn').html('<a target="_blank" href="'+re.orderInsure.insurance_sn+'">查看</a>');
                                     }else{
                                     	$('#insurance_sn').html('暂无保险单');
                                     }

		 });


}

//关闭弹框
$('.opp_colse').click(function(){
	$('.bootbox,.editbootbox').hide();
	$('.modal-backdrop').hide();
	$('#btnSearch0').click();
})

//注销保险
function submit_editInsure(){
	$.post("/insurance_api/edit_insurance",$('#form_editdata_submit').serialize(),function(data) {
 		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			$('#btnSearch0').click();
		} else {
			alert(data.msg);
			$('#btnSearch0').click();
		} 
	});
}
//取消保险
/*function submit_quxiaoInsure(){  
	$.post("/admin/a/insurance/insurance_edit/quxiao_insurance",$('#form_editdata_submit').serialize(),function(data) {
 		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			//location.reload();
			$('#btnSearch0').click();
		} else {
			alert(data.msg);
			//location.reload();
			$('#btnSearch0').click();
		} 
	});
}*/
</script>


