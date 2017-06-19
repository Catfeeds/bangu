<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
	<style type="text/css">
		.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
		.yourclass .layui-layer-content{ padding:20px;}
		/*详情 start*/
		.order_detail{margin-bottom: 20px;}
		.but-list{
			text-align: right;
			margin-top: 10px;
		}
		.but-list button{
			background: rgb(255, 255, 255) none repeat scroll 0% 0%;
			border: 1px solid rgb(204, 204, 204);
			padding: 3px;
			border-radius: 3px;
			cursor: pointer;
			margin-left: 10px;
		}
		.but-list button:hover{background: #2dc3e8;color: #fff;}
		.table_td_border > tbody > tr > td {
		    width: 40%;
		}
		.tionRela span{position:absolute; top:0; left:0}
		.tionRela{position: relative; padding-left:60px;margin-top: 10px;}
		/*详情 end*/
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">C端订单导出</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group search-time">
                            	<label>出团日期</label>
                                <input type="text" name="starttime" value="<?php echo $starttime?>" class="search_input" id="starttime" placeholder="开始时间"/>
                                <input type="text" name="endtime" value = '<?php echo $endtime?>'class="search_input" id="endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            	<input type="button" class="search_button export-button" value="导出">
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>

var columns = [ {field : 'ordersn',title : '订单编号',width : '100',align : 'center'},
        		{field : 'usedate',title : '出团日期',width : '80',align : 'center'},
        		{field : 'cityname',title : '出发城市',width : '70',align : 'center'},
        		{field : 'total_price',title : '订单金额',align : 'center', width : '60'},
        		{field : 'settlement_price',title : '保险金额',align : 'center', width : '60'},
        		{field : 'agent_fee',title : '管家佣金',align : 'center', width : '60'},
        		{field : 'platform_fee',title : '平台佣金',align : 'center', width : '60'},
        		{field : 'settlement_fee',title : '供应商结算金额',align : 'center', width : '100'},
        		{field : 'num',title : '人数',align : 'center', width : '50'},
        		{field : false,title : '订单状态',align : 'center', width : '80',formatter:function(result) {
						if (result.status == -4) {
							return result.ispay == 0 ? '已取消' : '已退团';
						} else if(result.status == -3) {
							return '退订中';
						} else if (result.status == 0) {
							if (result.ispay == 0) {
								return '未付款';
							} else if (result.ispay == 1) {
								return '付款审核中';
							} else if (result.ispay == 2) {
								return '已付款待确认';
							} else{
								return '未知';
							}
						} else if (result.status == 4) {
							return '已确认';
						} else if (result.status == 5) {
							return '出团中';
						} else if (result.status == 6) {
							return '已评论';
						} else if (result.status == 7) {
							return '已投诉';
						} else if (result.status == 8) {
							return '出团结束';
						} else {
							return '未知';
						}
            		}
            	},
        		{field : 'expert_name',title : '管家',align : 'center', width : '70'},
        		{field : 'admin_name',title : '审核人',align : 'center', width : '70'},
        		{field : 'supplier_name',title : '供应商',align : 'center', width : '120'},
        		{field : 'linename',title : '产品名称 ',align : 'center', width : '200'}];
        	
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/statistics/export_order/getOrderData',
	pageSize:10,
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});

$('.export-button').click(function(){
	$.ajax({
		url:'/admin/a/statistics/export_order/exportExcel',
		data:$('#search-condition').serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				window.location.href=result.msg;
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
})


$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false
});
</script>
</html>


