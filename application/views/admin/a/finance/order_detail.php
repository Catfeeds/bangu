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
			<li class="active header_name">收款管理</li>
		</ul>
	</div>
	<div class="page-body">
		<ul class="nav nav-tabs" id="changeNavTab">
			<li class="active" data-val="0"><a>申请中 </a></li>
			<li class="tab-red" data-val="1"><a>已通过</a></li>
			<li class="tab-blue" data-val="-1"><a>已拒绝</a></li>
		</ul>
		<div class="tab-content clear">
			<form action="<?php echo site_url('admin/a/finance/getOrderDetailJson');?>" id='search_condition' method="post">
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
				<input type="hidden" name="status" value="0" />
				<input type="submit" value="搜索" class="btn btn-darkorange active" />
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div id="orderDetail"></div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.detailbox.js") ;?>"></script>
<script>
var columns = [ {field : 'receipt',title : '流水号',width : '130',align : 'center'},
				{field : 'ordersn',title : '订单编号',width : '90',align : 'center'},
				{field : 'linename',title : '产品名称',width : '200',align : 'center'},
				{field : 'cityname',title : '出发城市',align : 'center', width : '140'},
				{field : 'addtime',title : '付款时间',align : 'center', width : '130'},
				{field : 'amount',title : '收款金额',align : 'center', width : '90'},
				{field : 'nickname',title : '会员名称',align : 'center', width : '140'},
				{field : 'supplier_name',title : '供应商',align : 'center', width : '110'},
				{field : 'expert_name',title : '管家',align : 'center', width : '160'},
				{field : 'beizhu',title : '备注',align : 'center', width : '120'},
				{field : false,title : '操作',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>审核</a>";;
				}
			}];
var columns1 = [ {field : 'receipt',title : '流水号',width : '130',align : 'center'},
				{field : 'ordersn',title : '订单编号',width : '90',align : 'center'},
				{field : 'linename',title : '产品名称',width : '200',align : 'center'},
				{field : 'cityname',title : '出发城市',align : 'center', width : '140'},
				{field : 'approvetime',title : '审批时间',align : 'center', width : '130'},
				{field : 'amount',title : '收款金额',align : 'center', width : '90'},
				{field : 'nickname',title : '会员名称',align : 'center', width : '110'},
				{field : 'supplier_name',title : '供应商',align : 'center', width : '140'},
				{field : 'expert_name',title : '管家',align : 'center', width : '110'},
				{field : 'description',title : '发票主体',align : 'center', width : '110'},
				{field : 'refuse_reason',title : '审批备注',align : 'center', width : '160'},
				{field : 'adminname',title : '审批人',align : 'center', width : '120'}];	
						
