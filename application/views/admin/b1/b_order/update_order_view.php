<style type="text/css">
	.form-group label{ float: left; width: 100px;}
	.col-lg-4{float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.widget-body {padding: 12px}
	.fg_div{ float: left; margin-top: 2px;}
	.p_sp{  float: left; width: 530px; margin-left: 80px; font-size: 12px;}
</style>	
	<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">订单管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

	<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs" id=""><a href="#home11" data-toggle="tab" id="tab0"> 申请中</a></li>
					<li class="" name="tabs" id=""><a href="#profile11" data-toggle="tab" id="tab1"> 已通过 </a></li>
					<li class="" name="tabs" id=""><a href="#profile11" data-toggle="tab" id="tab2"> 已拒绝 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
				<!-- 申请中 -->
					<div class="tab-pane active" id="home0">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post"
									id="searchForm0" novalidate="novalidate">
									<div class="form-group has-feedback">
										<!-- <div class="fg_div" ><label class="col-lg-4 control-label" >产品名称：</label>
										<div class="col-lg-4" style="width: 200px;">
											<input type="text" placeholder="产品名称-模糊搜索" name="linename"
												class="form-control user_name_b1">
										</div></div> -->
										<div class="fg_div" ><label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 200px">
											<input type="text" placeholder="产品编号" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 255px;">
												<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input style="width:205px" type="text"  placeholder="日期" class="form-control"
													id="reservation" name="line_time">
											</div> 
										</div>
										</div>
										
										<div class="col-lg-4 fg_div" style="width: 70px">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn0">
										</div>
									</div>
								</form>
	
								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 已通过 -->
					<div class="tab-pane" id="home1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form"
									id="searchForm1" novalidate="novalidate">
									<div class="form-group has-feedback">
										<!-- <label class="col-lg-4 control-label">产品名称：</label>
										<div class="col-lg-4" style="width: 12%;">
											<input type="text" placeholder="产品名称-模糊搜索" name="linename"
												class="form-control user_name_b1">
										</div> -->
										<label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 12%;">
											<input type="text" placeholder="订单编号" name="linecode"
												class="form-control user_name_b1">
										</div>
										<label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 255px;">
											<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span>
												 <input type="text" style="width:205px" placeholder="日期" class="form-control" id="reservation2" name="line_time">
											</div> 
										</div>
																		
										<div class="col-lg-4" style="width: 70px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn1">
										</div>
									</div>
								</form>
								<div id="list1"></div>
							</div>
						</div>
					</div>
					<!-- 已拒绝 -->
					<div class="tab-pane" id="home2">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form"
									id="searchForm2" novalidate="novalidate">
									<div class="form-group has-feedback">
										<!-- <label class="col-lg-4 control-label">产品名称：</label>
										<div class="col-lg-4" style="width: 12%;">
											<input type="text" placeholder="产品名称-模糊搜索" name="linename"
												class="form-control user_name_b1">
										</div> -->
										<label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 12%;">
											<input type="text" placeholder="订单编号" name="linecode"
												class="form-control user_name_b1">
										</div>
										<label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 255px;">
											<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span>
												 <input type="text" style="width:205px" placeholder="日期" class="form-control" id="reservation2" name="line_time">
											</div> 
										</div>
																		
										<div class="col-lg-4" style="width: 70px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn2">
										</div>
									</div>
								</form>
								<div id="list2"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--未完成弹框-->
<!-- <div class="modal-backdrop fade in eject_body" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="eject_body  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content" style="width:735px">			
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close eject_colse"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title eject_title">申请付款</h4>
				</div>		

			<div class="modal-body">
			<div class="bootbox-body">
			<form class="form-horizontal" role="form" id="apply_from" method="post" action="#">
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:105px;">订单成本价:</label>
					<div class="eject_text_info">
						<div class="content_info" id="order_money" style="margin-top:8px">

						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:105px;">付款信息:</label>
					<div class="eject_text_info" id="pay_content" style="padding-left:133px;">

					</div>
			    	</div>
				<div class="pay_content_div">	
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:120px;"><span style="color: red;">*</span>收款单位:</label>
					<div class="col-sm-8 eidt_div" style="width:35%">
						<div class="content_info">
							<input tyle="text" value="" name="item_company" style="padding:6px;width:280px;">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:120px;"><span style="color: red;">*</span>银行名称+支行:</label>
					<div class="col-sm-8 eidt_div" style="width:35%">
						<div class="content_info">
							<input tyle="text" value="" name="bankname" style="padding:6px;width:280px;">
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:120px;"><span style="color: red;">*</span>开户人:</label>
					<div class="col-sm-8 eidt_div" style="width:35%">
						<div class="content_info">
							<input tyle="text" value="" name="bankpeople" style="padding:6px;width:280px;">
						</div>
					</div>
				
				</div>
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:120px;"><span style="color: red;">*</span>开户帐号:</label>
					<div class="col-sm-8 eidt_div" style="width:35%">
						<div class="content_info">
							<input tyle="text" value="" name="bankcard" style="padding:6px;width:280px;">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:120px;"><span style="color: red;">*</span>申请金额:</label>
					<div class="col-sm-8 eidt_div" style="width:35%">
						<div class="content_info">
							<input tyle="text" value="" name="pay_money" style="padding:6px;width:280px;">
						</div>
					</div>
				</div>
	 			<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:120px;">备注:</label>
					<div class="eject_text_info">
						<textarea rows="5" cols="50" name="remark"  style="margin-left: 15px;"></textarea>
					</div>
				</div>
				</div>
    		  		<div class="form-group eject_botton">
    		  			<input type="hidden" name="orderid" id="orderid">
					<div class="btn btn-default" style="left:45%;" onclick="submit_apply()">确认</div>
				</div>

			</form>
			</div>
			
		</div>
		</div>
	</div>
</div> -->
<!--申请付款end-->
<!--成本修改-->
<div class="modal-backdrop fade in updataprice_body" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="updataprice_body  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content" style="width:680px">			
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close eject_colse"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title eject_title">修改成本价</h4>
				</div>		

			<div class="modal-body">
			<div class="bootbox-body">
			<form class="form-horizontal" role="form" id="up_price_from" method="post" action="#">
		 		<div class="form-group" id="remark_div" style="margin-bottom:35px">
				</div> 
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:105px;"><span style="color: red;">*</span>项目选择:</label>
					<div class="eject_text_info" id="pay_content" style="padding-left:133px;">
						<select name="item">
							<option value="0">请选择</option>
							<?php if(!empty($item)){
								foreach ($item as $key => $value) {							
							?>
								<option value="<?php echo $value['dict_id'];?>"><?php echo $value['description'];?></option>
							<?php } }?>
						</select>
					</div>
			    	</div>	
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:120px;"><span style="color: red;">*</span>成本价:</label>
					<div class="col-sm-8 eidt_div" style="width:35%">
						<div class="content_info">
							<input tyle="text" value="" name="item_price" style="padding:6px;width:280px;">
						</div>
					</div>
				</div>
    		  		<div class="form-group eject_botton">
    		  			<input type="hidden" name="orderid" id="orderid">
					<div class="btn btn-default" style="left:45%;" onclick="submit_bill()">确认</div>
				</div>

			</form>
			</div>
			
		</div>
		</div>
	</div>
</div>
<!--成本修改end-->
<!--退团-->
<div class="modal-backdrop fade in tuituan_body" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="tuituan_body  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content" style="width:640px">			
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close eject_colse"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title eject_title">修改订单</h4>
				</div>		
			<div class="modal-body">
			<div class="bootbox-body">
			<form class="form-horizontal" role="form" id="up_price_from" method="post" action="#">
				<div class="form-group">
					<label for="inputEmail3"
						class="col-sm-3 control-label no-padding-right" style="width:100px;">原因:</label>
					<div class="eject_text_info">
						<textarea rows="5" cols="50" name="s_remark"></textarea>
					</div>
				</div>
    		  		<div class="form-group eject_botton" style="margin-top:50px">
    		  			<input type="hidden" name="bill_id" id="bill_id">
    		  			<input type="hidden" name="order_id" id="order_id">
					<div class="btn btn-default" style="left:35%;" id="through_price_div" onclick="through_price()">确认</div>
					<div class="btn btn-default" style="left:35%;" id="refuse_price_div"  onclick="refuse_price()">拒绝</div>
					<div class="btn btn-default opp_colse" style="left:45%;" >关闭</div>
				</div>

			</form>
			</div>
			
		</div>
		</div>
	</div>
</div>
<!--分页-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<!--时间插件-->
<?php echo $this->load->view('admin/b1/common/time_script'); ?>
<script type="text/javascript">
//--------------------------------------数据列表-----------------------------------------------
jQuery(document).ready(function(){
	var page=null;
	// 查询
	jQuery("#searchBtn0").click(function(){
		page.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/b_order/update_order/indexData",form : '#searchForm0',// 绑定一个查询表单的ID
		columns : [
			{field : 'ordersn',title : '订单编号',width : '80',align : 'center'},
			{field : 'item',title : '申请类型',width : '80',align : 'center'},
			{field : 'supplier_cost',title : '成本价',align : 'center',sortable : true,width : '80'},
			{field : 'amount',title : '调整成本金额',align : 'center', width : '100'},
			{field : 'num',title : '退团人数',align : 'center',sortable : true,width : '150',
				formatter : function(value,rowData, rowIndex){
					var str =rowData.num+'成人&nbsp;'+rowData.childnum+'小孩(占床)&nbsp;';
					str=str+rowData.childnobednum+'小孩(不占床)&nbsp;'+rowData.oldnum+'成人&nbsp;';
					 return str;
				}
			},
			{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
			{field : 'addtime',title : '申请时间',align : 'center', width : '100'},
			{field : 'realname',title : '申请人',align : 'center', width : '100'},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,rowData, rowIndex){
					var html='';
					html=html+'<a href="#"  onclick="tuituan_order('+rowData.order_id+','+rowData.id+',0)">通过</a>&nbsp;&nbsp';
					html=html+'<a  href="#"  onclick="tuituan_order('+rowData.order_id+','+rowData.id+',1)">拒绝</a>';
					return html;
				}
			}
		]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"1"});
	}); 

	/*已通过 */
	var page1=null;
	function initTab1(){
	// 查询
	 jQuery("#searchBtn1").click(function(){
		page1.load({"status":"2"});
	});
	//page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData",form : '#searchForm1',// 绑定一个查询表单的ID
	page1=new jQuery.paging({renderTo:'#list1',url : "<?php echo base_url()?>admin/b1/b_order/update_order/indexData",form : '#searchForm1',// 
		columns : [
		
				{field : 'ordersn',title : '订单编号',width : '80',align : 'center'},
				{field : 'item',title : '申请类型',width : '80',align : 'center'},
				{field : 'supplier_cost',title : '成本价',align : 'center',sortable : true,width : '80'},
				{field : 'amount',title : '调整成本金额',align : 'center', width : '100'},
				{field : 'num',title : '退团人数',align : 'center',sortable : true,width : '150',
					formatter : function(value,rowData, rowIndex){
						var str =rowData.num+'成人&nbsp;'+rowData.childnum+'小孩(占床)&nbsp;';
						str=str+rowData.childnobednum+'小孩(不占床)&nbsp;'+rowData.oldnum+'成人&nbsp;';
						 return str;
					}
				},
				{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
				{field : 'addtime',title : '申请时间',align : 'center', width : '100'},
				{field : 'realname',title : '申请人',align : 'center', width : '100'},
				{field : 's_remark',title : '通过原因',align : 'center', width : '120'}
			]
		});
	}
	 jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"2"});
	}); 
	 /*已拒绝 */
	var page2=null;
	function initTab2(){
	// 查询
	 jQuery("#searchBtn2").click(function(){
		page1.load({"status":"4"});
	});
	//page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData",form : '#searchForm1',// 绑定一个查询表单的ID
	page2=new jQuery.paging({renderTo:'#list2',url : "<?php echo base_url()?>admin/b1/b_order/update_order/indexData",form : '#searchForm2',// 
		columns : [
				{field : 'ordersn',title : '订单编号',width : '80',align : 'center'},
				{field : 'item',title : '申请类型',width : '80',align : 'center'},
				{field : 'supplier_cost',title : '成本价',align : 'center',sortable : true,width : '80'},
				{field : 'amount',title : '调整成本金额',align : 'center', width : '100'},
				{field : 'num',title : '退团人数',align : 'center',sortable : true,width : '150',
					formatter : function(value,rowData, rowIndex){
						var str =rowData.num+'成人&nbsp;'+rowData.childnum+'小孩(占床)&nbsp;';
						str=str+rowData.childnobednum+'小孩(不占床)&nbsp;'+rowData.oldnum+'成人&nbsp;';
						 return str;
					}
				},
				{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
				{field : 'addtime',title : '申请时间',align : 'center', width : '100'},
				{field : 'realname',title : '申请人',align : 'center', width : '100'},
				{field : 's_remark',title : '拒绝原因',align : 'center', width : '120'}
			]
		});
	}
	 jQuery('#tab2').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page2){
			initTab2();
		}
		page1.load({"status":"4"});
	}); 
});

