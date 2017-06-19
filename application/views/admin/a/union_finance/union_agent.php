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
            <a href="#">旅行社佣金结算</a>
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
                            	<label>旅行社</label>
                                <input type="text" name="union_name" class="search_input" placeholder="旅行社名称"/>
                            </div>
                            <div class="search_group search-time">
                            	<label>申请时间</label>
                                <input type="text" name="starttime" class="search_input" id="starttime" placeholder="开始时间"/>
                                <input type="text" name="endtime" class="search_input" id="endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group search-time search_admin">
                            	<label>审核时间</label>
                                <input type="text" name="m_starttime" class="search_input" id="m_starttime" placeholder="开始时间"/>
                                <input type="text" name="m_endtime" class="search_input" id="m_endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                            	<label>申请人</label>
                                <input type="text" name="employee_name" class="search_input" placeholder="申请人"/>
                            </div>
                            <div class="search_group search_admin">
                            	<label>审核人</label>
                                <input type="text" name="admin_name" class="search_input" placeholder="审核人"/>
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
    
<div class="order_detail" id="detail-box" style="display:none;">
	<form method="post" id="detail-form">
		<input type="hidden" name="detail_id" value="" />
	</form>
	<h2 class="lineName headline_txt">结算单详细</h2>
</div>

<div class="fb-content" id="through-box" style="display:none;">
    <div class="box-title">
        <h4>通过申请</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="through-form" class="form-horizontal">
        	<div class="form-group">
                <div class="fg-title">结算金额：</div>
                <div class="fg-input"><input type="text" name="amount" value=""></div>
            </div>
            
            <div class="form-group">
                <input type="hidden" name="agent_id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<div class="fb-content" id="refuse-box" style="display:none;">
    <div class="box-title">
        <h4>拒绝申请</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="refuse-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">拒绝理由：</div>
                <div class="fg-input"><textarea name="reply" maxlength="150"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="agent_id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>

<script>
var columns1 = [ {field : 'union_name',title : '旅行社',width : '230',align : 'center'},
        		{field : 'employee_name',title : '申请人',width : '150',align : 'center'},
        		{field : 'amount',title : '申请结算金额',width : '170',align : 'center'},
        		{field : 'addtime',title : '申请时间',align : 'center', width : '120'},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
        				var button = '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
        				button += '<a href="javascript:void(0)" onclick="detail('+result.id+' ,1)" class="action_type">审核</a>';
        				return button;
            		}
        		}]
        		
var columns2 = [ {field : 'union_name',title : '旅行社',width : '230',align : 'center'},
         		{field : 'employee_name',title : '申请人',width : '120',align : 'center'},
         		{field : 'amount',title : '申请结算金额',width : '150',align : 'center'},
         		{field : 'admin_name',title : '审核人',align : 'center', width : '120'},
         		{field : 'modtime',title : '审核时间',align : 'center', width : '120'},
         		{field : 'reply',title : '审核回复',align : 'center', width : '160'},
         		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
         				return '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
             		}
         		}]
	
