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
<div class="page_content bg_gray" style="display: none;" id="cashsubs">
	<div class="box-title">
        <h5>拒绝原因</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <hr>
    <div class="fb-form">
    	<h4>请输入拒绝原因</h4>
        <div>
        <textarea rows="10" cols="80" placeholder="请输入拒绝原因"></textarea>
        </div>
    </div>
    <div class="form_btn">
        	<button class="sure_btn">确定</button>
        	<button class="delete_btn">取消</button>
        </div>
</div>

<div class="page_content bg_gray" style="display: none;" id="cashsub">
	<div class="box-title">
        <h5>达人证明材料</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <hr>
    <div class="fb-form">
    	<div>
        	<h4>实名认证</h4>
        	<table class="table_span_pd" cellspacing="0">
        	<tr>
	        	<td class=""><img src="<?php echo base_url("assets/img/avatars/divyia.jpg") ;?>"/></td>
	            <td style=""><img src="<?php echo base_url("assets/img/avatars/divyia.jpg") ;?>"/></td>
	        </tr>
            </table>
        </div>
        <div>
        	<h4>微博粉丝认证</h4>
        	<table class="table_span_pd" cellspacing="0">
        	<tr>
	        	<td class=""><img src="<?php echo base_url("assets/img/avatars/divyia.jpg") ;?>"/></td>
	            <td style=""><img src="<?php echo base_url("assets/img/avatars/Stephanie-Walter.jpg") ;?>"/></td>
	            <td class=""><img src="<?php echo base_url("assets/img/avatars/Stephanie-Walter.jpg") ;?>"/></td>
	            <td style=""><img src="<?php echo base_url("assets/img/avatars/divyia.jpg") ;?>"/></td>
	        </tr>
            </table>
        </div>
        <div>
        	<h4>导游领队认证</h4>
        	<table class="table_span_pd" cellspacing="0">
        	<tr>
	        	<td class=""><img src="<?php echo base_url("assets/img/avatars/Stephanie-Walter.jpg") ;?>"/></td>
	            <td style=""><img src="<?php echo base_url("assets/img/avatars/Stephanie-Walter.jpg") ;?>"/></td>
	            <td class=""><img src="<?php echo base_url("assets/img/avatars/Stephanie-Walter.jpg") ;?>"/></td>
	            <td style=""><img src="<?php echo base_url("assets/img/avatars/divyia.jpg") ;?>"/></td>
	        </tr>
            </table>
        </div>
        <div>
        	<h4>旅游网达人认证</h4>
        	<table class="table_span_pd" cellspacing="0">
        	<tr>
	        	<td class=""><img src="<?php echo base_url("assets/img/avatars/divyia.jpg") ;?>"/></td>
	            <td style=""><img src="<?php echo base_url("assets/img/avatars/divyia.jpg") ;?>"/></td>
	            <td class=""><img src="<?php echo base_url("assets/img/avatars/Stephanie-Walter.jpg") ;?>"/></td>
	            <td style=""><img src="<?php echo base_url("assets/img/avatars/Stephanie-Walter.jpg") ;?>"/></td>
	        </tr>
            </table>
        </div>
    </div>
</div>

<div class="page-content">

	<div class="page-body">
		<ul class="nav nav-tabs" id="changeNavTab">
			<li class="active" data-val="0"><a>已通过</a></li>
			<li class="tab-red" data-val="1"><a>申请中</a></li>
			<li class="tab-blue" data-val="-1"><a>已拒绝</a></li>
		</ul>
		<div class="tab-content clear">
			<form action="<?php echo site_url('admin/a/finance/getOrderDetailJson');?>" id='search_condition' method="post">
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
				{field : 'cityname',title : '真实姓名',align : 'center', width : '140'},
				{field : 'cityname',title : '身份证号码',align : 'center', width : '140'},
				{field : 'cityname',title : '技能标签',align : 'center', width : '140'},
				{field : 'addtime',title : '打赏收益(U币)',align : 'center', width : '130'},
				{field : 'amount',title : '流量收益(RMB)',align : 'center', width : '90'},
				{field : false,title : '证明材料',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>查看</a>";
				}
			}];
var columns1 = [ {field : 'receipt',title : '用户账号',width : '130',align : 'center'},
				{field : 'ordersn',title : '用户昵称',width : '90',align : 'center'},
				{field : 'linename',title : '申请时间',width : '200',align : 'center'},
				{field : 'cityname',title : '真实姓名',align : 'center', width : '140'},
				{field : 'cityname',title : '身份证号码',align : 'center', width : '140'},
				{field : false,title : '其他平台认证资料',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>查看</a>";
				}},
				{field : 'cityname',title : '技能标签',align : 'center', width : '140'},
				{field : false,title : '证明材料',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>通过</a><a href='javascript:void(0);' onclick='refuse("+item.id+")' class='btn btn-info btn-xs edit'>拒绝</a>";
				}}]	
						
var columns2 = [ {field : 'receipt',title : '用户账号',width : '130',align : 'center'},
				{field : 'ordersn',title : '用户昵称',width : '90',align : 'center'},
				{field : 'linename',title : '申请时间',width : '200',align : 'center'},
				{field : 'cityname',title : '真实姓名',align : 'center', width : '140'},
				{field : 'cityname',title : '身份证号码',align : 'center', width : '140'},
				{field : false,title : '其他平台认证资料',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='detail("+item.id+")' class='btn btn-info btn-xs edit'>查看</a>";
				}},
				{field : 'cityname',title : '技能标签',align : 'center', width : '140'},
				{field : 'addtime',title : '拒绝原因',align : 'center', width : '130'}]	
						
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
           content: $('#cashsubs')
     });
}
</script>
