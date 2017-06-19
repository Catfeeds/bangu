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
		.search-time input{width:110px;}
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
		.detail-text{margin-top: 10px;}
		.detail-text textarea{padding: 2px 5px;}
		.tionRela span{position:absolute; top:0; left:0}
		.tionRela{position: relative; padding-left:60px;}
		.u_time,.a_time{display:none;}
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">供应商付款审核</a>
        </div>
        
        <div class="page_content bg_gray">
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav">
                   		<li data-val="0"><a href="#" class="active">申请中</a></li> 
                        <li data-val="1"><a href="#" class="">已通过</a></li> 
                        <li data-val="2"><a href="#" class="">已拒绝</a></li>
                    </ul>
                </div>
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>供应商</label>
                                <input type="text" name="supplier_name" class="search_input" />
                            </div>
                            <div class="search_group search-time">
                            	<label>申请日期</label>
                                <input type="text" name="start_addtime" class="search_input" id="start_addtime" placeholder="开始时间"/>
                                <input type="text" name="end_addtime" class="search_input" id="end_addtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group search-time u_time">
                            	<label>审核日期</label>
                                <input type="text" name="start_u_time" class="search_input" id="start_u_time" placeholder="开始时间"/>
                                <input type="text" name="end_u_time" class="search_input" id="end_u_time" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="status" value="0">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
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
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script>
function detail1(id ,type) {
	$.ajax({
		url:'/admin/a/union_finance/payable_apply/detail',
		type:'post',
		data:{id:id},
		dataType:'json',
		success:function(result) {
			if ($.isEmptyObject(result)) {
				layer.alert('没有数据', {icon: 2});
			} else {
				$('#detail-box').find('h2').nextAll().remove();
				//基础信息
				var columnData = [
							{title:'供应商',content : result.supplier_name},
							{title:'旅行社',content : result.union_name},
							{title:'申请时间',content : result.addtime},
							{title:'申请金额',content : result.amount},
							{title:'银行卡号',content : result.bankcard},
							{title:'银行名称',content : result.bankname},
							{title:'开户公司',content : result.bankcompany },
							{title:'申请理由',content : result.remark, type : 'all'},
						];
				createDetailTab('基础信息' ,columnData ,$('#detail-box'));
				
				//关联订单
				getSettlementOrder(result.id ,$('#detail-box') ,result.amount);
				
				//平台审核
				if (result.status == 1 && type == 1) {
					$('#detail-box').append('<div class="detail-text tionRela" style=""><span>审批意见</span><textarea name="reply" rows="4" cols="80"></textarea></div>');
					createDetailBut({'through-but':'通过','refuse-but':'拒绝','layui-layer-close':'关闭'} ,$('#detail-box'));
					but_click(id);
				} else {
					createDetailBut({'layui-layer-close':'关闭'} ,$('#detail-box'));
				}
				layer.open({
					  type: 1,
					  title: false,
					  closeBtn: 0,
					  area: '1200px',
					  shadeClose: false,
					  content: $('#detail-box')
				});
			}
		}
	});
}
function but_click(id) {
	var t = true;
	$('.through-but').click(function(){
		if (t == false) {
			return false;
		} else {
			t = false;
		}
		$.ajax({
			url:'/admin/a/union_finance/payable_apply/through',
			data:{id:id,reply:$('textarea[name=reply]').val()},
			type:'post',
			dataType:'json',
			success:function(result) {
				t = true;
				if (result.code == 2000) {
					$('.layui-layer-close').trigger('click');
					layer.alert(result.msg, {icon: 2});
					getData(1);
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
	})
	$('.refuse-but').click(function(){
		$.ajax({
			url:'/admin/a/union_finance/payable_apply/refuse',
			data:{id:id,reply:$('textarea[name=reply]').val()},
			type:'post',
			dataType:'json',
			success:function(result) {
				if (result.code == 2000) {
					$('.layui-layer-close').trigger('click');
					layer.alert(result.msg, {icon: 2});
					getData(1);
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
	})
}

//结算单订单获取
function getSettlementOrder(id ,boxObj ,money) {
	$('#detail-form').find('input[name=detail_id]').val(id);
	var html = '<div class="content_part"><div class="small_title_txt clear"><span class="txt_info fl">结算订单列表</span>';
	html += '</div></div><div id="order-list"></div>';
	boxObj.append(html);

	var orderColumns = [ {field : 'amount_apply',title : '申请金额',width : '100',align : 'center'},
	                    {field : false,title : '申请比例',width : '100',align : 'center',formatter:function(result) {
								return Math.round(result.amount_apply / (result.supplier_cost - result.balance_money)*100 ,3)+'%';
		                    }
    					},
	             		{field : false,title : '订单号',width : '120',align : 'center',formatter:function(result) {
	             				return '<a href="/admin/a/orders/order/order_detail_info?id='+result.order_id+'" target="_blank">'+result.ordersn+'</a>';
		             		}
						},
	            		{field : 'linename',title : '产品名称',width : '170',align : 'center'},
	            		{field : 'usedate',title : '出团日期',width : '100',align : 'center'},
	            		{field : 'supplier_cost',title : '成本总计',align : 'center', width : '110'},
	            		{field : 'balance_money',title : '已结算',align : 'center', width : '80'},
	            		{field : false,title : '未结算',align : 'center', width : '80' ,formatter:function(result) {
								return Math.round(result.supplier_cost - result.balance_money ,2);
		            		}
	            		},
	            		{field : 'item_code',title : '团号',align : 'center', width : '120'}]
	            	
	$("#order-list").pageTable({
		columns:orderColumns,
		url:'/admin/a/union_finance/payable_apply/getPayableOrder',
		pageSize:10,
		searchForm:'#detail-form',
		tableClass:'table table-bordered table_hover',
		isStatistics:true,
		statisticsContent:'<span style="float: left;margin-top: 23px;">总计：<span style="color: rgb(255, 102, 0);font-size: 16px;font-weight: 700;">'+money+'</span>元</span>'
	});
}

function detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1020px', '600px'],
		  title :'供应商付款详细',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('/admin/a/union_finance/payable_apply/detail');?>"+"?id="+id
	});
}
//申请中
var columns0 = [ {field : 'addtime',title : '申请日期',width : '120',align : 'center'},
        		{field : 'amount',title : '申请付款金额',width : '120',align : 'center'},
        		{field : 'supplier_name',title : '供应商',width : '110',align : 'center'},
        		{field : 'union_name',title : '联盟单位',align : 'center', width : '140'},
        		{field : 'remark',title : '申请备注',align : 'center', width : '160'},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
            		}
        		}]

//旅行社通过 or 待付款
var columns1 = [ {field : 'addtime',title : '申请日期',width : '120',align : 'center'},
        		{field : 'amount',title : '申请付款金额',width : '120',align : 'center'},
        		{field : 'supplier_name',title : '供应商',width : '110',align : 'center'},
        		{field : 'union_name',title : '联盟单位',align : 'center', width : '140'},
        		{field : 'employee_name',title : '审核人',align : 'center', width : '140'},
        		{field : 'u_time',title : '审核日期',align : 'center', width : '140'},
        		{field : 'u_reply',title : '审核意见',align : 'center', width : '160'},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
						var button = '<a href="javascript:void(0);" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
						//button += '<a href="javascript:void(0);" onclick="detail('+result.id+' ,1)" class="action_type">付款</a>';
						return button;
            		}
        		}]

//旅行社拒绝
var columns2 = [ {field : 'addtime',title : '申请日期',width : '120',align : 'center'},
        		{field : 'amount',title : '申请付款金额',width : '120',align : 'center'},
        		{field : 'supplier_name',title : '供应商',width : '110',align : 'center'},
        		{field : 'union_name',title : '联盟单位',align : 'center', width : '140'},
        		{field : 'employee_name',title : '审核人',align : 'center', width : '160'},
        		{field : 'u_time',title : '审核日期',align : 'center', width : '160'},
        		{field : 'u_reply',title : '审核意见',align : 'center', width : '160'},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
            		}
        		}]


getData(0);
var searchObj = $('#search-condition');
$('.tab-nav').find('li').click(function(){
	var status = $(this).attr('data-val');
	searchObj.find('input[type=text]').val('');
	searchObj.find('input[name=status]').val(status);
	getData(status);
})
function getData(status ,page) {
	if (status == 0) {
		var columns = columns0;
		$('.u_time').hide();
	} else if (status == 1) {
		var columns = columns1;
		$('.u_time').show();
	} else if (status == 2) {
		var columns = columns2;
		$('.u_time').show();
	}
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/union_finance/payable_apply/getPayableApplyJson',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

$('#start_addtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#end_addtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#start_u_time').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#end_u_time').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
</script>
</html>


