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
            <a href="#">营业部结算管理</a>
        </div>
        
        <div class="page_content bg_gray">
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav">
                   		<li data-val="0"><a href="#" class="active">申请中</a></li> 
                        <li data-val="1"><a href="#" class="">已付款</a></li> 
                        <li data-val="2"><a href="#" class="">已拒绝</a></li>
                    </ul>
                </div>
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>申请人</label>
                                <input type="text" name="expert_name" class="search_input" placeholder="申请人"/>
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
    
<div class="order_detail" id="settlement-detail" style="display:none;">
	<form method="post" id="settlement-form">
		<input type="hidden" name="settlement_id" value="" />
	</form>
	<h2 class="lineName headline_txt">结算单详细</h2>
	
</div>  

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script>
function detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1100px', '600px'],
		  title :'旅行社信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/union_finance/depart_settlement/detail');?>"+"?id="+id
	});
}


//申请中
var columns0 = [ {field : 'addtime',title : '申请日期',width : '120',align : 'center'},
         		{field : 'amount',title : '申请金额',width : '120',align : 'center'},
         		{field : 'expert_name',title : '申请人',width : '110',align : 'center'},
         		{field : 'depart_name',title : '部门',align : 'center', width : '140'},
         		{field : 'union_name',title : '旅行社',align : 'center', width : '140'},
         		{field : 'reason',title : '申请备注',align : 'center', width : '160'},
         		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
 						return '<a href="javascript:void(0);" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
             		}
         		}]

//旅行社通过 or 待付款
var columns1 = [ {field : 'addtime',title : '申请日期',width : '120',align : 'center'},
        		{field : 'amount',title : '申请金额',width : '120',align : 'center'},
        		{field : 'expert_name',title : '申请人',width : '110',align : 'center'},
        		{field : 'depart_name',title : '部门',align : 'center', width : '140'},
        		{field : 'union_name',title : '旅行社',align : 'center', width : '140'},
        		{field : 'employee_name',title : '审核人',align : 'center', width : '140'},
        		{field : 'u_time',title : '审核日期',align : 'center', width : '140'},
        		{field : 'u_reason',title : '审核意见',align : 'center', width : '160'},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
						var button = '<a href="javascript:void(0);" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
						//button += '<a href="javascript:void(0);" onclick="detail('+result.id+' ,1)" class="action_type">付款</a>';
						return button;
            		}
        		}]

//旅行社拒绝
var columns2 = [ {field : 'addtime',title : '申请日期',width : '120',align : 'center'},
        		{field : 'amount',title : '申请金额',width : '120',align : 'center'},
        		{field : 'expert_name',title : '申请人',width : '110',align : 'center'},
        		{field : 'depart_name',title : '部门',align : 'center', width : '140'},
        		{field : 'union_name',title : '联盟单位',align : 'center', width : '140'},
        		{field : 'employee_name',title : '审核人',align : 'center', width : '160'},
        		{field : 'u_time',title : '审核日期',align : 'center', width : '160'},
        		{field : 'u_reason',title : '审核意见',align : 'center', width : '160'},
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
		url:'/admin/a/union_finance/depart_settlement/getDepartSettlementData',
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


