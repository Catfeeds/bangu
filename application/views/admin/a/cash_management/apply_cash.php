<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href='/assets/css/horsey.css' rel='stylesheet' type='text/css' />
<style type="text/css">
	.form-control{ width: 200px; margin-right: 15px;}
	.form-group { float:left;}
	.col_span { margin-top:4px;}
	.page_content { padding:10px; }
	.table_span_pd tr td{ margin:10px;padding-right: 10px; }
	.form_btn{ width: auto;height: auto;margin: 30px; }
	.form_btn .sure_btn{ position: relative;top: 0px;left: 300px; }
	.form_btn .delete_btn{ position: relative;top: 0px;left: 360px; }
	.input_width{ width: 700px; }
	.input_wid{ width: 200px; }
</style>
</head>
<body>
<div class="page_content bg_gray" style="display: none;" id="cashsub">
	<div class="box-title">
        <h5>提现处理</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <hr>
    <div class="fb-form">
    	<h4>用户信息</h4>
        <table class="table_span_pd" width="100%" cellspacing="0">
            <tr>
                <td class="">用户账号:</td>
                <td style=""><span class="">13589632587</span></td>
                <td class="" style="">用户昵称:</td>
                <td><span class="" style="text-align:right;">地对地导弹</span></td>
                <td class="" style="">账户余额:</td>
                <td><span class="" style="text-align:right;">656565</span></td>
                <td class="" style="">可提现余额:</td>
                <td><span class="" style="text-align:right;">54544元</span></td>
            </tr>
            <tr height="40">
                <td class="">真实姓名:</td>
                <td style=""><span class="">滴答滴答</span></td>
                <td class="" style="">身份证号:</td>
                <td><span class="">546546546546546465455</span></td>
                <td class="" style="">银行卡号:</td>
                <td><span class="">546546546546546465455</span></td>
            </tr>
        </table>
        <div>
        	<h4 id="different_h4">提现操作</h4>
        	<table class="table_span_pd" cellspacing="0">
        	<tr>
	        	<td class="">发起提现</td>
	            <td style=""><span style="color: red;text-align:right;">5000元</span></td>
	        </tr>
	        <tr><td>&nbsp;</td></tr>
	        <tr>
	            <td id="different_td">实际提现</td>
	            <td><input type="text" id="different_input"></td>
            </tr>
            </table>
        </div>
        <div class="form_btn">
        	<button class="sure_btn">确定</button>
        	<button class="delete_btn">取消</button>
        </div>
    </div>
</div>

<div class="page-content">

	<div class="page-body">
		<ul class="nav nav-tabs" id="changeNavTab">
			<li class="active" data-val="0"><a>申请中 </a></li>
			<li class="tab-red" data-val="1"><a>已完成</a></li>
			<li class="tab-blue" data-val="-1"><a>已拒绝</a></li>
		</ul>
		<div class="tab-content clear">
			<form action="<?php echo site_url('admin/a/finance/getOrderDetailJson');?>" id='search_condition' method="post">
				<div class="form-group">
					<span class="search_title col_span">时间:</span>
					<input type="text" class="form-control col_ip" name="linename">
				</div>
				<div class="form-group">
					<span class="search_title col_span">用户账号/用户昵称:</span>
					<input type="text" class="form-control col_ip" name="ordersn">
				</div>
				<input type="hidden" name="status" value="0" />
				<input type="submit" value="搜索" class="btn btn-darkorange active" />
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div id="orderDetail"></div>
</body>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url("assets/js/jquery.detailbox.js") ;?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/layer.js"); ?>"></script>
<script>
var columns = [ {field : 'receipt',title : '用户账号',width : '130',align : 'center'},
				{field : 'ordersn',title : '用户昵称',width : '90',align : 'center'},
				{field : 'linename',title : '申请时间',width : '200',align : 'center'},
				{field : 'cityname',title : '账户余额(U币)',align : 'center', width : '140'},
				{field : 'addtime',title : '可提现金额(RMB)',align : 'center', width : '130'},
				{field : 'amount',title : '平台抽成(RMB)',align : 'center', width : '90'},
				{field : 'nickname',title : '提现金额(RMB)',align : 'center', width : '140'},
				{field : 'supplier_name',title : '绑定银行',align : 'center', width : '110'},
				{field : 'expert_name',title : '银行卡号',align : 'center', width : '160'},
				{field : 'beizhu',title : '户名',align : 'center', width : '120'},
				{field : false,title : '操作',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>提现</a><a href='javascript:void(0);' onclick='refuse("+item.id+")' class='btn btn-info btn-xs edit'>拒绝</a>";
				}
			}];
var columns1 = [ {field : 'receipt',title : '用户账号',width : '130',align : 'center'},
				{field : 'ordersn',title : '用户昵称',width : '90',align : 'center'},
				{field : 'linename',title : '申请时间',width : '200',align : 'center'},
				{field : 'cityname',title : '提现金额(RMB)',align : 'center', width : '140'},
				{field : 'approvetime',title : '平台抽成(RMB)',align : 'center', width : '130'},
				{field : 'amount',title : '绑定银行',align : 'center', width : '90'},
				{field : 'nickname',title : '银行卡号',align : 'center', width : '110'},
				{field : 'supplier_name',title : '户名',align : 'center', width : '140'},
				{field : 'expert_name',title : '提现时间',align : 'center', width : '110'},
				{field : 'description',title : '操作人',align : 'center', width : '110'}]	
						
var columns2 = [ {field : 'receipt',title : '用户账号',width : '130',align : 'center'},
				{field : 'ordersn',title : '用户昵称',width : '90',align : 'center'},
				{field : 'linename',title : '申请时间',width : '200',align : 'center'},
				{field : 'cityname',title : '提现金额(RMB)',align : 'center', width : '140'},
				{field : 'approvetime',title : '平台抽成(RMB)',align : 'center', width : '130'},
				{field : 'amount',title : '绑定银行',align : 'center', width : '90'},
				{field : 'nickname',title : '银行卡号',align : 'center', width : '110'},
				{field : 'supplier_name',title : '户名',align : 'center', width : '140'},
				{field : 'expert_name',title : '拒绝原因',align : 'center', width : '110'},
				{field : 'description',title : '操作人',align : 'center', width : '110'}]	
						
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
	// $.ajax({
	// 	type:"POST",
	// 	url:"/admin/a/finance/getOrderDetailData",
	// 	dataType:"json",
	// 	data:{id:id},
	// 	success:function(data) {
	// 		if ($.isEmptyObject(data) === false) {
	// 			see_detail(data);
	// 		} else {
	// 			alert("请确认您选择的数据");
	// 		}
	// 	}
	// });
	layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '850px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#cashsub')
     });
	$("#different_h4").text("提现操作");
	$("#different_td").text("实际提现");
	$("#different_input").removeClass("input_width").addClass("input_wid");
}

function refuse(id) {
	// $.ajax({
	// 	type:"POST",
	// 	url:"/admin/a/finance/getOrderDetailData",
	// 	dataType:"json",
	// 	data:{id:id},
	// 	success:function(data) {
	// 		if ($.isEmptyObject(data) === false) {
	// 			see_detail(data);
	// 		} else {
	// 			alert("请确认您选择的数据");
	// 		}
	// 	}
	// });
	layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '850px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#cashsub')
     });
	$("#different_h4").text("拒绝提现");
	$("#different_td").text("拒绝原因");
	$("#different_input").removeClass("input_wid").addClass("input_width");
}
</script>
