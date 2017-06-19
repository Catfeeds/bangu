<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	#form_refund_search .form-group{float:left;padding-right: 5px;}
	.form-group{  padding-right: 5px;}
	.table-toolbar{margin-left: 5px;}
	.form-inline .form-group{ margin-bottom: 15px;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">退款审批</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

			
						<div class="flip-scroll">
						<div class="table-toolbar">
							<a id="add_refund" href="#"
								class="btn btn-default">新增退款 </a>

						</div>	
						<div class="tabbable">
						<ul id="myTab5" class="nav nav-tabs">
							<li class='active' status='0'><a href="javascript:void(0);" >新申请</a></li>
							<li status='1'><a href="javascript:void(0);" >已通过</a></li>
							<li status='2'><a href="javascript:void(0);" >已拒绝</a></li>							
						</ul>
		
						<div class="tab-content">
							<div class="tab-pane active" id="tab1">
								<form class="form-inline" id="search_condition" action="<?php echo site_url('admin/a/finance/search_refund')?>" method="post">
									<div class="form-group dataTables_filter">
										<input type="text" class="form-control" name="productname" placeholder="产品名称">
									</div>
									<div class="form-group dataTables_filter">
										<input type="text" class="form-control" name="ordersn" placeholder="订单编号">
									</div>
									<div class="form-group dataTables_filter">
										<input type="text" class="form-control" name="truename" placeholder="申请人">
									</div>	
									<div class="form-group" style="width:250px">
										<div class="controls">
											<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar"></i></span> 
												<input type="text" class="form-control" id="reservation2" name="time" >
											</div>
										</div>
									</div>	
									<div class="form-group dataTables_filter">							    
										<button type="submit" class="btn btn-default" style="float:left;">搜索</button>
										<input type="hidden" name="status" value="0" />
										<input type="hidden" name="page_new" value="1"  class="page_new" />
									</div>	
								</form>
								
								<table class="table table-striped table-hover table-bordered dataTable no-footer" >
								    <thead id="pagination_title"></thead>
								    <tbody id="pagination_data"></tbody>
								</table>
							</div>
							<br/>
							<div class="pagination" id="pagination"></div>
								
						</div>
					</div>
				</div>				
			

<!-- 退回申请 -->
<div class="eject_body refund_apply" style="width:30%;">
	<div class="eject_colse ex_colse" onclick="colse_box();">X</div>
	<div class="eject_title">退回申请</div>
	<div class="eject_content">
		<div class="eject_content_text">
			<div class="eject_text_name">退回原因:</div>
			<div class="eject_text_info"><textarea name="refund_beizhu" rows="5" cols="50"></textarea></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="refund_id" />
			<div class="ex_colse" onclick="colse_box();">关闭</div>
			<div class="refund_submit">确认退回</div>
		</div>	
	</div>						
</div>
<!-- 通过申请 -->
<div class="eject_body through_apply" style="width:30%;">
	<div class="eject_colse ex_colse" onclick="colse_box();">X</div>
	<div class="eject_title">通过申请</div>
	<div class="eject_content">
		<div class="eject_content_text">
			<div class="eject_text_name">订单支付金额:</div>
			<div class="eject_text_info" style="margin-left:135px;">
				<input type="text" name="total_price" readonly="readonly" style="height:30px;width:423px;" />
			</div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">申请退款金额:</div>
			<div class="eject_text_info" style="margin-left:135px;">
				<input type="text" name="amount_apply" class="inputDecimalMax"  style="height:30px;width:423px;ime-mode:disabled;" />
			</div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name" >备注:</div>
			<div class="eject_text_info" style="margin-left:135px;"><textarea name="through_beizhu" rows="5" cols="50"></textarea></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="through_id" />
			<div class="ex_colse" onclick="colse_box();">关闭</div>
			<div class="through_submit">确认通过</div>
		</div>	
	</div>						
</div>

<!-- 新增退款 -->
<div class="eject_body add_refund_box" style="width:30%;">
	<div class="eject_colse ex_colse" onclick="colse_box();">X</div>
	<div class="eject_title">新增退款</div>
	<div class="eject_content">
		<div class="eject_content_text">
			<div class="eject_text_name">订单号:</div>
			<div class="eject_text_info" style="margin-left:135px;">
				<input type="text" name="add_ordersn" readonly="readonly" style="height:30px;width:423px;" />
			</div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">退款金额:</div>
			<div class="eject_text_info" style="margin-left:135px;">
				<input type="text" name="add_amount_apply" class="inputDecimalMax" maxNumber="0" style="height:30px;width:423px;ime-mode:disabled;" />
			</div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name" >理由:</div>
			<div class="eject_text_info" style="margin-left:135px;"><textarea name="add_reason" rows="5" cols="50"></textarea></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" name="add_orderId" />
			<div class="ex_colse" onclick="colse_box();">关闭</div>
			<div class="add_submit">确认增加</div>
		</div>	
	</div>						
</div>
<!-- 退款选择订单那 -->
<div class="eject_body choice_order_box" style="width:80%;margin-left:-16%;min-height:420px;">
	<div class="eject_colse ex_colse" onclick="colse_order_box();">X</div>
	<div class="eject_title">选择退款订单</div>
	<div class="eject_content">
		<div class="box_form">
			<form action="<?php echo site_url('admin/a/finance/choice_order') ?>" method="post" id="choice_order_form">
				<input type="text" name="choice_ordersn" placeholder="订单编号" maxlength="12" />
				<input type="text" name="choice_linename" placeholder="产品名称"  />
				<input type="text" name="choice_supplier" placeholder="供应商名称" />
				<input type="hidden" name="page_new" class="page_new" value="1" />
				<button class="box_button">搜索</button>
			</form>
		</div>
		<div class="box_data">
			<table class="table table-striped table-hover table-bordered dataTable no-footer">
				 <thead id="choice_order_title"></thead>
				 <tbody id="choice_order_data"></tbody>
			</table>
		</div>
		<div id="choice_order_page" class="pagination"></div>
	</div>						
</div>
<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
//新申请
var columns1 = [ {field : null,title : '订单编号',width : '150',align : 'center',formatter:function(item){
					return '<a href="/admin/a/orders/order/order_detail_info?id='+item.order_id+'" target="_blank">'+item.ordersn+'</a>';
			}
		},
		{field : 'productname',title : '产品名称',width : '200',align : 'left',length:15},
		{field : 'cityname',title : '出发地',width : '140',align : 'left'},
		{field : 'addtime',title : '申请时间',align : 'left', width : '200'},
		{field : 'amount_apply',title : '申请退款金额',align : 'center', width : '180'},
		{field : 'truename',title : '会员',align : 'center', width : '180'},
		{field : 'supplier_name',title : '供应商',align : 'left', width : '180'},
		{field : 'expert_name',title : '管家',align : 'center', width : '180'},
		{field : 'reason',title : '申请备注',align : 'left', width : '180'},
		{field : null,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="through_show('+item.id+','+item.amount_apply+','+item.total_price+')" class="btn btn-default btn-xs purple">通过</a>';
        	button += '&nbsp;<a href="javascript:void(0);" onclick="refund_show('+item.id+')" class="btn btn-default btn-xs purple">退回</a>';
			return button;
		}
	}];
