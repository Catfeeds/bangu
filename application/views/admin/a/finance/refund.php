<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
	.form-control{ width: 200px; margin-right: 15px;}
	.form-group { float:left;}
	.col_span { margin-top:4px;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">退款审批</li>
		</ul>
	</div>
	
	<div class="page-body">
		<a id="add_refund" href="javascript:void(0);" style="margin-bottom: 10px;" class="btn btn-default">新增退款 </a>
		<br/>
		<ul class="nav nav-tabs" id="changeNavTab">
			<li class="active" data-val="0"><a>申请中 </a></li>
			<li class="tab-red" data-val="1"><a>已通过</a></li>
			<li class="tab-blue" data-val="2"><a>已拒绝</a></li>
		</ul>
		<div class="tab-content clear">
			<form action="<?php echo site_url('admin/a/finance/getRefundJson');?>" id='search_condition' method="post">
				<div class="form-group">
					<span class="search_title col_span">产品名称:</span>
					<input type="text" class="form-control col_ip" name="linename">
				</div>
				<div class="form-group">
					<span class="search_title col_span">订单编号:</span>
					<input type="text" class="form-control col_ip" name="ordersn">
				</div>
				<div class="form-group">
					<span class="search_title col_span">会员名称:</span>
					<input type="text" class="form-control col_ip" name="nickname">
				</div>
				<div class="form-group">
					<span class="search_title col_span">申请时间:</span>
					<input type="text" style="width: 120px;" class="form-control col_ip" placeholder="开始时间" name="starttime" id="starttime">
					<input type="text" style="width: 120px;" class="form-control col_ip" placeholder="结束时间" name="endtime" id="endtime">
				</div>
				<input type="hidden" name="status" value="0" />
				<input type="submit" value="搜索" class="btn btn-darkorange active" />
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<!-- 退回申请 -->
<div class="eject_body refund_apply" style="width:30%;">
	<div class="eject_colse ex_colse" onclick="colse_box();">X</div>
	<div class="eject_title">拒绝申请</div>
	<div class="eject_content">
		<div class="eject_content_text">
			<div class="eject_text_name">拒绝原因:</div>
			<div class="eject_text_info"><textarea name="refund_beizhu" rows="5" cols="50"></textarea></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="refund_id" />
			<div class="ex_colse" onclick="colse_box();">关闭</div>
			<div class="refund_submit">确认拒绝</div>
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
<!-- 退款选择订单 -->
<div class="eject_body choice_order_box" style="width:80%;margin-left:-11%;min-height:420px;">
	<div class="eject_colse ex_colse" onclick="colse_order_box();">X</div>
	<div class="eject_title">选择退款订单</div>
	<div class="eject_content">
		<div class="box_form">
			<form action="<?php echo site_url('admin/a/finance/getOrderChoiceData') ?>" method="post" id="choice_order_form">
				<input type="text" name="choice_ordersn" placeholder="订单编号" maxlength="12" />
				<input type="text" name="choice_linename" placeholder="产品名称"  />
				<input type="text" name="choice_supplier" placeholder="供应商名称" />
				<button class="box_button">搜索</button>
			</form>
		</div>
		<div class="box_data" id="box_data"></div>
	</div>						
</div>

<div class="modal-backdrop fade in" style="display: none;"></div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>
var columns = [ {field : false,title : '订单号',width : '130',align : 'center',formatter:function(item){
						return '<a href="/admin/a/orders/order/order_detail_info?id='+item.order_id+'" target="_blank">'+item.ordersn+'</a>';
					}
				},
				{field : 'linename',title : '产品名称',width : '200',align : 'center'},
				{field : 'cityname',title : '出发城市',align : 'center', width : '140'},
				{field : 'addtime',title : '申请时间',align : 'center', width : '130'},
				{field : 'amount_apply',title : '申请退款金额',align : 'center', width : '90'},
				{field : 'nickname',title : '会员名称',align : 'center', width : '140'},
				{field : 'supplier_name',title : '供应商',align : 'center', width : '160'},
				{field : 'expert_name',title : '管家',align : 'center', width : '120'},
				{field : 'reason',title : '申请备注',align : 'center', width : '120'},
				{field : false,title : '操作',align : 'center', width : '120',formatter: function(item) {
					var button = "<a href='javascript:void(0);' data-price='"+item.total_price+"' data-val='"+item.id+"' data-amount='"+item.amount_apply+"' onclick='through(this)' class='btn btn-info btn-xs edit'>通过</a>&nbsp;";
					button += "<a href='javascript:void(0);' onclick='refund("+item.id+")' class='btn btn-info btn-xs edit'>拒绝</a>";
					return button;
				}
			}];
var columns1 = [ {field : false,title : '订单号',width : '130',align : 'center',formatter:function(item){
						return '<a href="/admin/a/orders/order/order_detail_info?id='+item.order_id+'" target="_blank">'+item.ordersn+'</a>';
					}
				},
				{field : 'linename',title : '产品名称',width : '200',align : 'center'},
				{field : 'cityname',title : '出发城市',align : 'center', width : '140'},
				{field : 'addtime',title : '申请时间',align : 'center', width : '130'},
				{field : 'amount_apply',title : '申请退款金额',align : 'center', width : '90'},
				{field : 'amount',title : '实退金额',align : 'center', width : '90'},
				{field : 'nickname',title : '会员名称',align : 'center', width : '140'},
				{field : 'supplier_name',title : '供应商',align : 'center', width : '160'},
				{field : 'expert_name',title : '管家',align : 'center', width : '120'},
				{field : 'beizhu',title : '审批备注',align : 'center', width : '120'},
				{field : 'username',title : '审批人',align : 'center', width : '120'}];	
							
var columns2 = [ {field : false,title : '订单号',width : '130',align : 'center',formatter:function(item){
						return '<a href="/admin/a/orders/order/order_detail_info?id='+item.order_id+'" target="_blank">'+item.ordersn+'</a>';
					}
				},
 				{field : 'linename',title : '产品名称',width : '200',align : 'center'},
 				{field : 'cityname',title : '出发城市',align : 'center', width : '140'},
 				{field : 'addtime',title : '申请时间',align : 'center', width : '130'},
 				{field : 'amount_apply',title : '申请退款金额',align : 'center', width : '90'},
 				{field : 'nickname',title : '会员名称',align : 'center', width : '140'},
 				{field : 'supplier_name',title : '供应商',align : 'center', width : '160'},
 				{field : 'expert_name',title : '管家',align : 'center', width : '120'},
 				{field : 'beizhu',title : '拒绝原因',align : 'center', width : '120'},
 				{field : 'username',title : '审批人',align : 'center', width : '120'}];
									
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/finance/getRefundJson',
	searchForm:'#search_condition',
	pageNumNow:1
});

