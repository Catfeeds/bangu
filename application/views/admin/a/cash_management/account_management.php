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
	.table_width tr{ height: 50px; }
	.table_width tr td{ width: 80px; }
</style>
</head>
<body>
<div class="page_content bg_gray" style="display: none;" id="cashsub">
	<div class="box-title">
        <h5>提现记录</h5>
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
            </tr>
        </table>
        <div>
        	<h4>绑定银行卡</h4>
        	<table cellspacing="30" class="table_width">
        	<tr style="border-bottom: solid 1px grey;">
	        	<td style="color: red;">2016.12.23</td>
	            <td style="">发起提现</td>
	            <td style="color: orange;">-2000元</td>
	            <td style="color: blue;">状态:申请中</td>
	        </tr>
	        <tr style="border-bottom: solid 1px grey;">
	        	<td style="color: red;">2016.12.23</td>
	            <td style="">发起提现</td>
	            <td style="color: orange;">-2000元</td>
	            <td style="color: green;">状态:已完成</td>
	        </tr>
	        <tr style="border-bottom: solid 1px grey;">
	            <td style="color: red;">2016.12.23</td>
	            <td style="">发起提现</td>
	            <td style="color: orange;">-2000元</td>
	            <td style="color: red;">状态:已拒绝</td>
            </tr>
            </table>
        </div>
    </div>
</div>

<div class="page-content">

	<div class="page-body">
		<div class="tab-content clear">
			<form action="<?php echo site_url('admin/a/finance/getOrderDetailJson');?>" id='search_condition' method="post">
				<div class="form-group">
					<span class="search_title col_span">用户账号/用户昵称:</span>
					<input type="text" class="form-control col_ip" name="ordersn">
				</div>
				<input type="hidden" name="status" value="0" />
				<input type="submit" value="查询" class="btn btn-darkorange active" />
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
				{field : 'linename',title : '注册时间',width : '200',align : 'center'},
				{field : 'cityname',title : '账户余额(U币)',align : 'center', width : '140'},
				{field : 'addtime',title : '打赏获得',align : 'center', width : '130'},
				{field : 'nickname',title : '可提现金额(RMB)',align : 'center', width : '140'},
				{field : 'nickname',title : '流量分成(RMB)',align : 'center', width : '140'},
				{field : 'supplier_name',title : '最后一次提现时间',align : 'center', width : '110'},
				{field : 'expert_name',title : '银行卡号',align : 'center', width : '160'},
				{field : 'beizhu',title : '户名',align : 'center', width : '120'},
				{field : false,title : '操作',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>提现记录</a>";
				}
			}];	
						
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