//已通过
var columns2 = [ {field : null,title : '订单编号',width : '150',align : 'center',formatter:function(item){
					return '<a href="/admin/a/orders/order/order_detail_info?id='+item.order_id+'" target="_blank">'+item.ordersn+'</a>';
			}
		},
		{field : 'productname',title : '产品名称',width : '200',align : 'left',length:15},
		{field : 'cityname',title : '出发地',width : '140',align : 'left'},
		{field : 'addtime',title : '申请时间',align : 'left', width : '200'},
		{field : 'amount_apply',title : '申请退款金额',align : 'center', width : '180'},
		{field : 'amount',title : '实退金额',align : 'center', width : '180'},
		{field : 'truename',title : '会员',align : 'center', width : '180'},
		{field : 'supplier_name',title : '供应商',align : 'left', width : '180'},
		{field : 'beizhu',title : '审批备注',align : 'left', width : '180'},
		{field : 'username',title : '审批人',align : 'center', width : '180'}
	];
//已拒绝
var columns3 = [ {field : null,title : '订单编号',width : '150',align : 'center',formatter:function(item){
					return '<a href="/admin/a/orders/order/order_detail_info?id='+item.order_id+'" target="_blank">'+item.ordersn+'</a>';
			}
		},
		{field : 'productname',title : '产品名称',width : '200',align : 'left',length:15},
		{field : 'cityname',title : '出发地',width : '140',align : 'left'},
		{field : 'addtime',title : '申请时间',align : 'left', width : '200'},
		{field : 'amount_apply',title : '申请退款金额',align : 'center', width : '180'},
		{field : 'amount',title : '实退金额',align : 'center', width : '180'},
		{field : 'truename',title : '会员',align : 'center', width : '180'},
		{field : 'supplier_name',title : '供应商',align : 'left', width : '180'},
		{field : 'beizhu',title : '拒绝原因',align : 'left', width : '180'},
		{field : 'username',title : '审批人',align : 'center', width : '180'}
	];

//初始加载
var initial_status = $('input[name="status"]').val();
change_status(initial_status); 