var columns2 = [ {field : 'receipt',title : '流水号',width : '130',align : 'center'},
				{field : 'ordersn',title : '订单编号',width : '90',align : 'center'},
				{field : 'linename',title : '产品名称',width : '200',align : 'center'},
				{field : 'cityname',title : '出发城市',align : 'center', width : '140'},
				{field : 'approvetime',title : '审批时间',align : 'center', width : '130'},
				{field : 'amount',title : '收款金额',align : 'center', width : '90'},
				{field : 'nickname',title : '会员名称',align : 'center', width : '110'},
				{field : 'supplier_name',title : '供应商',align : 'center', width : '140'},
				{field : 'expert_name',title : '管家',align : 'center', width : '110'},
				{field : 'refuse_reason',title : '拒绝原因',align : 'center', width : '160'},
				{field : 'adminname',title : '审批人',align : 'center', width : '120'}];
						
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/finance/getOrderDetailJson',
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
			url:'/admin/a/finance/getOrderDetailJson',
			searchForm:'#search_condition',
			pageNumNow:1
		});
	} else if (status == 1) {
		$("#dataTable").pageTable({
			columns:columns1,
			url:'/admin/a/finance/getOrderDetailJson',
			searchForm:'#search_condition',
			pageNumNow:1
		});
	} else if (status == -1) {
		$("#dataTable").pageTable({
			columns:columns2,
			url:'/admin/a/finance/getOrderDetailJson',
			searchForm:'#search_condition',
			pageNumNow:1
		});
	}
	
})
//查看定制单详细
function detail(id) {
	$.ajax({
		type:"POST",
		url:"/admin/a/finance/getOrderDetailData",
		dataType:"json",
		data:{id:id},
		success:function(data) {
			if ($.isEmptyObject(data) === false) {
				see_detail(data);
			} else {
				alert("请确认您选择的数据");
			}
		}
	});
}
var dicStr = '';
var dictionary = <?php echo empty($dictionary) ? '' :json_encode($dictionary);?>;
if (dictionary.length > 1) {
	$.each(dictionary ,function(k ,v){
		dicStr += '<input type="radio" name="invoice_entity" style="position:static;opacity:1;" value="'+v.dict_id+'">'+v.description;
	})
}
function see_detail(detailArr) {
	var data = detailArr.detail;
	var picArr = detailArr.picArr;
	var picHtml = '';
	if (!$.isEmptyObject(picArr)) {
		$.each(picArr ,function(k ,v) {
			picHtml += '<a href="'+v.pic+'" target="_blank"><img src="'+v.pic+'" style="width:80px;margin-right: 10px;cursor: pointer;" /></a>';
		})
	}
	var customize = {
				"开户名":{content:data.account_name},
				"打款账号":{content:data.bankcard},
				"流水号":{content:data.receipt},
				"订单号":{content:data.ordersn},
				"收款日期":{content:data.addtime},
				"收款金额":{content:data.amount},
				"打款银行":{content:data.bankname},
				"客单发票主体":{content:dicStr},
				"流水单扫描件":{content:picHtml,width:"100%"},
				"申请备注":{content:data.beizhu,width:"100%"},
				"审批意见":{content:"<textarea name='refuse_reason' style='width:100%;height:120px;'></textarea>",width:"100%"}
			};
	$.fn.detailbox.createButton = function(){
		var html = "<input type='hidden' value='"+data.id+"' name='detail_id'><div class='od_refuse'>拒绝</div><div class='od_through'>通过</div>";
		$("#orderDetail .button-list .colse-detail-box").siblings().remove();
		$("#orderDetail").find(".button-list").append(html);
	}
	$.fn.detailbox.buttonClick = function(){
		$(".od_refuse").click(function(){
			$.ajax({
				type:"post",
				url:"/admin/a/finance/refuse_order_detail",
				dataType:"json",
				data:{id:data.id,refuse_reason:$("#orderDetail").find("textarea[name='refuse_reason']").val()},
				success:function(data) {
					if (data.code == 2000) {
						$("#dataTable").pageTable({
							columns:columns,
							url:'/admin/a/finance/getOrderDetailJson',
							searchForm:'#search_condition',
							pageNumNow:1
						});
						alert(data.msg);
						$(".mask-layer,#orderDetail").fadeOut(500);
					} else {
						alert(data.msg);
					}
				}
			});
		})
		$(".od_through").click(function(){
			$.ajax({
				type:"post",
				url:"/admin/a/finance/through_order_detail",
				dataType:"json",
				data:{id:data.id,refuse_reason:$("#orderDetail").find("textarea[name='refuse_reason']").val(),invoice_entity:$('input[name=invoice_entity]:checked').val()},
				success:function(data) { 
					if (data.code == 2000) {
						$("#dataTable").pageTable({
							columns:columns,
							url:'/admin/a/finance/getOrderDetailJson',
							searchForm:'#search_condition',
							pageNumNow:1
						});
						alert(data.msg);
						$(".mask-layer,#orderDetail").fadeOut(500);
					} else {
						alert(data.msg);
					}
				}
			});
		})
	}
	$("#orderDetail").detailbox({
			data:customize,
			titleName:"收款登记"
		});
	$('#orderDetail').show();
}
</script>