$('.opp_colse,.bc_close').click(function(){
	$('.eject_body').hide();
	$('.modal-backdrop').hide();	
	$('.updataprice_body').hide();
	$('.tuituan_body').hide();
})
//修改成本价
 function update_price(orderid){
 	if(orderid>0){
 		$('.updataprice_body').show();
		$('.modal-backdrop,.opp_srelease').show(); 

 		$('#remark_div').html('');
	 	$('#up_price_from').find('input[name="orderid"]').val(orderid);

	 	jQuery.ajax({ type : "POST",data :"orderid="+orderid,url : "<?php echo base_url()?>admin/b1/b_order/order_list/get_order_bill",
		           success : function(data) {
		           	data = eval('('+data+')');
			           if(data.status==1){
			           	$('#up_price_from').find('input[name="item_price"]').val(data.order);
			           	if(data.bill_yf!=''){
			           		var html='<label for="inputEmail3" class="col-sm-3 control-label no-padding-right" style="width:120px;">';
			           		html= html+'价格修改:</label>';
			           		$.each(data.bill_yf, function(a, b) {
			           			html= html+'<div class="eject_text_info" >';
			           			html= html+'<span  class="p_sp">'+(a+1)+'.'+b.remark+'</span>';
			           			html= html+'</div>';
			           		});
						$('#remark_div').html(html);
			           	}else{
			           		$('#remark_div').html('');
			           	}
			           }else{
			           	alert(data.msg);	
			           }    
		           }
		})
	
	 		
 	}else{
 		alert('不存在记录');
 		return false;
 	}

 }
 //成本价