//导航栏切换
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('status')
	$('input[name="status"]').val(status);
	$('input[name="page_new"]').val(1);
	change_status(status);
})
//搜索
$('#search_condition').submit(function(){
	var status = $('input[name="status"]').val();
	$('input[name="page_new"]').val(1);
	change_status(status);
	return false;	
})

//根据状态加载数据
function change_status(status) {
	var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
	if (status == 0) { //申请中
		ajaxGetData(columns1 ,inputId);
	} else if(status == 1) { //已通过
		ajaxGetData(columns2 ,inputId);
	} else if (status == 2) { //已拒绝 
		ajaxGetData(columns3 ,inputId);
	}
}
//关闭弹出
function colse_box() {
	$('.eject_body').hide();
}
//退回申请
function refund_show(id){
	$("input[name='refund_id']").val(id);
	$(".refund_apply").show();
}
var r = true;
$(".refund_submit").click(function(){
	if (r == false) {
		return false;
	} else {
		r = false;
	}
	var beizhu = $("textarea[name='refund_beizhu']").val();
	var id = $("input[name='refund_id']").val();
	$.post("/admin/a/finance/refund_return",{id:id,beizhu:beizhu},function(json){
		r = true;
		var data = eval('('+json+')');
		if (data.code == 2000) {
			alert(data.msg);
			$('.eject_body').hide();
			change_status(0);
		} else {
			alert(data.msg);
		}
	});
})
//通过申请
function through_show(id,amount_apply,money) {
	$("input[name='through_id']").val(id);
	$("input[name='total_price']").val(money);
	$("input[name='amount_apply']").val(amount_apply).attr('maxNumber',money);
	$(".through_apply").show();
}
var t = true;
$(".through_submit").click(function(){
	if (t == false) {
		return false;
	} else {
		t = false;
	}
	var id = $("input[name='through_id']").val();
	var money = $("input[name='amount_apply']").val();
	var beizhu = $("textarea[name='through_beizhu']").val();
	$.post("/admin/a/finance/refund_through",{id:id,beizhu:beizhu,money:money},function(json){
		t = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			alert(data.msg);
			$('.eject_body').hide();
			change_status(0);
		} else {
			alert(data.msg);
		}
	});
})
//新增退款弹出
$("#add_refund").click(function(){
	$('.add_refund_box').show();
})
function colse_order_box(){
	$(".choice_order_box").hide();
}
//点击订单号输入框选择订单
var columns = [ {field : null,title : '订单编号',width : '150',align : 'center',formatter:function(item){
							return '<a href="/admin/a/order/order_detail_info?id='+item.id+'" target="_blank">'+item.ordersn+'</a>';
						}
					},
					{field : 'productname',title : '产品名称',width : '200',align : 'left',length:15},
					{field : 'linkman',title : '预订人',width : '140',align : 'left'},
					{field : 'supplier_name',title : '供应商',align : 'left', width : '200'},
					{field : null,title : '参团人数',align : 'center', width : '180',formatter:function(item){
							return parseInt(item.childnobednum) + parseInt(item.childnum) + parseInt(item.dingnum);
						}
					},
					{field : 'money',title : '支付金额',align : 'center', width : '180'},
					{field : 'usedate',title : '出团日期',align : 'center', width : '180'},
					{field : 'addtime',title : '下单时间',align : 'left', width : '180'},
					{field : null,title : '操作',align : 'left', width : '180',formatter:function(item){
							return '<a href="javascript:void(0);" onclick="choice_order(this);" money="'+item.money+'" order_id="'+item.id+'" ordersn="'+item.ordersn+'" ><button class="operation_button">选择</button></a>';
						}
					},
				];
var orderInputId = {'formId':'choice_order_form','title':'choice_order_title','body':'choice_order_data','page':'choice_order_page'};
$("input[name='add_ordersn']").click(function(){
	ajaxGetData(columns ,orderInputId);
	$(".choice_order_box").show();
})
$(".box_button").click(function(){
	ajaxGetData(columns ,orderInputId);
	return false;
})
function choice_order(obj) {
	var money = $(obj).attr('money');	
	var ordersn = $(obj).attr('ordersn');
	var order_id = $(obj).attr('order_id');
	$("input[name='add_ordersn']").val(ordersn);
	$("input[name='add_orderId']").val(order_id);
	$(".inputDecimalMax").val(money).attr('maxNumber',money);
	$(".choice_order_box").hide();
}
var a = true;
$(".add_submit").click(function(){
	if (a == false) {
		return false;
	} else {
		a = false;
	}
	var money = $("input[name='add_amount_apply']").val();;	
	var order_id = $("input[name='add_orderId']").val();
	var reason = $("textarea[name='add_reason']").val();
	$.post("/admin/a/finance/add_refund" ,{id:order_id,money:money,reason:reason},function(json){
		a = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	})
})
 </script>

 