$("#changeNavTab li").click(function() {
	$("#search_condition").find("input[type=text]").val('');
	var status = $(this).attr("data-val");
	$("input[name='status']").val(status);
	$(this).addClass("active").siblings("li").removeClass("active");
	if (status == 0) {
		$("#dataTable").pageTable({
			columns:columns,
			url:'/admin/a/finance/getRefundJson',
			searchForm:'#search_condition',
			pageNumNow:1
		});
	} else if (status == 1) {
		$("#dataTable").pageTable({
			columns:columns1,
			url:'/admin/a/finance/getRefundJson',
			searchForm:'#search_condition',
			pageNumNow:1
		});
	} else if (status == 2) {
		$("#dataTable").pageTable({
			columns:columns2,
			url:'/admin/a/finance/getRefundJson',
			searchForm:'#search_condition',
			pageNumNow:1
		});
	}
})
function refund(id) {
	$("textarea[name=refund_beizhu]").val('');
	$("input[name=refund_id]").val(id);
	$(".modal-backdrop,.refund_apply").fadeIn(500);
}
$(".refund_submit").click(function(){
	$.ajax({
		url:"/admin/a/finance/refund_return",
		type:"post",
		dataType:"json",
		data:{id:$("input[name=refund_id]").val(),beizhu:$("textarea[name=refund_beizhu]").val()},
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/finance/getRefundJson',
					searchForm:'#search_condition',
					pageNumNow:1
				});
				$(".modal-backdrop,.refund_apply").fadeOut(500);
			} else {
				alert(data.msg);
			}
		}
	});
})
function through(obj) {
	var price = $(obj).attr("data-price");
	$("input[name=total_price]").val(price);
	$("input[name=amount_apply]").val($(obj).attr("data-amount")).attr("maxNumber",price);
	$("input[name=through_id]").val($(obj).attr("data-val"));
	$("textarea[name=through_beizhu]").val('');
	$(".modal-backdrop,.through_apply").fadeIn(500);
}
$(".through_submit").click(function(){
	$.ajax({
		url:"/admin/a/finance/through_refund",
		type:"post",
		dataType:"json",
		data:{id:$("input[name=through_id]").val(),money:$("input[name=amount_apply]").val(),beizhu:$("textarea[name=through_beizhu]").val()},
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/finance/getRefundJson',
					searchForm:'#search_condition',
					pageNumNow:1
				});
				$(".modal-backdrop,.through_apply").fadeOut(500);
			} else {
				alert(data.msg);
			}
		}
	});
})
function colse_box() {
	$(".refund_apply,.modal-backdrop,.through_apply,.add_refund_box").fadeOut(500);
}
function colse_order_box() {
	$(".choice_order_box").fadeOut(500);
}
	//新增退款弹出层
	$("#add_refund").click(function(){
		$("input[name=add_ordersn]").val('');
		$("input[name=add_amount_apply]").val('');
		$("input[name=add_orderId]").val('');
		$("textarea[name=add_reason]").val('');
		$(".add_refund_box,.modal-backdrop").fadeIn(500);
	})
	//选择订单
	var order_columns = [ {field : false,title : '订单号',width : '130',align : 'center',formatter:function(item){
								return '<a href="/admin/a/orders/order/order_detail_info?id='+item.id+'" target="_blank">'+item.ordersn+'</a>';
							}
						},
						{field : 'productname',title : '产品名称',width : '200',align : 'center'},
						{field : 'cityname',title : '出发城市',align : 'center', width : '140'},
						{field : 'linkman',title : '预订人',align : 'center', width : '130'},
						{field : 'supplier_name',title : '供应商',align : 'center', width : '160'},
						{field : 'expert_name',title : '管家',align : 'center', width : '120'},
						{field : false,title : '支付金额',align : 'center', width : '120',formatter:function(item){
								return (item.first_pay*1+item.final_pay*1).toFixed(2);
							}
						},
						{field : false,title : '操作',align : 'center', width : '120',formatter: function(item) {
							return "<a href='javascript:void(0);' data-val='"+item.id+"' data-money='"+(item.first_pay*1+item.final_pay*1).toFixed(2)+"' data-sn='"+item.ordersn+"' onclick='choice(this)' class='btn btn-info btn-xs edit'>选择</a>";
						}
					}];
	$("input[name='add_ordersn']").click(function(){
		$("#box_data").pageTable({
			columns:order_columns,
			url:'/admin/a/finance/getOrderChoiceData',
			searchForm:'#choice_order_form',
			pageNumNow:1
		});
		$(".choice_order_box").show();
	})
	$(".box_button").click(function(){
		$("input[name=page]").val(1);
		ajaxGetData(order_columns ,orderInputId);
		return false;
	})
	function choice(obj) {
		var money = $(obj).attr('data-money');	
		$("input[name='add_ordersn']").val($(obj).attr('data-sn'));
		$("input[name='add_orderId']").val($(obj).attr('data-val'));
		$(".inputDecimalMax").val(money).attr('maxNumber',money);
		$(".choice_order_box").hide();
	}
//确认新增
$(".add_submit").click(function(){
	$.ajax({
		url:"/admin/a/finance/add_refund",
		type:"post",
		dataType:"json",
		data:{order_id:$("input[name=add_orderId]").val(),money:$("input[name=add_amount_apply]").val(),reason:$("textarea[name=add_reason]").val()},
		success:function(data) {
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		}
	});
})

$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
</script>