function submit_bill(){
	 var price=$('#up_price_from').find('input[name="item_price"]').val();
	 if(price==''){
		alert('成本价填写不能为空');
		return false;
	 }else{
	 	if(isNaN(price) || price<0){
	 		alert('成本价填写格式不对');
			return false;
		}
	}
	
	$.post("/admin/b1/b_order/order_list/add_order_bill_price",$('#up_price_from').serialize(),function(data){
	           data = eval('('+data+')');
	           if(data.status==1){
	           	alert(data.msg);
	           	$('.opp_colse,.bc_close').click();
	           	 jQuery('#tab0').click();
	           }else{
	           	alert(data.msg);	
	           }    
     	})
	return false;
}

$(document).on('mouseover', '.title_info', function(){	
	var html='';
	html=html+'<div class="info_txt" id="info_txt" style="width:340px;text-align:left;border:1px solid #aaa;background:#fff;z-index:999;position:absolute;left:40px;top:0;display:none;">';
	html=html+'<p style="color: red;">销售人员因客户需求,订单的出游人数或成本有变化,请尽快去确认</p></div>';     
	$('.title_info').append(html);
	$(this).find(".info_txt").show();
});
$(document).on('mouseout', '.title_info', function(){
	$(".info_txt").hide();
});

//修改订单
function tuituan_order(orderid,bill_id,type){
	if(type==0){
		$('#refuse_price_div').hide();
		$('#through_price_div').show();
	}else if(type==1){
		$('#refuse_price_div').show();
		$('#through_price_div').hide();
	}
	$('.tuituan_body').find('input[name="order_id"]').val(orderid);
	$('.tuituan_body').find('input[name="bill_id"]').val(bill_id);
/*	jQuery.ajax({ type : "POST",data :"orderid="+orderid+"&bill_id="+bill_id,url : "<?php echo base_url()?>admin/b1/b_order/order_list/get_price_bill",
	           success : function(data) {
	           	data = eval('('+data+')');
	           	$('.tuituan_body').find('.num').html(data.order_bill.num+'人');
	           	$('.tuituan_body').find('.childnobednum').html(data.order_bill.childnobednum+'人');
	           	$('.tuituan_body').find('.childnum').html(data.order_bill.childnum+'人');
	           	$('.tuituan_body').find('.oldnum').html(data.order_bill.oldnum+'人');
	           	$('.tuituan_body').find('.amountPrice').html(data.order_bill.amount+'元');
	           	$('.tuituan_body').find('.order_item').html(data.order_bill.item);
			$('.tuituan_body').find('input[name="order_id"]').val(orderid);
			$('.tuituan_body').find('input[name="bill_id"]').val(bill_id);
	           }
	});*/

	$('.tuituan_body').show();
	$('.modal-backdrop,.opp_srelease').show(); 
}
//通过修改订单
function through_price(){
	var s_remark=$('textarea[name="s_remark"]').val();
	var orderid=$('.tuituan_body').find('input[name="order_id"]').val();
	var bill_id=$('.tuituan_body').find('input[name="bill_id"]').val();
	jQuery.ajax({ type : "POST",data :"orderid="+orderid+"&bill_id="+bill_id+'&s_remark='+s_remark,url : "<?php echo base_url()?>admin/b1/b_order/update_order/through_Oderprice",
	           success : function(data) {
	           	data = eval('('+data+')');
	           	if(data.status==1){
		           	alert(data.msg);
		           	$('.opp_colse,.bc_close').click();
		           	 jQuery('#tab0').click();
		           }else{
		           	alert(data.msg);	
		           }   
	           }
	});
}
//拒绝修改订单
function refuse_price(){
	var orderid=$('.tuituan_body').find('input[name="order_id"]').val();
	var bill_id=$('.tuituan_body').find('input[name="bill_id"]').val();
	jQuery.ajax({ type : "POST",data :"orderid="+orderid+"&bill_id="+bill_id,url : "<?php echo base_url()?>admin/b1/b_order/order_list/refuse_Oderprice",
	           success : function(data) {
	           	data = eval('('+data+')');
	           	if(data.status==1){
		           	alert(data.msg);
		           	$('.opp_colse,.bc_close').click();
		           	jQuery('#tab0').click();
		           }else{
		           	alert(data.msg);	
		           }   
	           }
	});
}
 $(function() {
           $("#checkAll").click(function() {
                $('input[name="order[]"]').attr("checked",this.checked); 
          });
 });
</script>