var columns3 = [ {field : 'union_name',title : '旅行社',width : '230',align : 'center'},
          		{field : 'employee_name',title : '申请人',width : '100',align : 'center'},
          		{field : 'amount',title : '申请结算金额',width : '120',align : 'center'},
          		{field : 'admin_name',title : '审核人',align : 'center', width : '100'},
          		{field : 'modtime',title : '审核时间',align : 'center', width : '120'},
          		{field : 'reply',title : '审核回复',align : 'center', width : '200'},
          		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
          				return '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
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
function getData(status) {
	if (status == 0) {
		var columns = columns1;
		$('.search_admin').hide();
	} else if (status == 1) {
		var columns = columns2;
		$('.search_admin').show();
	} else if (status == 2) {
		var columns = columns3;
		$('.search_admin').show();
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/union_finance/union_agent/getUnionAgentJson',
		pageSize:10,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

function detail(id ,type) {
	$.ajax({
		url:'/admin/a/union_finance/union_agent/detail',
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
							{title:'旅行社',content : result.union_name ,type:'all'},
							{title:'申请人',content : result.employee_name},
							{title:'申请时间',content : result.addtime},
							{title:'申请结算金额',content : result.amount},
							{title:'实际结算金额',content : result.real_amount}
						];
				createDetailTab('基础信息' ,columnData ,$('#detail-box'));
				
				//关联订单
				getSettlementOrder(result.id ,$('#detail-box') ,result.amount);
				//按钮
				if (result.status == 0 && type == 1) {
					createDetailBut({'through-but':'通过','refuse-but':'拒绝','layui-layer-close':'关闭'} ,$('#detail-box'));
					but_click(id ,result.amount);
				} else {
					createDetailBut({'layui-layer-close':'关闭'} ,$('#detail-box'));
				}
				layer.open({
					  type: 1,
					  title: false,
					  closeBtn: 0,
					  area: ['900px' ,'560px'],
					  shadeClose: false,
					  content: $('#detail-box')
				});
			}
		}
	});
}
//结算单订单获取
function getSettlementOrder(id ,boxObj ,money) {
	$('#detail-form').find('input[name=detail_id]').val(id);
	var html = '<div class="content_part"><div class="small_title_txt clear"><span class="txt_info fl">订单列表</span>';
	html += '</div></div><div id="order-list"></div>';
	boxObj.append(html);

	var orderColumns = [{field : 'money',title : '申请结算金额',width : '100',align : 'center'}, 
	                    {field : 'union_balance',title : '已结算金额',width : '100',align : 'center'}, 
	                	{field : false,title : '佣金总计',width : '100',align : 'center' ,formatter:function(result) {
								return (result.diplomatic_agent*1 + result.platform_fee *1).toFixed(2);
							}
						},
						{field : false,title : '订单号',width : '120',align : 'center',formatter:function(result) {
								return '<a href="/admin/a/orders/order/order_detail_info?id='+result.order_id+'" target="_blank">'+result.ordersn+'</a>';
		             		}
						},
	                    {field : 'usedate',title : '出团日期',width : '100',align : 'center'},
	                    {field : 'supplier_cost',title : '成本总计',width : '100',align : 'center'},
	            		{field : false,title : '订单金额',width : '170',align : 'center' ,formatter:function(result) {
	            				return (result.total_price*1 + result.settlement_price*1).toFixed(2);
		            		}
	            		},
	            		{field : 'item_code',title : '团号',align : 'center', width : '120'}]
	            	
	$("#order-list").pageTable({
		columns:orderColumns,
		url:'/admin/a/union_finance/union_agent/getAgentOrder',
		pageSize:10,
		searchForm:'#detail-form',
		tableClass:'table table-bordered table_hover',
		isStatistics:true,
		statisticsContent:'<span style="float: left;margin-top: 23px;">总计：<span style="color: rgb(255, 102, 0);font-size: 16px;font-weight: 700;">'+money+'</span>元</span>'
	});
}

function but_click(id ,money) {
	var t = true;
	$('.through-but').click(function(){
// 		$('#through-form').find('input[name=amount]').val(money);
// 		$('#through-form').find('input[name=agent_id]').val(id);
// 		layer.open({
// 			  type: 1,
// 			  title: false,
// 			  closeBtn: 0,
// 			  area: '560px',
// 			  shadeClose: false,
// 			  content: $('#through-box')
// 		});
		if (t == false) {
			return false;
		} else {
			t = false;
		}
		$.ajax({
			url:'/admin/a/union_finance/union_agent/through',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(result) {
				t = true;
				if (result.code == 2000) {
					$('.layui-layer-close').trigger('click');
					layer.alert(result.msg, {icon: 1});
					getData(1);
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
	})
	$('.refuse-but').click(function(){
		$('#refuse-form').find('input[name=agent_id]').val(id);
		layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '560px',
			  shadeClose: false,
			  content: $('#refuse-box')
		});
	})
}
var t = true;
$('#through-form').submit(function() {
	if (t == false) {
		return false;
	} else {
		t = false;
	}
	$.ajax({
		url:'/admin/a/union_finance/union_agent/through',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		complete:function(){//ajax请求结束时操作
			t = true;
		},
		success:function(result) {
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
				getData(1);
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
var ts = true;
$('#refuse-form').submit(function() {
	if (ts == false) {
		return false;
	} else {
		ts = false;
	}
	$.ajax({
		url:'/admin/a/union_finance/union_agent/refuse',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		complete:function(){//ajax请求结束时操作
			ts = true;
		},
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
	return false;
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
</script>
</html>


