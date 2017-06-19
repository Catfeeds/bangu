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
		/*详情 end*/
		.layui-layer-page { margin-left:0px;}
		.batch-but{border: 1px solid #ccc;background: #fff;border-radius: 3px;cursor: pointer;}
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">交款管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="1"><a href="#" class="active">待转款</a></li> 
                        <li data-val="2"><a href="#" class="">已付款</a></li> 
                        <li data-val="3"><a href="#" class="">已拒绝</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>订单号</label>
                                <input type="text" name="ordersn" class="search_input" placeholder="订单号"/>
                            </div>
                            <div class="search_group">
                            	<label>交款人</label>
                                <input type="text" name="expert_name" class="search_input" placeholder="交款人"/>
                            </div>
                            <div class="search_group search-time">
                            	<label>收款日期</label>
                                <input type="text" name="starttime" class="search_input" id="starttime" placeholder="开始时间"/>
                                <input type="text" name="endtime" class="search_input" id="endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                            	<label>收款记录号</label>
                                <input type="text" name="voucher" class="search_input" placeholder="收款记录号"/>
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="status" value="1">
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
	<h2 class="lineName headline_txt">交款详细</h2>
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
                <div class="fg-input"><textarea name="remark" maxlength="150"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
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
function batch(obj) {
	var ids = '';
	$.each($(obj).parents('thead').next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		if (checkObj.attr('checked') == 'checked') {
			ids = checkObj.val()+','+ids;
		}
	})
	if (ids.length == 0) {
		layer.alert('请选择处理的数据', {icon: 2});
		return false;
	}
	
	window.top.openWin({
		  type: 2,
		  area: ['700px', '600px'],
		  title :'交款详细',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/union_finance/item_apply/detail');?>"+"?ids="+ids
	});
}

//确认只能选择同一联盟单位的
function isCheck(obj) {
	if ($(obj).attr('checked') != 'checked') {
		return false;
	}
	
	var union_id = $(obj).attr('data-union');
	
	var thisObj = $(obj);
	$.each($(obj).parents('tr').siblings() ,function(){
		var brotherObj = $(this).find('td').eq(0).find('input');
		
		if (brotherObj.attr('checked') == 'checked') {
			
			if (union_id != brotherObj.attr('data-union')) {
				layer.alert('只能选择同一联盟单位的', {icon: 2});
				thisObj.attr('checked' ,false);
			}
		}
	})
}

var columns1 = [{field : false,title : '<button class="batch-but" onclick="batch(this);">批量审核</button>',width : '100',align : 'center',formatter:function(result) {
						return '<input type="checkbox" onclick="isCheck(this)" data-union="'+result.union_id+'" name="item_id" value="'+result.id+'">';
					}
				},
                {field : false,title : '订单号',width : '120',align : 'center' ,formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="order_detail('+result.order_id+')" class="action_type">'+result.order_sn+'</a>';
					}
				},
                {field : 'voucher',title : '收款记录号',width : '160',align : 'center'},
        		{field : 'addtime',title : '收款日期',width : '160',align : 'center'},
        		{field : 'allow_money',title : '可请金额',width : '120',align : 'center'},
        		{field : 'already_money',title : '已请金额',width : '120',align : 'center'},
        		{field : 'money',title : '本次交款金额',width : '120',align : 'center'},
        		{field : 'total_price',title : '订单应收',align : 'center', width : '100'},
        		{field : 'way',title : '交款方式',align : 'center', width : '120'},
        		{field : 'unionName',title : '联盟单位',align : 'center', width : '150'},
        		{field : 'depart_name',title : '交款部门',align : 'center', width : '150'},
        		{field : 'expert_name',title : '交款人',align : 'center', width : '120'},
        		{field : false,title : '操作',align : 'center', width : '100',formatter:function(result) {
        				return '<a href="javascript:void(0)" onclick="detail('+result.id+' ,1)" class="action_type">查看详细</a>';
            		}
        		}];
        		
var columns2 = [{field : false,title : '<button class="batch-but" onclick="batch(this);">批量查看</button>',width : '100',align : 'center',formatter:function(result) {
						return '<input type="checkbox" onclick="isCheck(this)" data-union="'+result.union_id+'" name="item_id" value="'+result.id+'">';
					}
				},                
                {field : false,title : '订单号',width : '120',align : 'center' ,formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="order_detail('+result.order_id+')" class="action_type">'+result.order_sn+'</a>';
					}
				},
				{field : 'unionName',title : '联盟单位',align : 'center', width : '150'},
				{field : 'voucher',title : '收款记录号',width : '160',align : 'center'},
				{field : 'addtime',title : '收款日期',width : '160',align : 'center'},
				{field : 'allow_money',title : '可请金额',width : '160',align : 'center'},
        		{field : 'already_money',title : '已请金额',width : '160',align : 'center'},
				{field : 'money',title : '本次交款金额',width : '120',align : 'center'},
				{field : 'total_price',title : '订单应收',align : 'center', width : '100'},
				{field : 'way',title : '交款方式',align : 'center', width : '140'},
				{field : 'depart_name',title : '交款部门',align : 'center', width : '250'},
				{field : 'expert_name',title : '交款人',align : 'center', width : '250'},
				{field : false,title : '操作',align : 'center', width : '100',formatter:function(result) {
						return '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
					}
				}];
	
var columns3 = [ {field : false,title : '订单号',width : '120',align : 'center' ,formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="order_detail('+result.order_id+')" class="action_type">'+result.order_sn+'</a>';
					}
				},
				{field : 'voucher',title : '收款记录号',width : '160',align : 'center'},
				{field : 'addtime',title : '收款日期',width : '160',align : 'center'},
				{field : 'allow_money',title : '可请金额',width : '160',align : 'center'},
        		{field : 'already_money',title : '已请金额',width : '160',align : 'center'},
				{field : 'money',title : '本次交款金额',width : '120',align : 'center'},
				{field : 'total_price',title : '订单应收',align : 'center', width : '100'},
				{field : 'way',title : '交款方式',align : 'center', width : '140'},
				{field : 'depart_name',title : '交款部门',align : 'center', width : '250'},
				{field : 'expert_name',title : '交款人',align : 'center', width : '250'},
				{field : false,title : '操作',align : 'center', width : '100',formatter:function(result) {
						return '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
					}
				}];

getData(1);
var searchObj = $('#search-condition');
$('.tab-nav').find('li').click(function(){
	var status = $(this).attr('data-val');
	searchObj.find('input[type=text]').val('');
	searchObj.find('input[name=status]').val(status);
	getData(status);
})
function getData(status) {
	if (status == 1) {
		var columns = columns1;
	} else if (status == 2) {
		var columns = columns2;
	} else if (status == 3) {
		var columns = columns3;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/union_finance/item_apply/getItemApplyJson',
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
		  area: ['1000px', '600px'],
		  title :'交款详细',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/union_finance/item_apply/detail');?>"+"?ids="+id
	});
}

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


