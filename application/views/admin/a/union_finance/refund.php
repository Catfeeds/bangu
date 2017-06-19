<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
	<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
	<style type="text/css">
		.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
		.yourclass .layui-layer-content{ padding:20px;}
		.search-time input{width:110px;}
		.search_admin {display:none;}
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
		.layui-layer-page { margin-left:0px;}
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">退款/退团审批</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav">
                        <li data-val="3"><a href="#" class="active">待转款</a></li> 
                        <li data-val="4"><a href="#" class="">已转款</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>产品名称</label>
                                <input type="text" name="linename" class="search_input" placeholder="产品名称"/>
                            </div>
                            <div class="search_group">
                            	<label>订单编号</label>
                                <input type="text" name="ordersn" class="search_input" placeholder="订单编号"/>
                            </div>
                            <div class="search_group search-time">
                            	<label>出团时间</label>
                                <input type="text" name="starttime" class="search_input" id="starttime" placeholder="开始时间"/>
                                <input type="text" name="endtime" class="search_input" id="endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                            	<label>团队编号</label>
                                <input type="text" name="item_code" class="search_input" placeholder="团队编号"/>
                            </div>
                            <div class="search_group">
                            	<label>销售名称</label>
                                <input type="text" name="expert_name" class="search_input" placeholder="销售名称"/>
                            </div>
                            <div class="search_group">
                            	<label>目的地</label>
                                <input type="text" name="destname" id="destinations" class="search_input" placeholder="目的地"/>
                            </div>
                            <div class="search_group">
                            	<label>出发地</label>
                                <input type="text" name="startcity" id="startcity" class="search_input" placeholder="出发地"/>
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="status" value="3">
                            	<input type="submit" value="搜索" class="search_button">
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
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<script>
var columns3 = [ {field : false,title : '订单编号',width : '100',align : 'center' ,formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="order_detail('+result.order_id+')" class="action_type">'+result.ordersn+'</a>';
					}
				},
        		{field : 'item_code',title : '团队编号',width : '100',align : 'center'},
        		{field : 'linename',title : '线路名称',width : '140',align : 'center'},
        		{field : false,title : '参团人数',align : 'center', width : '60',formatter:function(result) {
						return result.dingnum*1+result.childnum*1+result.childnobednum*1+result.oldnum*1;
            		}
        		},
        		{field : 'usedate',title : '出团日期',align : 'center', width : '90'},
        		{field : 'lineday',title : '行程天数',align : 'center', width : '60'},
        		{field : 'platform_fee',title : '管理费',align : 'center', width : '60'},
        		{field : 'total_price',title : '订单金额',align : 'center', width : '90'},
        		{field : 'money',title : '已收款',align : 'center', width : '90'},
        		{field : false,title : '结算价',align : 'center', width : '90' ,formatter:function(result) {
						return (result.supplier_cost - result.platform_fee).toFixed(2);
            		}
        		},
        		{field : 'balance_money',title : '已结算',align : 'center', width : '120'},
        		{field : 'depart_name',title : '销售部门',align : 'center', width : '140'},
        		{field : 'expert_name',title : '销售员',align : 'center', width : '110'},
        		{field : 'sk_money',title : '退款金额',align : 'center', width : '90'},
        		{field : false,title : '操作',align : 'center', width : '60',formatter:function(result) {
        				return '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">审核</a>';
        				//return '<a href="/admin/a/union_finance/refund/detail?id='+result.id+'" target="_blank" class="action_type">审核</a>';
            		}
        		}]
        		
var columns4 = [ {field : false,title : '订单编号',width : '100',align : 'center' ,formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="order_detail('+result.order_id+')" class="action_type">'+result.ordersn+'</a>';
					}
				},
				{field : 'item_code',title : '团队编号',width : '100',align : 'center'},
				{field : 'linename',title : '线路名称',width : '140',align : 'center'},
				{field : false,title : '参团人数',align : 'center', width : '60',formatter:function(result) {
						return result.dingnum*1+result.childnum*1+result.childnobednum*1+result.oldnum*1;
					}
				},
				{field : 'usedate',title : '出团日期',align : 'center', width : '90'},
				{field : 'lineday',title : '行程天数',align : 'center', width : '60'},
				{field : 'platform_fee',title : '管理费',align : 'center', width : '60'},
				{field : 'total_price',title : '订单金额',align : 'center', width : '90'},
				{field : 'money',title : '已收款',align : 'center', width : '90'},
				{field : false,title : '结算价',align : 'center', width : '90' ,formatter:function(result) {
						return (result.supplier_cost - result.platform_fee).toFixed(2);
					}
				},
				{field : 'balance_money',title : '已结算',align : 'center', width : '120'},
				{field : 'depart_name',title : '销售部门',align : 'center', width : '140'},
				{field : 'expert_name',title : '销售员',align : 'center', width : '110'},
				{field : 'sk_money',title : '退款金额',align : 'center', width : '90'},
				{field : false,title : '操作',align : 'center', width : '60',formatter:function(result) {
						return '<a href="javascript:void(0)" onclick="detail('+result.id+' ,1)" class="action_type">审核</a>';
					}
				}]


getData(3);
var searchObj = $('#search-condition');
$('.tab-nav').find('li').click(function(){
	var status = $(this).attr('data-val');
	searchObj.find('input[type=text]').val('');
	searchObj.find('input[name=status]').val(status);
	getData(status);
})
function getData(status) {
	if (status == 3) {
		var columns = columns3;
	} else if (status == 4) {
		var columns = columns4;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/union_finance/refund/getOrderRefundJson',
		pageSize:10,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

function order_detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1220px', '600px'],
		  title :'订单信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/orders/order/order_detail_info');?>"+"?id="+id
	});
}


function detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['860px', '600px'],
		  title :'退款退团确认',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/union_finance/refund/detail');?>"+"?id="+id
	});
}


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
$('#m_starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#m_endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});

//目的地
$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.kindname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#destinations",
	    name : "destid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
//出发城市
$.post('/admin/a/comboBox/get_startcity_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.cityname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#startcity",
	    name : "startcity_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
</script>
</html>


