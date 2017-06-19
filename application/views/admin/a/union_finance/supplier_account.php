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
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">供应商结算</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav">
                        <li data-val="0"><a href="#" class="active">申请中</a></li> 
                        <li data-val="1"><a href="#" class="">旅行社已通过</a></li> 
                        <li data-val="3"><a href="#" class="">平台已通过</a></li> 
                        <li data-val="2"><a href="#" class="">旅行社拒绝</a></li> 
                        <li data-val="4"><a href="#" class="">平台拒绝</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>供应商</label>
                                <input type="text" name="supplier_name" class="search_input" placeholder="供应商名称"/>
                            </div>
                            <div class="search_group search-time">
                            	<label>申请时间</label>
                                <input type="text" name="starttime" class="search_input" id="starttime" placeholder="开始时间"/>
                                <input type="text" name="endtime" class="search_input" id="endtime" placeholder="结束时间"/>
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
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script>
var columns1 = [ {field : 'supplier_name',title : '供应商名称',width : '120',align : 'center'},
        		{field : 'amount',title : '申请结算金额',width : '120',align : 'center'},
        		{field : 'addtime',title : '申请时间',width : '100',align : 'center'},
        		{field : 'bank',title : '银行卡号',align : 'center', width : '120'},
        		{field : 'bankname',title : '银行名称',align : 'center', width : '120'},
        		{field : 'remark',title : '申请备注',align : 'center', width : '120'},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
						return '<a href="/admin/a/union_finance/supplier_account/detail?id='+result.id+'" target="_blank" class="action_type">查看详细</a>';;
            		}
        		}]
        		
var columns2 = [ {field : 'supplier_name',title : '供应商名称',width : '120',align : 'center'},
         		{field : 'amount',title : '申请结算金额',width : '120',align : 'center'},
         		{field : 'addtime',title : '申请时间',width : '100',align : 'center'},
         		{field : 'bank',title : '银行卡号',align : 'center', width : '120'},
         		{field : 'bankname',title : '银行名称',align : 'center', width : '120'},
         		{field : 'union_name',title : '旅行社',align : 'center', width : '120'},
         		{field : 'employee_name',title : '旅行社审核人',align : 'center', width : '120'},
         		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
 						return '<a href="/admin/a/union_finance/supplier_account/detail?id='+result.id+'" target="_blank" class="action_type">查看详细</a>';;
             		}
         		}]
	
var columns3 = [ {field : 'supplier_name',title : '供应商名称',width : '120',align : 'center'},
          		{field : 'amount',title : '申请结算金额',width : '120',align : 'center'},
          		{field : 'addtime',title : '申请时间',width : '100',align : 'center'},
          		{field : 'bank',title : '银行卡号',align : 'center', width : '120'},
          		{field : 'bankname',title : '银行名称',align : 'center', width : '120'},
          		{field : 'union_name',title : '旅行社',align : 'center', width : '120'},
          		{field : 'employee_name',title : '旅行社审核人',align : 'center', width : '120'},
          		{field : 'e_reply',title : '旅行社回复',align : 'center', width : '120'},
          		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
  						return '<a href="/admin/a/union_finance/supplier_account/detail?id='+result.id+'" target="_blank" class="action_type">查看详细</a>';;
              		}
          		}]
var columns4 = [ {field : 'supplier_name',title : '供应商名称',width : '120',align : 'center'},
           		{field : 'amount',title : '申请结算金额',width : '120',align : 'center'},
           		{field : 'addtime',title : '申请时间',width : '100',align : 'center'},
           		{field : 'bank',title : '银行卡号',align : 'center', width : '120'},
           		{field : 'bankname',title : '银行名称',align : 'center', width : '120'},
           		{field : 'union_name',title : '旅行社',align : 'center', width : '120'},
           		{field : 'employee_name',title : '旅行社审核人',align : 'center', width : '120'},
           		{field : 'employee_name',title : '平台审核人',align : 'center', width : '120'},
           		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
   						return '<a href="/admin/a/union_finance/supplier_account/detail?id='+result.id+'" target="_blank" class="action_type">查看详细</a>';;
               		}
           		}]
	
var columns5 = [ {field : 'supplier_name',title : '供应商名称',width : '120',align : 'center'},
            		{field : 'amount',title : '申请结算金额',width : '120',align : 'center'},
            		{field : 'addtime',title : '申请时间',width : '100',align : 'center'},
            		{field : 'bank',title : '银行卡号',align : 'center', width : '120'},
            		{field : 'bankname',title : '银行名称',align : 'center', width : '120'},
            		{field : 'union_name',title : '旅行社',align : 'center', width : '120'},
            		{field : 'employee_name',title : '旅行社审核人',align : 'center', width : '120'},
            		{field : 'admin_name',title : '平台审核人',align : 'center', width : '120'},
            		{field : 'a_reply',title : '平台回复',align : 'center', width : '120'},
            		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
    						return '<a href="/admin/a/union_finance/supplier_account/detail?id='+result.id+'" target="_blank" class="action_type">查看详细</a>';;
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
		$('.search-time').find('label').html('申请时间');
	} else if (status == 1) {
		var columns = columns2;
		$('.search-time').find('label').html('审核时间');
	} else if (status == 2) {
		var columns = columns3;
		$('.search-time').find('label').html('审核时间');
	} else if (status == 3) {
		var columns = columns4;
		$('.search-time').find('label').html('审核时间');
	} else if (status == 4) {
		var columns = columns5;
		$('.search-time').find('label').html('审核时间');
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/union_finance/supplier_account/getSupplierAccount',
		pageSize:10,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
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
</script>
</html>


